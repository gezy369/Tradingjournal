<!-- ------------------------------------------------------------------------------------
DB operation triggered by $_POST variables
---------------------------------------------------------------------------------------->
<?php
// ----------------------------------------------------------------------------------- //
// Variables.
// ----------------------------------------------------------------------------------- //

$nbroftrades = 7; //max number of daily trade possible
$loss = 0;
$gain = 0;
$pos_main = 0;  //initiate positive trades count
$neg_main = 0;  //initiate negative trades count
$total_contracts = 0;
$fees = 3.98; //fee per contract in and out
$benefitPerPoint = 50; //dollar amount per points earned

if (isset($_POST['current_account_id'])){ //allows to display the same account data after insrte or update of the table
  $_SESSION['current_selected_account'] = $_POST['current_account_id'];
}else{
  $_POST['current_account_id'] = $_SESSION['current_selected_account'];
}

// ----------------------------------------------------------------------------------- //
// Account DB operation.
// ----------------------------------------------------------------------------------- //

// INSERT ACCOUNT
if (isset($_POST['new_account_name']) AND $_POST['new_account_name'] != "") {
  $acc_name = $_POST['new_account_name'];
  $sql = "INSERT INTO accounts (acc_name, user_fid)
  VALUES ('$acc_name', '1')";

  if ($conn->query($sql) === TRUE) {
    echo "New account created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}  

// UPDATE ACCOUNT
if (isset($_POST['updated_acc_name']) AND $_POST['updated_acc_name'] != "") {
  $updated_acc_name = $_POST['updated_acc_name'];
  $updated_acc_id = $_POST['account_selection_to_update'];

  $sql = "UPDATE accounts SET acc_name='$updated_acc_name' WHERE id='$updated_acc_id'";

  if ($conn->query($sql) === TRUE) {
    echo "Account updated successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}  

// DELETE ACCOUNT
if (isset($_POST['delete']) AND $_POST['delete'] != "") {
  $updated_acc_id = $_POST['account_selection_to_update'];

  //$updated_acc_id = filter_input(INPUT_POST, 'account_selection_to_update', FILTER_SANITIZE_STRING);

  $sql = "DELETE FROM accounts WHERE id='$updated_acc_id'";

  if ($conn->query($sql) === TRUE) {
    echo "Account deleted successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}  

// ----------------------------------------------------------------------------------- //
//  Trades DB operation. Act for the trading journal.
// ----------------------------------------------------------------------------------- //

// UPDATE TRADES
if (isset($_POST['edit_trade'])) {
    $main_cnt01   = $_POST['main_cnt01'];
    $runner_cnt01 = $_POST['runner_cnt01'];
    $main_cnt02   = $_POST['main_cnt02'];
    $runner_cnt02 = $_POST['runner_cnt02'];
    $main_cnt03   = $_POST['main_cnt03'];
    $runner_cnt03 = $_POST['runner_cnt03'];
    $main_cnt04   = $_POST['main_cnt04'];
    $runner_cnt04 = $_POST['runner_cnt04'];
    $main_cnt05   = $_POST['main_cnt05'];
    $runner_cnt05 = $_POST['runner_cnt05'];
    $main_cnt06   = $_POST['main_cnt06'];
    $runner_cnt06 = $_POST['runner_cnt06'];
    $main_cnt07   = $_POST['main_cnt07'];
    $runner_cnt07 = $_POST['runner_cnt07'];
    $main_pts01   = $_POST['main_pts01'];
    $runner_pts01 = $_POST['runner_pts01'];
    $main_pts02   = $_POST['main_pts02'];
    $runner_pts02 = $_POST['runner_pts02'];
    $main_pts03   = $_POST['main_pts03'];
    $runner_pts03 = $_POST['runner_pts03'];
    $main_pts04   = $_POST['main_pts04'];
    $runner_pts04 = $_POST['runner_pts04'];
    $main_pts05   = $_POST['main_pts05'];
    $runner_pts05 = $_POST['runner_pts05'];
    $main_pts06   = $_POST['main_pts06'];
    $runner_pts06 = $_POST['runner_pts06'];
    $main_pts07   = $_POST['main_pts07'];
    $runner_pts07 = $_POST['runner_pts07'];
    $trade_id     = $_POST['trade_id'];



    //calculate the P/L
    for ($i = 1; $i <= $nbroftrades; $i++) {
        
        if ($_POST['main_pts0'.$i] > 0) {

            //Calculate P&L per green trade
            $tradePL = abs($_POST['main_cnt0'.$i]) * ($_POST['main_pts0'.$i] * $benefitPerPoint);
            $gain = $gain + $tradePL;
            $pos_main ++;

        }elseif ($_POST['main_pts0'.$i] <= 0 AND $_POST['main_cnt0'.$i] != 0) {
            
            //Calculate P&L per red trade. Had to test contract to be able to to 0 points into account
            $tradePL = abs($_POST['main_cnt0'.$i]) * ($_POST['main_pts0'.$i] * $benefitPerPoint);
            $loss = $loss + $tradePL;
            $neg_main ++;
        }

        //Increment total contracts for fee calculation
        $total_contracts = $total_contracts + abs($_POST['main_cnt0'.$i]);

    }

    $cost = $fees * $total_contracts;

    //SQL query
    $sql = "UPDATE trades SET
    pos_tr_count  ='$pos_main',
    neg_tr_count  ='$neg_main',
    main_cnt01    ='$main_cnt01',
    runner_cnt01  ='$runner_cnt01',
    main_cnt02    ='$main_cnt02',
    runner_cnt02  ='$runner_cnt02',
    main_cnt03    ='$main_cnt03',
    runner_cnt03  ='$runner_cnt03',
    main_cnt04    ='$main_cnt04',
    runner_cnt04  ='$runner_cnt04',
    main_cnt05    ='$main_cnt05',
    runner_cnt05  ='$runner_cnt05',
    main_cnt06    ='$main_cnt06',
    runner_cnt06  ='$runner_cnt06',
    main_cnt07    ='$main_cnt07',
    runner_cnt07  ='$runner_cnt07',
    main_pts01    ='$main_pts01',
    runner_pts01  ='$runner_pts01',
    main_pts02    ='$main_pts02',
    runner_pts02  ='$runner_pts02',
    main_pts03    ='$main_pts03',
    runner_pts03  ='$runner_pts03',
    main_pts04    ='$main_pts04',
    runner_pts04  ='$runner_pts04',
    main_pts05    ='$main_pts05',
    runner_pts05  ='$runner_pts05',
    main_pts06    ='$main_pts06',
    runner_pts06  ='$runner_pts06',
    main_pts07    ='$main_pts07',
    runner_pts07  ='$runner_pts07',
    gain          ='$gain',
    loss          ='$loss',
    costs         ='$cost'
    WHERE id='$trade_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Trade updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}  

// INSERT TRADES
if (isset($_POST['new_trade'])) {
  $main_cnt01   = $_POST['main_cnt01'];
  $runner_cnt01 = $_POST['runner_cnt01'];
  $main_cnt02   = $_POST['main_cnt02'];
  $runner_cnt02 = $_POST['runner_cnt02'];
  $main_cnt03   = $_POST['main_cnt03'];
  $runner_cnt03 = $_POST['runner_cnt03'];
  $main_cnt04   = $_POST['main_cnt04'];
  $runner_cnt04 = $_POST['runner_cnt04'];
  $main_cnt05   = $_POST['main_cnt05'];
  $runner_cnt05 = $_POST['runner_cnt05'];
  $main_pts01   = $_POST['main_pts01'];
  $runner_pts01 = $_POST['runner_pts01'];
  $main_pts02   = $_POST['main_pts02'];
  $runner_pts02 = $_POST['runner_pts02'];
  $main_pts03   = $_POST['main_pts03'];
  $runner_pts03 = $_POST['runner_pts03'];
  $main_pts04   = $_POST['main_pts04'];
  $runner_pts04 = $_POST['runner_pts04'];
  $main_pts05   = $_POST['main_pts05'];
  $runner_pts05 = $_POST['runner_pts05'];
  $main_pts06   = $_POST['main_pts06'];
  $runner_pts06 = $_POST['runner_pts06'];
  $main_pts07   = $_POST['main_pts07'];
  $runner_pts07 = $_POST['runner_pts07'];
  $trade_date   = $_POST['trade_date'];
  $account      = $_POST['current_account']; 

  $sql = "INSERT INTO trades
  (main_cnt01,
  runner_cnt01,
  main_cnt02,
  runner_cnt02,
  main_cnt03,
  runner_cnt03,
  main_cnt04,
  runner_cnt04,
  main_cnt05,
  runner_cnt05,
  main_pts01,
  runner_pts01,
  main_pts02,
  runner_pts02,
  main_pts03,
  runner_pts03,
  main_pts04,
  runner_pts04,
  main_pts05,
  runner_pts05,
  main_pts06,
  runner_pts06,
  main_pts07,
  runner_pts07,
  trade_date,
  acc_fid)
  VALUES(
  '$main_cnt01',
  '$runner_cnt01',
  '$main_cnt02',
  '$runner_cnt02',
  '$main_cnt03',
  '$runner_cnt03',
  '$main_cnt04',
  '$runner_cnt04',
  '$main_cnt05',
  '$runner_cnt05',
  '$main_pts01', 
  '$runner_pts01',
  '$main_pts02', 
  '$runner_pts02',
  '$main_pts03',
  '$runner_pts03',
  '$main_pts04',
  '$runner_pts04',
  '$main_pts05',
  '$runner_pts05',
  '$main_pts06',
  '$runner_pts06',
  '$main_pts07',
  '$runner_pts07',
  '$trade_date',
  '$account')";
//acount ID here !!
  if ($conn->query($sql) === TRUE) {
    echo "Trade added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}  

// ----------------------------------------------------------------------------------- //
// Trades DB operation. Act for the user preferences.
// ----------------------------------------------------------------------------------- //
if (isset($_POST['pl_switch_on'])) {
  $emotion_soother_on = $_POST['pl_switch_on'];

  $sql = "UPDATE users SET pl='$emotion_soother_on' WHERE id='1'";

  if ($conn->query($sql) === TRUE) {
    echo "Emotion soother ON";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}elseif (isset($_POST['pl_switch_off'])) {
  $emotion_soother_off = $_POST['pl_switch_off'];

  $sql = "UPDATE users SET pl='$emotion_soother_off' WHERE id='1'";

  if ($conn->query($sql) === TRUE) {
    echo "Emotion soother OFF";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
?>
