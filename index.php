<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
      session_start();
    ?>
    <!-- REFERENCES -------------------------------------------------------------------------->
    <!-- <script src="https://code.jquery.com/jquery-1.7.2.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="./javascript/scripts.js"></script>
    <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js"></script>
    <link href="./css/main.css" rel="stylesheet"/>
    <link href="./css/table.css" rel="stylesheet"/>
    <link href="./css/flexbox.css" rel="stylesheet"/>
    <?php
    require __DIR__ . '/functions/functions.php';
    require __DIR__ . '/db/db_conn.php';
    require __DIR__ . '/db/operations.php';  
    error_reporting (E_ALL ^ E_NOTICE); // avoid index errors ?>

    <!-- END ---------------------------------------------------------------------------------- -->

    <script>

    // ----------------------------------------------------------------------------------- //
    // opens P/L detail popup
    // ----------------------------------------------------------------------------------- //
    // When the user clicks on div, open the popup
    function openDetails(spanid) {
      var popup = document.getElementById(arguments[0]);
      popup.classList.toggle("show");
    }

    </script>
  
    <style>
      .popup {
        position: relative;
        display: inline-block;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      /* The actual popup */
      .popup .popuptext {
        visibility: hidden;
        width: 160px;
        background-color: #555;
        color: #fff;
        text-align: left;
        border-radius: 6px;
        padding: 8px 10px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        margin-left: -80px;
      }

      /* Popup arrow */
      .popup .popuptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #555 transparent transparent transparent;
      }

      /* Toggle this class - hide and show the popup */
      .popup .show {
        visibility: visible;
        -webkit-animation: fadeIn 1s;
        animation: fadeIn 1s;
      }

      /* Add animation (fade in the popup) */
      @-webkit-keyframes fadeIn {
        from {opacity: 0;} 
        to {opacity: 1;}
      }

      @keyframes fadeIn {
        from {opacity: 0;}
        to {opacity:1 ;}
      }
      /*  https://css-tricks.com/examples/hrs/ */*
      .popup hr{
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #999999, #f2f2f2, #999999);
      }

    </style>
  </head>
  <body>
    <!-- ----------------------------------------------------------------------------------------------------------->
    <!--  PHP variables init. -->
    <!-- ----------------------------------------------------------------------------------------------------------->
    <?php
    $tr = 0;         //used to display weekends in the journal table
    $btnID = 0;      //used for button IDs in the trade journal
    $popupID = 0;    //allow to display the details popup at the right place
    $current_account_id = $_POST['current_account_id'];
    ?>
    <!-- ----------------------------------------------------------------------------------------------------------->
    <!--  PHP Get the user profile informations -->
    <!-- ----------------------------------------------------------------------------------------------------------->
    <?php
      $sql = "SELECT * FROM users WHERE email = 'sir.gezy@gmail.com'";
      $result = $conn->query($sql);
      $userprofile = $result->fetch_assoc();
    ?>
