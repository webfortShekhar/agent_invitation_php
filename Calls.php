<?php
include 'Db.php';
// Perform query
header("Access-Control-Allow-Origin: *");
$company_id = 30;

$sql = "SELECT  calls.*, CONCAT(invitation.first_name,' ',invitation.last_name) as agent_name , CONCAT(contacts.first_name,' ',contacts.last_name) as contact_name, team.team_name FROM td_z_customer_calls calls left JOIN td_z_contact_list contacts ON contacts.id=calls.contact_id 
left JOIN td_z_customer_calls_attended_by attends ON attends.CallSid=calls.CallSid 
left JOIN td_z_user_invitations invitation ON invitation.user_id=attends.AgentAssigned
left JOIN td_z_teams team ON team.id=invitation.id";

$result = mysqli_query($conn, $sql);

$response = array(
    'ringing'=> array(),
    'ongoing'=> array(),
    'completed'=> array()
);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {

$row["recordings"] = array();

        switch ($row['CallStatus']) {
            case 'ringing':
                $response['ringing'][] = $row;
                break;
            case 'ongoing':
                $response['ongoing'][] = $row;
                break;
            case 'completed':
                $response['completed'][] = $row;
                break;
        }
    }
}

// print_r($response);
echo json_encode($response);

mysqli_close($conn);
