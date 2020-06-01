<?php
session_start();


$fk_gruppe = $_SESSION['GID'];
$message = $_POST['message'];
$fk_autor = $_SESSION['UID'];

$db = new SQLite3 ('production.sqlite');
$db->query("insert into nachricht (nachrichtentext, fk_autor, fk_gruppe, sent_at) 
VALUES ('". $message . "', " . $fk_autor . ", " . $fk_gruppe . ", CURRENT_TIMESTAMP )");

header("Location: view.php");
?>