<!-- **************************************************** POPUPS **************************************************** -->
    
    <!-- ----------------------------------------------------------------------------------------------------------->
    <!--  New account creation popup -->
    <!-- ----------------------------------------------------------------------------------------------------------->
    <div class="login-popup">
      <div class="form-popup" id="popupFormCreate">
        <form class="form-container" action="" method="post">
          <h2>Create a new account</h2>         
          <label for="Account name">Account Name </label>
          <input type="text" name="new_account_name">       
          <button type="submit" class="btn">Create</button>
          <button type="button" class="btn cancel" onclick="closeFormCreate()">Cancel</button>
        </form>
      </div>
    </div>

    <!-- ----------------------------------------------------------------------------------------------------------->
    <!--  Account management popup -->
    <!-- ----------------------------------------------------------------------------------------------------------->
    <div class="login-popup">
      <div class="form-popup" id="popupFormManage">
        <form class="form-container" method="post">
          <h2>Manage your accounts</h2>         
          
          <label for="Account name">Current account Name </label>

          <select name="account_selection_to_update" id="account_selection_to_update">
            <?php
              $sql = "SELECT * FROM accounts";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                  echo "<option value='$row[id]'> $row[acc_name] </option>";
                }
              }
            ?>
          </select>
          <button type="submit" class="btn delete" name="delete_account">Delete</button>
          <label id=chk_lbl>Check before you delete</label>
          <input type="checkbox" id="scales" name="delete">
          <!----------------------> <hr> <!---------------------->
          <label for="New account name">New account Name </label>
          <input type="text" name="updated_acc_name">             
          <button type="submit" class="btn" name="update_account">Update</button>
          <!----------------------> <hr> <!---------------------->
          <button type="button" class="btn cancel" onclick="closeFormManage()">Cancel</button>
        </form>
      </div>
    </div>     
    <!-- ----------------------------------------------------------------------------------------------------------->
    <!--  Top flexbox container and child flexbox -->
    <!-- ----------------------------------------------------------------------------------------------------------->
    <div class="flex-top-parent-elemen">
      <div class="flex-top-child-element">

        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  Chart -->
        <!-- ----------------------------------------------------------------------------------------------------------->

    </div>
    <!-- ----------------------------------------------------------------------------------------------------------->
    <!--  Bottom flexbox container -->
    <!-- ----------------------------------------------------------------------------------------------------------->
    <div class="flex-parent-element">
      <!-- ----------------------------------------------------------------------------------------------------------->
      <!--  Left flexbox -->
      <!-- ----------------------------------------------------------------------------------------------------------->
      <div class="flex-child-element" id="left-flex-box">

        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  User profile information -->
        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  Welcome username -->
        <p><span><?php echo "Welcome back ".$userprofile['name']; ?></span></p>
        <!-- Rounded switch -->
        <?php
        //If emotion soother activated
        if ($userprofile['pl'] == 1) {
          $checked = "checked";
          $display_tabl_pl = "none";
        }else {
          $checked = "unchecked";
          $display_tabl_pl = "true";
        }
        ?>
        <p>
          <form method="post"><span>
            <label class="switch">
            <input type="hidden" value="0" name="pl_switch_off">
            <input type="checkbox" value="1" name="pl_switch_on" <?php echo $checked; ?> onclick="this.form.submit();">
            <span class="slider round"></span>
            </label>
            <span>Emotion soother</span>
          </form>
        </span></p>

        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  Dropdown list for account selection -->
        <!-- ----------------------------------------------------------------------------------------------------------->
          <form method="post">
            <select name="current_account_id" id="account_selection">
              <?php
                $sql = "SELECT * FROM accounts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  // output data of each row
                  while($row = $result->fetch_assoc()) {
                    if ($row[id] == $_SESSION['current_selected_account']){$select = "selected";}else{$select = "";} //select the current used account
                    echo "<option value='$row[id]' '$select'> $row[acc_name] </option>";
                  }
                }
              ?>
            </select>
            <input type=submit value=Select>
          </form>
          <!-- Accounts management buttons -->
          <div class="open-btn">
            <button class="open-button" onclick="openFormCreate()"><strong>Create new account</strong></button>
          </div>
          
          <div class="open-btn">
            <button class="open-button" onclick="openFormManage()"><strong>Manage account</strong></button>
          </div>
  
      </div>
      <!-- ----------------------------------------------------------------------------------------------------------->
      <!--  Left flexbox -->
      <!-- ----------------------------------------------------------------------------------------------------------->
      <div class="flex-child-element" id="right-flex-box">
          <div>
            <!-- Will initiate the variable for the dates of the Trading journal -->
            <?php
            //If submit, then selected month, else current month and year.
            if(isset($_POST['submit'])){
              if(!empty($_POST['month_selection'])) {
                  $month = $_POST['month_selection'];
                  $year = $_POST['year_selection'];
              }
            } else {
                $month = date("n");
                $year = date("Y");
            }

            $aDates = array();
            $oStart = new DateTime($year.$month.'/01');
            $oEnd = clone $oStart;
            $oEnd->add(new DateInterval("P1M"));
            ?>

            <!-- ______________________________________ Dropdown lists ______________________________________ -->
            <p id="month_year_dropdown">
              <form action="" method="post">
                <select class="dropdown" id="month_selection" name="month_selection">
                  <option value="1">January</option>
                  <option value="2">February</option>
                  <option value="3">March</option>
                  <option value="4">April</option>
                  <option value="5">May</option>
                  <option value="6">June</option>
                  <option value="7">July</option>
                  <option value="8">August</option>
                  <option value="9">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>

                <select class="dropdown" id="year_selection" name="year_selection">
                  <?php CreateDropDown(array(2022,2021,2020,2019),$year); ?>
                </select>

                <input type="submit" name="submit">



              </form>

              <!-- ################### SET THE DROPDOWN DEFAULT VALUES ###################

                  -->
              <script>
                document.getElementById('month_selection').selectedIndex=<?php echo $month-1; ?>;
              </script>

            </p>

            <!-- ******** HEADER OF THE TABLE ******** -->
          
            <table>
              <thead>
                <tr>
                  <th rowspan="2" class="dates_cell"> Dates </th>
                  <th rowspan="2" class="nbr_trade_cell"> # T </th>
                  <th rowspan="2" class="nbr_trade_cell"> # W </th>
                  <th rowspan="2" class="nbr_trade_cell"> # L </th>
                  <th colspan="2" class="trade"> Trade - 1 </th>
                  <th colspan="2" class="trade"> Trade - 2 </th>
                  <th colspan="2" class="trade"> Trade - 3 </th>
                  <th colspan="2" class="trade"> Trade - 4 </th>
                  <th colspan="2" class="trade"> Trade - 5 </th>
                  <th colspan="2" class="trade"> Trade - 6 </th>
                  <th colspan="2" class="trade"> Trade - 7 </th>
                  <th class="trade" style="display:<?php echo $display_tabl_pl; ?>;"> Daily </th>
                  <th rowspan="2"> Edit </th>
                </tr>
                <tr>
                  <th> Main </th>
                  <th> Runner </th>
                  <th> Main </th>
                  <th> Runner </th>
                  <th> Main </th>
                  <th> Runner </th>
                  <th> Main </th>
                  <th> Runner </th>
                  <th> Main </th>
                  <th> Runner </th>
                  <th> Main </th>
                  <th> Runner </th>
                  <th> Main </th>
                  <th> Runner </th>
                  <th class="daily" style="display:<?php echo $display_tabl_pl; ?>;"> Net G/L </th>
                </tr>
              </thead>

                <!-- ******** BODY OF THE TABLE ******** -->
              
                <?php

                // select the date of the month
                while ($oStart->getTimestamp() < $oEnd->getTimestamp()) {
                    $aDates[] = $oStart->format('D d');
                    $oStart->add(new DateInterval("P1D"));
                }

                //Set the variables for each dates
                foreach ($aDates as $day) {
                  $FuncDay = substr($day, -2);
                  $weekend = check_weekend($FuncDay,$month,$year);      //to test if date is a weekend
                  $today = check_day($FuncDay,$month,$year);        //test if the dat is today
                  $fulldate = $year."-".$month."-".$FuncDay;        //to use in SELECT query     
                  $btnID ++;                                        //increase butons IDs
                  $popupID ++;                                      //increase butons IDs

                  // Display a weekend line or a weekday line
                  if ($weekend == "weekend") {
                    if ($tr == 0){?>
                        <tr>
                          <td id="weekendDay" colspan="20">weekend</td>
                        </tr>
                    <?php $tr ++;}else{
                      $tr = 0;
                      }?>
                    <?php }else{ //else if not weekend, displays the data 
                    //SQL QUERY : Display DB data
                    $sql = "SELECT * FROM trades WHERE trade_date='$fulldate' AND acc_fid='$current_account_id'";
                    $result = $conn->query($sql); 
                    if ($result->num_rows > 0) { //if data to be displayed
                      // output data of each row
                      while($row = $result->fetch_assoc()) {
                        
                        //p&l calculation
                        $pl = ($row["gain"] + $row["loss"]) - $row["costs"];
                        ?>
                        <tbody id="<?php echo $today;?>">
                        <form method="post">
                        <!-- contracts line -->
                        <tr class="contracts">
                        <td rowspan="2" class="dates_cell" id="<?php echo $weekend; ?>"> <?php echo $day; ?> </td>
                        <td rowspan="2"><?php echo $total = $row["pos_tr_count"]+$row["neg_tr_count"]; ?></td>
                        <td rowspan="2"><?php echo $row["pos_tr_count"]; ?></td>
                        <td rowspan="2"><?php echo $row["neg_tr_count"]; ?></td>
                        <td class="main"><input name="main_cnt01" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt01"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt01" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt01"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_cnt02" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt02"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt02" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt02"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_cnt03" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt03"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt03" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt03"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_cnt04" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt04"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt04" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt04"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_cnt05" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt05"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt05" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt05"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_cnt06" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt06"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt06" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt06"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_cnt07" class="editable_input contracts" id="main" type="number" value="<?php echo $row["main_cnt07"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_cnt07" class="editable_input contracts" id="runner" type="number" value="<?php echo $row["runner_cnt07"]; ?>" readonly="readonly" ></td>
                        <td rowspan="2" style="display:<?php echo $display_tabl_pl; ?>;">
                          <div class="popup" onclick="openDetails(<?php echo $popupID; ?>)">
                            <?php echo $pl; ?>
                            <span class="popuptext" id="<?php echo $popupID; ?>">
                            Gain : <?php echo $row["gain"];?><br>
                            Loss : <?php echo $row["loss"]; ?><br>
                            <hr>
                            Fees : <?php echo $row["costs"]; ?></span>
                          </div>
                        </td>
                        <td rowspan="2"><button type="button" name="edit_trade" class="editbtn" id="<?php echo $row['id']; ?>">Edit</button><input type="hidden" name="trade_id" value="<?php echo $row['id']; ?>"><input type="hidden" name="current_account" value="<?php echo $current_account_id; ?>"></td>
                        <!-- <td rowspan="2"><input type="image" class="editbtn" id="editbtn" alt="edit" value ="Edit" src="./img/edit-11-24.png"></td> -->
                      </tr>
                      <!-- points line -->
                      <tr class="points">
                        <td class="main"><input name="main_pts01" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts01"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts01" class="editable_input points " id="runner" type="number" value="<?php echo $row["runner_pts01"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_pts02" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts02"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts02" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts02"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_pts03" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts03"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts03" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts03"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_pts04" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts04"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts04" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts04"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_pts05" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts05"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts05" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts05"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_pts06" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts06"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts06" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts06"]; ?>" readonly="readonly" ></td>
                        <td class="main"><input name="main_pts07" class="editable_input points" id="main" type="number" value="<?php echo $row["main_pts07"]; ?>" readonly="readonly" ></td>
                        <td class="runner"><input name="runner_pts07" class="editable_input points" id="runner" type="number" value="<?php echo $row["runner_pts07"]; ?>" readonly="readonly" ></td>
                      </tr>
                      </form>
                      </tbody> 
                      <?php
                      }
                    }else{
                  ?>
                  <tbody id="<?php echo $today;?>">
                <form method="post">
                <tr class="contracts">
                  <td rowspan="2" class="dates_cell" id="<?php echo $weekend; ?>"> <?php echo $day; ?> </td>
                  <td rowspan="2"> 0 </td>
                  <td rowspan="2"> 0 </td>
                  <td rowspan="2"> 0 </td>
                  <td class="main"><input name="main_cnt01" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt01" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_cnt02" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt02" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_cnt03" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt03" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_cnt04" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt04" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_cnt05" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt05" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_cnt06" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt06" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_cnt07" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_cnt07" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td rowspan="2" style="display:<?php echo $display_tabl_pl; ?>;"> 0 </td>
                  <td rowspan="2"><button type="button" name="new_trade" class="editbtn" id="<?php echo 'btn'.$btnID; ?>">Edit</button><input type="hidden" name="trade_date" value="<?php echo $fulldate; ?>"><input type="hidden" name="current_account" value="<?php echo $current_account_id; ?>"></td>
                  <!-- <td rowspan="2"><input type="image" class="editbtn" id="editbtn" alt="edit" value ="Edit" src="./img/edit-11-24.png"></td> -->
                </tr>
                  <tr class="points">
                  <td class="main"><input name="main_pts01" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts01" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_pts02" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts02" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_pts03" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts03" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_pts04" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts04" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_pts05" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts05" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_pts06" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts06" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                  <td class="main"><input name="main_pts07" class="editable_input" id="main" type="number" value="0" readonly="readonly" ></td>
                  <td class="runner"><input name="runner_pts07" class="editable_input" id="runner" type="number" value="0" readonly="readonly" ></td>
                </tr>
                </form>
                </tbody> 
                  <?php
                    }// if data, else no data
                  } //else not weekend ?>
              
              <?php } //SQL data SELECT
              // for each dates ?>
            </table>

          </div>
      </div>
    </div>

    <script type="text/javascript">
      // ----------------------------------------------------------------------------------- //
      // Color the numbers according to their values when change it (live)
      // ----------------------------------------------------------------------------------- //
      const colors = document.querySelectorAll('.editable_input');
      for (let color of colors) {
        color.addEventListener('keyup', () => {
          if (this.event.target.value >= 1) {
            this.event.target.style.color = '#3dbd3a'; //green
            this.event.target.style.fontWeight = "700"; //bold
            
          }
          else if (this.event.target.value < 0) {
            this.event.target.style.color = '#fc5b5b'; //red
            this.event.target.style.fontWeight = "700"; //bold
          }
          else {
            this.event.target.style.color = 'inherit';
            this.event.target.style.fontWeight = "700"; //bold
          }
        })
      }

      // ----------------------------------------------------------------------------------- //
      // Color the numbers according to their values when the document loads
      // has to sit in the bottom of the page to treat everything already displayed
      // ----------------------------------------------------------------------------------- //
      $(document).ready(function(){
        const contracts = document.querySelectorAll(".contracts");
        const points = document.querySelectorAll(".points");

        //if not 0, then grey
        for (var i = 0; i < contracts.length; i++)
        if(contracts[i].value != 0){
          contracts[i].style.color = 'grey';
          contracts[i].style.fontWeight = "700"; //bold
        }
        //if <0 then red else >0 green
          for (var i = 0; i < points.length; i++)
          if(points[i].value < 0){
            points[i].style.color = '#fc5b5b'; //red
            points[i].style.fontWeight = "700"; //bold
          }else if(points[i].value > 0){
            points[i].style.color = '#3dbd3a'; //green
            points[i].style.fontWeight = "700"; //bold
          }
        });      
    </script>

    <?php $conn->close();?>



  </body>
 </html>
