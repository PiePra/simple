<?php
session_start();
#set gid from session
$fk_gruppe = $_SESSION['GID'];
#set message from html form using post
$message = $_POST['message'];
#set uid from session
$fk_autor = $_SESSION['UID'];
#open sqlite db
$db = new SQLite3 ('production.sqlite');
#create new message in database 
$db->query("insert into nachricht (nachrichtentext, fk_autor, fk_gruppe, sent_at) VALUES ('". $message . "', " . $fk_autor . ", " . $fk_gruppe . ", CURRENT_TIMESTAMP )");
#forward navigation to view page
header("Location: view.php");
?>