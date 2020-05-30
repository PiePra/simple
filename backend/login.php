<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$gruppe = 'pierre6';   //$_POST['username'];
$user = 'pierre2';     //$_POST['gruppennamen'];

$db = new SQLite3 ('test.sqlite');
$output = array();
$result = $db->query("select GID from gruppe where gruppenname = '". $gruppe ."'" );
$row = $result->fetchArray(SQLITE3_ASSOC);
if ($row) {
    $output['GID'] = $row['GID'];
}
else{
    $db->query("insert into gruppe (gruppenname, created) VALUES ('". $gruppe ."', CURRENT_TIMESTAMP)");
    $result = $db->query("select gid from gruppe where gruppenname = '". $gruppe . "'" );
    $id = $result->fetchArray(SQLITE3_ASSOC);
    $output['GID'] = $id['GID'];
}
$result = $db->query("select UID, fk_gruppe, lastActive from nutzer where nutzername = '". $user ."'");
$row = $result->fetchArray(SQLITE3_ASSOC);
if ($row) {
    $time =  ((gmdate(time()) - gmdate(strtotime($row['lastActive']))) /60) - 120;
    if ($row['fk_gruppe'] == $output['GID']){
        $output['UID'] = $row['UID'];
    }
    elseif ($time > 60) {
        $db->query("update nutzer set fk_gruppe = ". $output['GID'] . " where UID = ". $row['UID']);
        $result = $db->query("select UID from nutzer where nutzername = '". $user ."'");
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $output['UID'] = $row['UID'];
    }
    else {
        http_response_code(404);
        // user currently active in another group
        $wait = 60 - $time;
        echo json_encode(
            array("message" => "User active in another group right now, change username or wait " . $wait . " minutes to login.")
        );
        exit();
    }
}
else{
    $db->query("insert into nutzer (nutzername, lastActive, fk_gruppe) VALUES ('". $user ."', CURRENT_TIMESTAMP, " . $output['GID'] . " )");
    $result = $db->query("select uid from nutzer where nutzername = '". $user . "'" );
    $id = $result->fetchArray(SQLITE3_ASSOC);
    $output['UID'] = $id['UID'];
}

http_response_code(200);
echo json_encode($output);



