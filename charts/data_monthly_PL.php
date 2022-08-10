<?php

$sql = "SELECT trade_date, pl FROM trades WHERE trade_date >= '2022-08-01' AND trade_date <= '2022-08-30'";
$result = $conn->query($sql);

/* ----------------------------------------------------------------
    Create a JSON file so it can be read by AnyChart
-----------------------------------------------------------------*/
// create data object
$data = array();

for ($x = 0; $x < mysql_num_rows($query); $x++) {
  $data[] = mysql_fetch_assoc($query);
}
// encode data to json format
echo json_encode($data);

?>