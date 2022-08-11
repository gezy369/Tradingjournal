<!DOCTYPE html>
<html lang="en">
    <head>

        <?php
        session_start();
        ?>
        
        <!-- REFERENCES -------------------------------------------------------------------------->
        <!-- <script src="https://code.jquery.com/jquery-1.7.2.js"></script> -->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js"></script>
        <script src="./javascript/scripts.js"></script>
        <link href="./css/main.css" rel="stylesheet"/>
        <link href="./css/table.css" rel="stylesheet"/>
        <link href="./css/popups.css" rel="stylesheet"/>
        <link href="./css/grid.css" rel="stylesheet"/>
        
        <!-- GOOGLE CHARTS -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>       
        <script src="./charts/GoogleChart.js"></script>
        
        <?php
        require __DIR__ . '/functions/functions.php';
        require __DIR__ . '/db/db_conn.php';
        require __DIR__ . '/db/operations.php';  
        error_reporting (E_ALL ^ E_NOTICE); // avoid index errors
        ?>

        <!-- --------------------------------------------------------------------------------
            opens P/L detail popup
            When the user clicks on div, open the popup
        --------------------------------------------------------------------------------- -->
        <script>
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
        <!-- -----------------------------------------------------------------------------------------------------------
            PHP variables init.
        --------------------------------------------------------------------------------------------------------------->
        <?php
        $tr = 0;         //used to display weekends in the journal table
        $btnID = 0;      //used for button IDs in the trade journal
        $popupID = 0;    //allow to display the details popup at the right place
        $current_account_id = $_POST['current_account_id'];
        // months
        $months[1] = "January";
        $months[2] = "February";
        $months[3] = "March";
        $months[4] = "April";
        $months[5] = "May";
        $months[6] = "June";
        $months[7] = "July";
        $months[8] = "August";
        $months[9] = "September";
        $months[10] = "October";
        $months[11] = "November";
        $months[12] = "December";
        // current and last 4 years
        $years[1] = date("Y");
        $years[2] = date("Y")-1;
        $years[3] = date("Y")-2;
        $years[4] = date("Y")-3;
        ?>

        <!-- -----------------------------------------------------------------------------------------------------------
            PHP Get the user profile informations
        --------------------------------------------------------------------------------------------------------------->
        <?php
        $sql = "SELECT * FROM users WHERE email = 'sir.gezy@gmail.com'";
        $result = $conn->query($sql);
        $userprofile = $result->fetch_assoc();
        ?>

        <!-- -----------------------------------------------------------------------------------------------------------
            POPUPS
        --------------------------------------------------------------------------------------------------------------->

        <!-- --------------------------------------
            Account creation
        ------------------------------------------>
        <div class="login-popup">
            <div class="form-popup" id="popupFormCreate">
                <form class="form-container" action="" method="post">
                    <h2>Create a new account</h2>         
                    <label for="Account name">Account Name </label>
                    <input type="text" name="new_account_name">
                    <label>Base Equity </label>
                    <input type="text" name="new_account_base">        
                    <button type="submit" class="btn create">Create</button>
                    <button type="button" class="btn cancel" onclick="closeFormCreate()">Cancel</button>
                </form>
            </div>
        </div>

        <!-- --------------------------------------
            Account management
        ------------------------------------------>
        <div class="login-popup">
            <div class="form-popup" id="popupFormManage">
                <form class="form-container" method="post">
                    <h2>Manage your accounts</h2>         
                    
                    <label for="Account name">List Of Account(s)</label>
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
                    <!----------------------> <hr> <!---------------------->
                    <label>Account Name </label>
                    <input type="text" name="updated_name">
                    <label>Base Equity </label>
                    <input type="text" name="updated_base">
                    <label>Adjustement </label>
                    <input type="text" name="updated_adjust">  

                    <button type="submit" class="btn update" name="update_account">Update</button>
                    <button type="submit" class="btn delete" name="delete_account" onclick="return confirm('Are you sure you want to delete this account?\nAll the related trades will be deleted as well !!\n\nWell... if you are certain of it, please\ndon\'t forget the check box.\n\nBetter be safe than sorry..');">Delete</button>
                    <label id=chk_lbl>Check before you delete</label>
                    <input type="checkbox" id="scales" name="delete">
                    <!----------------------> <hr> <!---------------------->
                    <button type="button" class="btn cancel" onclick="closeFormManage()">Cancel</button>
                </form>
            </div>
        </div> 


        <!-- ----------------------------------------------------------------------------------------------------------------------------------

            GLOBAL GRID CONTAINER

        -------------------------------------------------------------------------------------------------------------------------------------->
        <div id="grid-main-container">


            <!-- ----------------------------------------------------------------------------------------------------------------------------------

            MENU MAIN GRID CONTAINER
            
            -------------------------------------------------------------------------------------------------------------------------------------->
            <div id="grid-menu-container">

                <!-- ---------------------------------------------
                    Menu grid item 3 (User info)
                ------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-3">
 
                    <!-- User profile information -->
                    <p id="login_name">
                        <?php
                        echo $userprofile['name'];
                        ?>
                    </p>

                    <!-- Emotion soother -->
                    <?php
                    //If activated
                    if ($userprofile['pl'] == 1) {
                        $checked = "checked";
                        $display_tabl_pl = "none";
                    }else {
                        $checked = "unchecked";
                        $display_tabl_pl = "true";
                    }
                    ?>
                    <p>
                        <form method="post">
                            <span>
                                <label class="switch">
                                    <input type="hidden" value="0" name="pl_switch_off">
                                    <input type="checkbox" value="1" name="pl_switch_on" <?php echo $checked; ?> onclick="this.form.submit();">
                                    <span class="slider round"></span>
                                </label>
                                <span>Emotion soother</span>
                            </span>
                        </form>
                    </p>

                    <!-- ----------------------------------------------------------------------------------------------------------->
                    <!--  Dropdown list for account selection -->
                    <!-- ----------------------------------------------------------------------------------------------------------->
                    <form method="post">
                        <select name="current_account_id" id="account_selection" onchange='this.form.submit()'>
                        <?php
                            $sql = "SELECT * FROM accounts";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    if ($row['id'] == $current_account_id){     //select the current used account
                                        $select = "selected";}else{$select = ""; 
                                    } 
                                    echo "<option value='$row[id]' $select> $row[acc_name] </option>";
                                }
                            }
                        ?>
                        </select>
                    </form>
                
                    <!-- Accounts management buttons -->
                    <div class="open-btn">
                        <button class="open-button" onclick="openFormCreate()"><strong>Create new account</strong></button>
                    </div>
                    
                    <div class="open-btn">
                        <button class="open-button" onclick="openFormManage()"><strong>Manage account</strong></button>
                    </div>

                </div> <!-- menu item 3 -->

                <!-- ---------------------------------------------
                    Menu grid item 1 (Win Ratio CHART)
                ------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-1">  
                   
                    <!-- displays the donut chart -->  
                    <div id="winratiochart">

                    </div>
                    <!-- Result placed in the middle of the chart -->
                    <div id="Win-Ratio-Center">
                        80%
                    </div>
                    
                </div>

                <!-- ---------------------------------------------
                    Menu grid item 2                 
                ------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-2">
                    <?php
                    $count_winner = 0;
                    $count_loser = 0;

                    $sql = "SELECT * FROM trades WHERE acc_fid='$current_account_id'";
                    $result = $conn->query($sql);


                    if ($result->num_rows > 0) {
                        //calculate the P/L
                        while($row = $result->fetch_assoc()) {
                        
                            for ($i = 1; $i <= $nbroftrades; $i++) {
                                               
                                if ($row['main_pts0'.$i] > 0) {

                                    $count_winner ++;

                                }elseif ($row['main_pts0'.$i] <= 0 AND $row['main_cnt0'.$i] != 0) {
                                    
                                    $count_loser ++;
                                }
                            }
                        }
                    }
                    echo "<br>".$count_winner."<br>".$count_loser;
                    ?>
                    
                    
                    <!-- displays the donut chart -->  
                    <div id="longshortchart">
                        
                    </div>
                </div>


            </div>
            <!--
                END of menu main grid div
             -->                  


            <!-- ---------------------------------------------
                Top grid item (TOP CHART)
            ------------------------------------------------->   
            <div class="grid-item" id="grid-item-top">
                <!-- displays the top chart -->
                <script src="./javascript/top-chart.js"></script>
            </div>

            <!-- ---------------------------------------------
                Main grid item (JOURNAL)
            -------------------------------------------------> 
            <div class="grid-item" id="grid-item-main">


            
                <!-- Will initiate the variable for the dates of the Trading journal -->
                <?php
                //If submit, then selected month, else current month and year.
                if(isset($_POST['submit'])){
                if(!empty($_POST['month_selection'])) {
                    $month = $_POST['month_selection'];
                    $thisyear = $_POST['year_selection'];
                }
                } else {
                    $month = date("n");
                    $thisyear = date("Y");
                }

                $aDates = array();
                $oStart = new DateTime($thisyear.$month.'/01');
                $oEnd = clone $oStart;
                $oEnd->add(new DateInterval("P1M"));
                ?>

                <!-- ------------------------------------------------------------------------------------------------------------
                    Dropdown list for MONTH and YEAR selection
                ---------------------------------------------------------------------------------------------------------------->
                <p id="month_year_dropdown">
                <form action="" method="post">
                    <!-- ---------------------------------------------
                        Displays months and select the current month
                    -------------------------------------------------> 
                    <select class="dropdown" id="month_selection" name="month_selection" onclick="this.form.submit();">
                    <?php
                    for ($i = 1; $i <= 12; $i++) { 
                        $select = "";
                        if(isset($_POST['month_selection']) AND $_POST['month_selection'] == $i){
                            $select = "selected";
                        }
                        echo "<option value='$i' '$select'>$months[$i]</option>";
                    }
                    ?>
                    </select>

                    <!-- ---------------------------------------------
                        Displays year and select the current year
                    ------------------------------------------------->
                    <select class="dropdown" id="year_selection" name="year_selection" onclick="this.form.submit();">
                    <?php CreateDropDown(array($years[1],$years[2],$years[3],$years[4]),$thisyear); ?>
                    </select>
                </form>

                <!-- ---------------------------------------------
                    Displays current month is nothing selected
                -------------------------------------------------> 
                <script>
                    document.getElementById('month_selection').selectedIndex=<?php echo $month-1; ?>;
                </script>

                </p>

                <!-- ---------------------------------------------------------------------------------
                    JOURNAL TABLE
                ------------------------------------------------------------------------------------->
                <?php include './journal.php'; ?>

            </div>
            <!--
                END journal table div
            -->
        </div>
        <!--
            END main grid div
        -->

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

        <!-- close all db connections -->
        <?php $conn->close();?>

    </body>
 </html>
