<?php
session_start();
#set gid from session
$gid = $_SESSION['GID'];
#open sqlite db
$db = new SQLite3 ('production.sqlite');

#get all members for group and order descending by last Active timestamp
$messages = $db->query("select nutzername, lastActive from nutzer where fk_gruppe = ". $gid ." order by lastActive DESC");
#fetch db return
$row = $messages->fetchArray(SQLITE3_ASSOC);
#initialize json return var
$output = array();
if ( $row == false){
    #if something went wrong
    http_response_code(404);
    echo json_encode(
        array("message" => "No Users found.")
    );
} else {
    do { 
            #create temp var for the group's active users in the database
            $temp['nutzername'] = $row['nutzername'];
            #get length of lastactive in minutes
            $time =  ((gmdate(time()) - gmdate(strtotime($row['lastActive']))) /60) - 120;
            #return different codes if lastactive over specific threshold value
            if ($time > 15){
                $status = 2;
            } else if ($time > 5){
                $status = 1;
            } else {
                $status = 0;
            }
            $temp['status'] = $status;
            #add the var to json return 
            $output[] = $temp;
            
    }     
    while($row = $messages->fetchArray(SQLITE3_ASSOC));
    #print json output and response http 200
    echo json_encode($output);
    http_response_code(200);
}
?>