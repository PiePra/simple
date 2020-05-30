<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$gid = $_SESSION['GID'];

$db = new SQLite3 ('test.sqlite');

$messages = $db->query("select nutzername, lastActive from nutzer where fk_gruppe = ". $gid ." order by lastActive DESC");
$row = $messages->fetchArray(SQLITE3_ASSOC);
if ( $row == false){
    http_response_code(404);
    // no messages found
    echo json_encode(
        array("message" => "No Users found.")
    );
} else {
    $output = array();
    do { 
            $temp['nutzername'] = $row['nutzername'];
            $time =  ((gmdate(time()) - gmdate(strtotime($row['lastActive']))) /60) - 120;
            if ($time > 15){
                $status = 2;
            } else if ($time > 5){
                $status = 1;
            } else {
                $status = 0;
            }
            $temp['status'] = $status;
            $output[] = $temp;
            
    }     
    while($row = $messages->fetchArray(SQLITE3_ASSOC));
    echo json_encode($output);
    http_response_code(200);
}
?>