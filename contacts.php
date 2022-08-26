<?php
include 'Db.php';
// Perform query
header("Access-Control-Allow-Origin: *");
// print_r($_REQUEST);
// exit();


if(isset($_REQUEST['contact_query']) && !empty($_REQUEST['contact_query'])) {
    $search_term = $_REQUEST['contact_query'];
    $sql = "SELECT CONCAT(first_name,' ',last_name) as contact_name, phone FROM td_z_contact_list 
    Where first_name LIKE '%".mysqli_real_escape_string($conn, $search_term)."%'";              
}
else{
    $sql = "SELECT CONCAT(first_name,' ',last_name) as contact_name, phone FROM td_z_contact_list";    

}
// echo $sql;
$result = mysqli_query($conn, $sql ) or die(mysqli_error($conn));
$response = array();


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $response['contact_list'][] = $row;
    }
  } 
echo json_encode($response);

mysqli_close($conn);