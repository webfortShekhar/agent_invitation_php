<?php
include 'Db.php';
// Perform query
header("Access-Control-Allow-Origin: *");

$sql = "SELECT CONCAT(first_name,' ',last_name) as agent_name, email, login_status, google_profile_picture, role, team.team_name FROM td_z_user_invitations invitation left JOIN td_z_teams team ON team.id=invitation.team_id";

if(isset($_REQUEST['team_selected']) && !empty($_REQUEST['team_selected'])) {
    $search_team = $_REQUEST['team_selected'];
    $sql = "SELECT CONCAT(first_name,' ',last_name) as agent_name, email, login_status, google_profile_picture, role, team.team_name FROM td_z_user_invitations invitation left JOIN td_z_teams team ON team.id=invitation.team_id 
    Where team.team_name LIKE '%".mysqli_real_escape_string($conn, $search_team)."%'";              
}
else{
    $sql = "SELECT id FROM td_z_user_invitations";    

}


// echo $sql;
$result = mysqli_query($conn, $sql ) or die(mysqli_error($conn));

$response = array();


if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        $response['Agent_list'][] = $row;
    }
  } 
echo json_encode($response);

mysqli_close($conn);