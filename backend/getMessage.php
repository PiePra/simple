<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$gid = 1;//$_POST['GID'];

$db = new SQLite3 ('test.sqlite');

$messages = $db->query("select name, text, sent_at from nachricht join nutzer on fk_autor = UID where UID = ". $gid) ;  
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
        $temp['text'] = $row['text'];
        $temp['author'] = $row['name'];
        $temp['time'] = $row['sent_at'];

        //var_dump($temp);


        $output[] = $temp;
    }    
    while($row = $messages->fetchArray(SQLITE3_ASSOC));
    echo json_encode($output);
    http_response_code(200);
}
?>