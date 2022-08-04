<!DOCTYPE html>
<html lang="en">
    <head>
        
        <?php   session_start();    ?>

        <!-- ------------------------------------------------------------------------------------------------------------
            References
        ---------------------------------------------------------------------------------------------------------------->
        <!-- chart -->
        <script src="https://cdn.anychart.com/releases/8.10.0/js/anychart-base.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
        <!-- Jquery / javascript-->
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="./javascript/scripts.js"></script>
        <!-- css -->
        <link href="./css/main.css" rel="stylesheet"/>
        <link href="./css/table.css" rel="stylesheet"/>
        <link href="./css/flexbox.css" rel="stylesheet"/>
        <link href="./css/grid.css" rel="stylesheet"/>
        <!-- php files -->
        <?php
        require __DIR__ . '/functions/functions.php';
        require __DIR__ . '/db/db_conn.php';
        require __DIR__ . '/db/operations.php';  
        // avoid index errors
        error_reporting (E_ALL ^ E_NOTICE); 
        ?>

        <!-- -----------------------------------------------------------------------REFERENCES---END -->

        <!-- ------------------------------------------------------------------------------------------------------------
            CSS for popups (seems not to work in a separate file)
        ---------------------------------------------------------------------------------------------------------------->
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
        <!-- ------------------------------------------------------------------------------------------------------------
            POPUPS : All the popoups that will be displayed through the main page
        ---------------------------------------------------------------------------------------------------------------->
        
        <!-- -----------------------------------
            New account creation popup
        --------------------------------------->
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

        <!-- ----------------------------------
            Account management popup
        -------------------------------------->
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
              <hr>
              <label for="New account name">New account Name </label>
              <input type="text" name="updated_acc_name">             
              <button type="submit" class="btn" name="update_account">Update</button>
              <hr>
              <button type="button" class="btn cancel" onclick="closeFormManage()">Cancel</button>
            </form>
          </div>
        </div>
        <!-- --------------------------------------------------------------------------POPUPS--END -->
    </head>
    <body>
        <!-- ------------------------------------------------------------------------------------------------------------
            PHP variables init.
        ---------------------------------------------------------------------------------------------------------------->
        <?php
            $tr = 0;         //used to display weekends in the journal table
            $btnID = 0;      //used for button IDs in the trade journal
            $popupID = 0;    //allow to display the details popup at the right place
            $current_account_id = $_POST['current_account_id'];
        
            /*-- -------------------------------------------
                PHP Get the user profile informations
            ----------------------------------------------*/
            $sql = "SELECT * FROM users WHERE email = 'sir.gezy@gmail.com'";
            $result = $conn->query($sql);
            $userprofile = $result->fetch_assoc();      
        ?>
        
        <!-- ------------------------------------------------------------------------------------------------------------
            Main grid container
        ---------------------------------------------------------------------------------------------------------------->
        <div id="grid-main-container">

            <div class="grid-item" id="grid-item-top">
                <!-- displays the top chart -->
                <script src="./javascript/top-chart.js"></script>
            </div>

            <div class="grid-item" id="grid-item-main">
                <!-- displays the trding journal (table) -->
                <?php
                    include 'journal.php'
                ?>
            </div>
            <!-- ------------------------------------------------------------------------------------------------------------
                Main menu container
            ---------------------------------------------------------------------------------------------------------------->
            <div id="grid-menu-container">

                <!-- ------------------------------------------------------------------------------------------------------------
                    MENU ITEM 3
                ---------------------------------------------------------------------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-3">
                    <!-- -----------------------------------------
                        User profile information
                    --------------------------------------------->
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

                    <!-- --------------------------------------------
                        Dropdown list for account selection
                    ------------------------------------------------>
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

                <!-- ------------------------------------------------------------------------------------------------------------
                    MENU ITEM 1
                ---------------------------------------------------------------------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-1">  
                    <!-- displays the donut chart -->
                    <script src="./javascript/long-short-chart.js"></script>
                </div>

                <!-- ------------------------------------------------------------------------------------------------------------
                    MENU ITEM 2
                ---------------------------------------------------------------------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-2">
                    <!-- displays the donut chart -->
                    <script src="./javascript/win-ratio-chart.js"></script>
                </div>

            </div>

        </div>
        
    </body>
