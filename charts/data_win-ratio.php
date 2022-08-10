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

            } elseif ($row['main_pts0'.$i] <= 0 AND $row['main_cnt0'.$i] != 0) {
                
                $count_loser ++;
            }
        }
    }
}

/* ----------------------------------------------------------------
    Create a JSON file so it can be read by AnyChart
-----------------------------------------------------------------*/
// create data object
$data = array();
$data[1] = $count_winner;
$data[2] = $count_loser;
// encode data to json format
echo json_encode($data);

// should it work, maybe I need to consider feeding the standalone label the same way ?
?>