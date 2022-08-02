<!DOCTYPE html>
<html lang="en">
    <head>
        
        <?php   session_start();    ?>

        <!-- REFERENCES --------------------------------------------------------------------------- -->

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


    </head>
    <body>
        
    </body>