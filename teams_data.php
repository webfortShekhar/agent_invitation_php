<?php
include 'Db.php';
// Perform query
header("Access-Control-Allow-Origin: *");

$sql = "SELECT  team_name FROM td_z_teams ";

// echo $sql;
$result = mysqli_query($conn, $sql ) or die(mysqli_error($conn));

$response = array();


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $response['teams_data'][] = $row;
    }
  } 
echo json_encode($response);

mysqli_close($conn);