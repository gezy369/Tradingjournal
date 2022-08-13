<?php
include "./db/db_conn.php";

$count_winner = 0;
$count_loser = 0;
/*
//$sql = "SELECT * FROM trades WHERE acc_fid='$current_account_id'";
$sql = "SELECT * FROM trades WHERE acc_fid = 6 ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //calculate the P/L
    while($row = $result->fetch_assoc()) {
    
        for ($i = 1; $i <= $nbroftrades; $i++) {
                            
            if ($row['main_pts0'.$i] > 0) {

                $count_winner ++;

            } elseif ($row['main_pts0'.$i] <= 0 AND $row['main_cnt0'.$i] != 0) {
                
                $count_loser ++;
            }
        }
    }
}

// ----------------------------------------------------------------
//    Create a JSON file so it can be read by AnyChart
// ----------------------------------------------------------------
// create data object
$data = array();
$data[1] = $count_winner;
$data[2] = $count_loser;
// encode data to json format
echo json_encode($data);*/

/*

$result = $mysqli->query('SELECT * FROM trades');

if ($result->num_rows > 0) {
    //calculate the P/L
    while($row = $result->fetch_assoc()) {
    
        for ($i = 1; $i <= $nbroftrades; $i++) {
                            
            if ($row['main_pts0'.$i] > 0) {

                $count_winner ++;

            } elseif ($row['main_pts0'.$i] <= 0 AND $row['main_cnt0'.$i] != 0) {
                
                $count_loser ++;
            }
        }
    }
}

$rows = array(); $table = array(); $table['cols'] = array(
    // Labels for your chart, these represent the column titles.
    // note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for Slice title
    array('label' => 'Winners', 'type' => 'string'), array('label' => 'Loosers', 'type' => 'number') );
    // Extract the information from $result
    foreach($result as $r) {
        $temp = array();
        // The following line will be used to slice the Pie chart
        $temp[] = array('v' => (string) $r['weekly_task']);
        // Values of the each slice
        $temp[] = array('v' => (int) $r['percentage']);
        $rows[] = array('c' => $temp); } $table['rows'] = $rows;
        // convert data into json format $jsonTable = json_encode($table);
        //echo $jsonTable;
        */
?>
