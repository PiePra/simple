<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
session_start();
$gid = $_SESSION['GID'];

$db = new SQLite3 ('test.sqlite');
//
$messages = $db->query("select nachrichtentext, nutzername, sent_at from nachricht n join nutzer u on fk_autor = UID where n.fk_gruppe = ". $gid . " order by n.sent_at DESC") ;  
$row = $messages->fetchArray(SQLITE3_ASSOC);
$output = array();
if ( $row == false){
    http_response_code(404);
    // no messages found
    echo json_encode(
        array("message" => "No Messages found.")
    );
} else {

    do { 
        $temp['message'] = $row['nachrichtentext'];
        $temp['author'] = $row['nutzername'];
        $temp['time'] = $row['sent_at'];

        //var_dump($temp);


        $output[] = $temp;
    }    
    while($row = $messages->fetchArray(SQLITE3_ASSOC));
    echo json_encode($output);
    http_response_code(200);
}
?>