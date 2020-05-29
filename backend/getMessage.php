<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$db = new SQLite3 ('test.sqlite');


$messages = $db->query("select * from message");
$row = $messages->fetchArray(SQLITE3_ASSOC);
if ( $row == false){
    http_response_code(404);
    // no messages found
    echo json_encode(
        array("message" => "No Messages found.")
    );
} else {
    do { 
        echo json_encode($row);
    }    
    while($row = $messages->fetchArray(SQLITE3_ASSOC));
}
?>