<!DOCTYPE html>
<html lang="en">
    <head>
        
        <?php   session_start();    ?>

        <!-- REFERENCES -----------------------------------------------------------------------START -->
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
        <!-- php files -->
        <?php
        require __DIR__ . '/functions/functions.php';
        require __DIR__ . '/db/db_conn.php';
        require __DIR__ . '/db/operations.php';  
        error_reporting (E_ALL ^ E_NOTICE); // avoid index errors
        ?>

        <!-- -----------------------------------------------------------------------REFERENCES---END -->

        <!-- POPUPS---- -----------------------------------------------------------------------START ---     
            All the popoups that will be displayed through the main page
        -->
        
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
        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  PHP variables init. -->
        <!-- ----------------------------------------------------------------------------------------------------------->
        <?php
        $tr = 0;         //used to display weekends in the journal table
        $btnID = 0;      //used for button IDs in the trade journal
        $popupID = 0;    //allow to display the details popup at the right place
        $current_account_id = $_POST['current_account_id'];
        ?>
        <!-- ------------------------------------------
            PHP Get the user profile informations 
        <!-- ----------------------------------------->
        <?php
        $sql = "SELECT * FROM users WHERE email = 'sir.gezy@gmail.com'";
        $result = $conn->query($sql);
        $userprofile = $result->fetch_assoc();      
        ?>
        
        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  Main grid container
        <!-- ----------------------------------------------------------------------------------------------------------->
        <div id="grid-main-container">

            <div class="grid-item" id="grid-item-top">
                <!-- displays the top chart -->
                <script src="./top-chart.js"></script>
            </div>

            <div class="grid-item" id="grid-item-main">
                main
            </div>
        <!-- ----------------------------------------------------------------------------------------------------------->
        <!--  Main menu container
        <!-- ----------------------------------------------------------------------------------------------------------->
            <div id="grid-menu-container">

                <div class="grid-item" id="grid-item-menu-1">  
                    <!-- displays the donut chart -->
                    <script src="./long-short-chart.js"></script>
                </div>

                <div class="grid-item" id="grid-item-menu-2">
                    <!-- displays the donut chart -->
                    <script src="./win-ratio-chart.js"></script>
                </div>

            </div>

        </div>
        
    </body>
