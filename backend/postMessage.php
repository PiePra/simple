<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$fk_gruppe = 1;//$_POST['GID'];
$message = "test23"; //$_POST['message];
$fk_autor = 1;//$_POST['UID'];

$db = new SQLite3 ('test.sqlite');

$db->query("insert into nachricht (text, fk_autor, fk_gruppe, sent_at) values ('". $message . "', " . $fk_autor . ", " . $fk_gruppe . ", CURRENT_TIMESTAMP )");
?>