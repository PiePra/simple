<?php 
//create schema
$db = new SQLite3 ('production.sqlite');
$db->exec("CREATE TABLE nutzer (UID INTEGER PRIMARY KEY AUTOINCREMENT, nutzername Text NOT NULL UNIQUE, lastActive Datetime, fk_gruppe Integer)");

$db->exec("CREATE TABLE gruppe (GID INTEGER PRIMARY KEY AUTOINCREMENT, gruppenname Text NOT NULL UNIQUE, created Datetime)");

$db->exec("CREATE TABLE nachricht (MID Integer PRIMARY KEY AUTOINCREMENT, nachrichtentext NOT NULL Text, fk_autor Integer, fk_gruppe Integer, sent_at Datetime)");

//
$db->exec("CREATE TRIGGER nachrichtLimit 
            After INSERT 
            ON nachricht
            BEGIN
                delete from nachricht
                    where MID not in (
                    select MID
                    from nachricht
                    where fk_gruppe == NEW.fk_gruppe
                    order by sent_at desc
                    limit 15
                ) and fk_gruppe = NEW.fk_gruppe;
                END");
//update user lastActive after insert
$db->exec("CREATE TRIGGER updateLastActive After INSERT ON nachricht
            BEGIN
                update nutzer set lastActive = CURRENT_TIMESTAMP where UID = NEW.fk_autor;
            END");

echo "database created";

?>