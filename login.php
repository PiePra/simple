<?php
#set group and user from html form with POST
$gruppe = $_POST['gruppenname'];
$user = $_POST['nutzername'];
#open sqlite db
$db = new SQLite3 ('production.sqlite');
$output = array();
#check if provided group already exists
$result = $db->query("select GID from gruppe where gruppenname = '". $gruppe ."'" );
$row = $result->fetchArray(SQLITE3_ASSOC);
if ($row) {
    #if so save the gid of group
    $output['GID'] = $row['GID'];
}
else{
    #if not then create the group and save the new group gid
    $db->query("insert into gruppe (gruppenname, created) VALUES ('". $gruppe ."', CURRENT_TIMESTAMP)");
    $result = $db->query("select gid from gruppe where gruppenname = '". $gruppe . "'" );
    $id = $result->fetchArray(SQLITE3_ASSOC);
    $output['GID'] = $id['GID'];
}
#check if provided user already exists
$result = $db->query("select UID, fk_gruppe, lastActive from nutzer where nutzername = '". $user ."'");
$row = $result->fetchArray(SQLITE3_ASSOC);
if ($row) {
    #calculate last active in minutes
    $time =  ((gmdate(time()) - gmdate(strtotime($row['lastActive']))) /60) - 120;
    if ($row['fk_gruppe'] == $output['GID']){
        #if given user exists and previous group matches then save the uid
        $output['UID'] = $row['UID'];
    }
    elseif ($time > 60) {
        #if the group is different but last active time exceeds 60 minutes then update the user to the new group gid and save new gid
        $db->query("update nutzer set fk_gruppe = ". $output['GID'] . " where UID = ". $row['UID']);
        $result = $db->query("select UID from nutzer where nutzername = '". $user ."'");
        $row = $result->fetchArray(SQLITE3_ASSOC);
        $output['UID'] = $row['UID'];
    }
    else {
        #if the group is different but last active time is below 60 minutes return an error message indicating the time left before changing the group becomes possible
        http_response_code(404);
        $wait = 60 - $time;
        echo "User active in another group right now, change username or wait " . $wait . " minutes to login.";
        die();
    }
}
else{
    #if the user does not exist then create user in database and save user uid
    $db->query("insert into nutzer (nutzername, lastActive, fk_gruppe) VALUES ('". $user ."', CURRENT_TIMESTAMP, " . $output['GID'] . " )");
    $result = $db->query("select uid from nutzer where nutzername = '". $user . "'" );
    $id = $result->fetchArray(SQLITE3_ASSOC);
    $output['UID'] = $id['UID'];
}

#save gid and uid to php session
session_start();
$_SESSION['UID'] = $output['UID'];
$_SESSION['GID'] = $output['GID'];
$_SESSION['gruppenname'] = $gruppe;
#forward navigation to view page
header("Location: view.php");
die();





