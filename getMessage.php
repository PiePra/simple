<?php
session_start();
#set gid from session
$gid = $_SESSION['GID'];
#open sqlite db
$db = new SQLite3 ('production.sqlite');

#get all messages and order descending by sent at timestamp
$messages = $db->query("select nachrichtentext, nutzername, sent_at from nachricht n join nutzer u on fk_autor = UID where n.fk_gruppe = ". $gid . " order by n.sent_at DESC") ;  
#fetch db return
$row = $messages->fetchArray(SQLITE3_ASSOC);
#initialize json return var
$output = array();
if ( $row == false){
    #if something went wrong
    http_response_code(404);
    echo json_encode(
        array("message" => "No Messages found.")
    );
} else {
    do {
        #create temp var for the group's message in the database
        $temp['message'] = $row['nachrichtentext'];
        $temp['author'] = $row['nutzername'];
        $temp['time'] = $row['sent_at'];
        #add the var to json return 
        $output[] = $temp;
    }    
    while($row = $messages->fetchArray(SQLITE3_ASSOC));
    #print json output and response http 200
    echo json_encode($output);
    http_response_code(200);
}
?>