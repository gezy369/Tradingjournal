<!-- ------------------------------------------------------------------------------------
DB operation triggered by $_POST variables
---------------------------------------------------------------------------------------->
<?php
// ----------------------------------------------------------------------------------- //
// Variables.
// ----------------------------------------------------------------------------------- //

$nbroftrades = 7; //max number of daily trade possible

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
// Trades DB operation. Act for the trading journal.
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

  $pos_main = 0;  //initiate positive trades count
  $neg_main = 0;  //initiate negative trades count

  //count the trades
  for ($i = 1; $i <= $nbroftrades; $i++) {
    if ($_POST['main_pts0'.$i] > 0) { //count the winning trades
      $pos_main++;
    }elseif ($_POST['main_pts0'.$i] < 0) { //count the losing trades
      $neg_main++;
    }
  }

  //calculate the P/L
  $totpospoints = 0;
  $totnegpoints = 0;
  $totposcontracts = 0;
  $totnegcontracts = 0;
  $profit = 0;
  $loss = 0;
  $fees = 3.98; //fee per contract in and out
  $benefit = 50; //dollar amount per points earned

  for ($i = 1; $i <= $nbroftrades; $i++) {
    if ($_POST['main_pts0'.$i] > 0) {
      //add the points to the positive total
      $totpospoints = $totpospoints + $_POST['main_pts0'.$i];
      //add the contracts to the positive total
      $totposcontracts = $totposcontracts + abs($_POST['main_cnt0'.$i]); // abs() returns the absolute value : ex. -4 become 4
    }elseif ($_POST['main_pts0'.$i] < 0) {
      //add the points to the negative total
      $totnegpoints = $totnegpoints + $_POST['main_pts0'.$i];
      //add the contracts to the negative total
      $totnegcontracts = $totnegcontracts + abs($_POST['main_cnt0'.$i];) // abs() returns the absolute value : ex. -4 become 4
    }
  }
  $gain = (($totpospoints * $benefit) * $totposcontracts);
  $loss = (($totnegpoints * $benefit) * $totnegcontracts);
  $cost = $fees * ($totposcontracts + $totnegcontracts);


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
// Pass the current account ID further
session_start();
$_SESSION['current_selected_account'] = $_POST['current_account'];
?>
