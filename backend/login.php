<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$gruppe = 'marco';   //$_POST['username'];
$user = 'marco  ';     //$_POST['gruppennamen'];

$db = new SQLite3 ('test.sqlite');
$output = array();
$db->query("select GID from gruppe where name = '". $gruppe ."'" );
$row -> fetchArray(SQLITE3_ASSOC);
if ($row) {
    $output['GID'] = $row['GID'];
}
else{
    $db->query("insert into gruppe (name, created) VALUES ('". $gruppe ."', CURRENT_TIMESTAMP)");
    $db->query("select gid from gruppe where name = ". $gruppe );
    $id = $db->fetchArray(SQLITE3_ASSOC);
    $output['GID'] = $id['GID'];
}
$db->query("select UID from nutzer where name = ". $user );
if ($db) {
    $id = $db->fetchArray(SQLITE3_ASSOC);
    $output['UID'] = $id['UID'];
    $db->query("update nutzer set fk_gruppe = ". $output['GID'] . " where UID = ". $output['UID']);
}
else{
    $db->query("insert into nutzer (name, created) VALUES ('". $user ."', CURRENT_TIMESTAMP, " . $output['GID'] . " )");
    $db->query("select gid from gruppe where name = ". $user );
    $id = $db->fetchArray(SQLITE3_ASSOC);
    $output['UID'] = $id['UID'];
}


