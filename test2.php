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
        <link href="./css/grid.css" rel="stylesheet"/>
        <link href="./css/table.css" rel="stylesheet"/>
        <?php
        require __DIR__ . '/functions/functions.php';
        require __DIR__ . '/db/db_conn.php';
        require __DIR__ . '/db/operations.php'; 
         
        error_reporting (E_ALL ^ E_NOTICE); // avoid index errors ?>
    </head>
    <body>  
        <!-- ---------------------------------------------------------------------------------
            Global grid container
        ------------------------------------------------------------------------------------->
        <div id="grid-main-container">

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
                <?php 
                    include './journal.php';
                ?>
            </div>

                <!-- ---------------------------------------------
                    Menu main grid
                ------------------------------------------------->
            <div id="grid-menu-container">

                <!-- ---------------------------------------------
                    Menu grid item 3
                ------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-3">
                    <p id="login_name">
                        GregTheTrader
                    </p>
                    <p>
                        <form method="post">
                            <span>
                                <label class="switch">
                                    <input type="hidden" value="0" name="pl_switch_off">
                                    <input type="checkbox" value="1" name="pl_switch_on">
                                    <span class="slider round"></span>
                                </label>
                            </span>
                            <span>Emotions soother</span>
                        </form>
                    </p>
                </div>

                <!-- ---------------------------------------------
                    Menu grid item 1
                ------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-1">  
                    <!-- displays the donut chart -->
                    <script src="./javascript/long-short-chart.js"></script>
                </div>

                <!-- ---------------------------------------------
                    Menu grid item 2
                ------------------------------------------------->
                <div class="grid-item" id="grid-item-menu-2">
                    <!-- displays the donut chart -->
                    <script src="./javascript/win-ratio-chart.js"></script>
                </div>

            </div> <!-- menu -->
        </div> <!-- main -->

        <script type="text/javascript">
            /* -----------------------------------------------------------
            Sets the cells to editable with a click on a button.
                Then display a save button to lock the values
            ----------------------------------------------------------- */
            
            //Function to set the cells to editable
            $(document).ready(function () {
            $('.editbtn').click(function () {
                //Get all the tds within tr using below code
                var currentTD = $(this).parents('tbody').find('.editable_cell');
                if ($(this).html() == 'Edit') {
                    //Then as usual iterate through each tds and change its contenteditable property like below                  
                    $.each(currentTD, function () {
                        $(this).prop('contenteditable', true)
                    });
                } else {
                    $.each(currentTD, function () {
                        $(this).prop('contenteditable', false)
                    });
                }

                $(this).html($(this).html() == 'Edit' ? 'Save' : 'Edit')

                });
            });

            // Color the points cells according to their value
            $('.points .editable_cell').each(function() {
            var $this = $(this)
            if ($this.text() > 0 ) {
                $this.addClass('green');
            }else if ($this.text() < 0 ){
                $this.addClass('red');
            }
            });

            // Color the contracts cells according to their value
            $('.contracts .editable_cell').each(function() {
            var $this = $(this)
            if ($this.text() != 0 ) {
                $this.addClass('grey');
            }
            });

            document.getElementById('editable_cell').addEventListener('keydown', (evt) => {
                if (evt.keyCode === 13) {
                    evt.preventDefault();
                }
            });

            $('#editable_cell').keypress(function (event) {
                if (event.keyCode === 10 || event.keyCode === 13) {
                    event.preventDefault();
                }
            });

        </script>
    </body>  