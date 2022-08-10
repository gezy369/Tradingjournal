<!-- ------------------------------------------------------------------------------------
DB operation triggered by $_POST variables
---------------------------------------------------------------------------------------->
<?php
// ----------------------------------------------------------------------------------- //
// Variables.
// ----------------------------------------------------------------------------------- //

$nbroftrades = 10; //max number of daily trade possible
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
    $main_cnt1   = $_POST['main_cnt1'];
    $runner_cnt1 = $_POST['runner_cnt1'];
    $main_cnt2   = $_POST['main_cnt2'];
    $runner_cnt2 = $_POST['runner_cnt2'];
    $main_cnt3   = $_POST['main_cnt3'];
    $runner_cnt3 = $_POST['runner_cnt3'];
    $main_cnt4   = $_POST['main_cnt4'];
    $runner_cnt4 = $_POST['runner_cnt4'];
    $main_cnt5   = $_POST['main_cnt5'];
    $runner_cnt5 = $_POST['runner_cnt5'];
    $main_cnt6   = $_POST['main_cnt6'];
    $runner_cnt6 = $_POST['runner_cnt6'];
    $main_cnt7   = $_POST['main_cnt7'];
    $runner_cnt7 = $_POST['runner_cnt7'];
    $main_pts1   = $_POST['main_pts1'];
    $runner_pts1 = $_POST['runner_pts1'];
    $main_pts2   = $_POST['main_pts2'];
    $runner_pts2 = $_POST['runner_pts2'];
    $main_pts3   = $_POST['main_pts3'];
    $runner_pts3 = $_POST['runner_pts3'];
    $main_pts4   = $_POST['main_pts4'];
    $runner_pts4 = $_POST['runner_pts4'];
    $main_pts5   = $_POST['main_pts5'];
    $runner_pts5 = $_POST['runner_pts5'];
    $main_pts6   = $_POST['main_pts6'];
    $runner_pts6 = $_POST['runner_pts6'];
    $main_pts7   = $_POST['main_pts7'];
    $runner_pts7 = $_POST['runner_pts7'];
    $main_pts8   = $_POST['main_pts8'];
    $runner_pts8 = $_POST['runner_pts8'];
    $main_pts9   = $_POST['main_pts9'];
    $runner_pts9 = $_POST['runner_pts9'];
    $main_pts10   = $_POST['main_pts10'];
    $runner_pts10 = $_POST['runner_pts10'];
    $trade_id     = $_POST['trade_id'];



    //calculate the P/L
    for ($i = 1; $i <= $nbroftrades; $i++) {
        
        if ($_POST['main_pts'.$i] > 0) {

            //Calculate P&L per green trade
            $tradePL = abs($_POST['main_cnt'.$i]) * ($_POST['main_pts'.$i] * $benefitPerPoint);
            $gain = $gain + $tradePL;
            $pos_main ++;

        }elseif ($_POST['main_pts'.$i] <= 0 AND $_POST['main_cnt'.$i] != 0) {
            
            //Calculate P&L per red trade. Had to test contract to be able to to 0 points into account
            $tradePL = abs($_POST['main_cnt'.$i]) * ($_POST['main_pts'.$i] * $benefitPerPoint);
            $loss = $loss + $tradePL;
            $neg_main ++;
        }

        //Increment total contracts for fee calculation
        $total_contracts = $total_contracts + abs($_POST['main_cnt'.$i]);

    }

    $cost = $fees * $total_contracts;

    //SQL query
    $sql = "UPDATE trades SET
    pos_tr_count  ='$pos_main',
    neg_tr_count  ='$neg_main',
    main_cnt1    ='$main_cnt1',
    runner_cnt1  ='$runner_cnt1',
    main_cnt2    ='$main_cnt2',
    runner_cnt2  ='$runner_cnt2',
    main_cnt3    ='$main_cnt3',
    runner_cnt3  ='$runner_cnt3',
    main_cnt4    ='$main_cnt4',
    runner_cnt4  ='$runner_cnt4',
    main_cnt5    ='$main_cnt5',
    runner_cnt5  ='$runner_cnt5',
    main_cnt6    ='$main_cnt6',
    runner_cnt6  ='$runner_cnt6',
    main_cnt7    ='$main_cnt7',
    runner_cnt7  ='$runner_cnt7',
    main_pts1    ='$main_pts1',
    runner_pts1  ='$runner_pts1',
    main_pts2    ='$main_pts2',
    runner_pts2  ='$runner_pts2',
    main_pts3    ='$main_pts3',
    runner_pts3  ='$runner_pts3',
    main_pts4    ='$main_pts4',
    runner_pts4  ='$runner_pts4',
    main_pts5    ='$main_pts5',
    runner_pts5  ='$runner_pts5',
    main_pts6    ='$main_pts6',
    runner_pts6  ='$runner_pts6',
    main_pts7    ='$main_pts7',
    runner_pts7  ='$runner_pts7',
    main_pts8    ='$main_pts8',
    runner_pts8  ='$runner_pts8',
    main_pts9    ='$main_pts9',
    runner_pts9  ='$runner_pts9',
    main_pts10    ='$main_pts10',
    runner_pts10  ='$runner_pts10',
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
  $main_cnt1   = $_POST['main_cnt1'];
  $runner_cnt1 = $_POST['runner_cnt1'];
  $main_cnt2   = $_POST['main_cnt2'];
  $runner_cnt2 = $_POST['runner_cnt2'];
  $main_cnt3   = $_POST['main_cnt3'];
  $runner_cnt3 = $_POST['runner_cnt3'];
  $main_cnt4   = $_POST['main_cnt4'];
  $runner_cnt4 = $_POST['runner_cnt4'];
  $main_cnt5   = $_POST['main_cnt5'];
  $runner_cnt5 = $_POST['runner_cnt5'];
  $main_pts1   = $_POST['main_pts1'];
  $runner_pts1 = $_POST['runner_pts1'];
  $main_pts2   = $_POST['main_pts2'];
  $runner_pts2 = $_POST['runner_pts2'];
  $main_pts3   = $_POST['main_pts3'];
  $runner_pts3 = $_POST['runner_pts3'];
  $main_pts4   = $_POST['main_pts4'];
  $runner_pts4 = $_POST['runner_pts4'];
  $main_pts5   = $_POST['main_pts5'];
  $runner_pts5 = $_POST['runner_pts5'];
  $main_pts6   = $_POST['main_pts6'];
  $runner_pts6 = $_POST['runner_pts6'];
  $main_pts7   = $_POST['main_pts7'];
  $runner_pts7 = $_POST['runner_pts7'];
  $main_pts8   = $_POST['main_pts8'];
  $runner_pts8 = $_POST['runner_pts8'];
  $main_pts9   = $_POST['main_pts9'];
  $runner_pts9 = $_POST['runner_pts9'];
  $main_pts10   = $_POST['main_pts10'];
  $runner_pts10 = $_POST['runner_pts10'];
  $trade_date   = $_POST['trade_date'];
  $account      = $_POST['current_account']; 

  $sql = "INSERT INTO trades
  (main_cnt1,
  runner_cnt1,
  main_cnt2,
  runner_cnt2,
  main_cnt03,
  runner_cnt3,
  main_cnt4,
  runner_cnt4,
  main_cnt5,
  runner_cnt5,
  main_pts1,
  runner_pts1,
  main_pts2,
  runner_pts2,
  main_pts3,
  runner_pts3,
  main_pts4,
  runner_pts4,
  main_pts5,
  runner_pts5,
  main_pts6,
  runner_pts6,
  main_pts7,
  runner_pts7,
  main_pts8,
  runner_pts8,
  main_pts9,
  runner_pts9,
  main_pts10,
  runner_pts10,
  trade_date,
  acc_fid)
  VALUES(
  '$main_cnt1',
  '$runner_cnt1',
  '$main_cnt2',
  '$runner_cnt2',
  '$main_cnt3',
  '$runner_cnt3',
  '$main_cnt4',
  '$runner_cnt4',
  '$main_cnt5',
  '$runner_cnt5',
  '$main_pts1', 
  '$runner_pts1',
  '$main_pts2', 
  '$runner_pts2',
  '$main_pts3',
  '$runner_pts3',
  '$main_pts4',
  '$runner_pts4',
  '$main_pts5',
  '$runner_pts5',
  '$main_pts6',
  '$runner_pts6',
  '$main_pts7',
  '$runner_pts7',
  '$main_pts8',
  '$runner_pts8',
  '$main_pts9',
  '$runner_pts9',
  '$main_pts10',
  '$runner_pts10',
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
// Emotion soother
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
