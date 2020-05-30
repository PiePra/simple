<?php 
//create schema
$db = new SQLite3 ('test.sqlite');
$db->exec("CREATE TABLE nutzer (UID INTEGER PRIMARY KEY AUTOINCREMENT, nutzername Text NOT NULL UNIQUE, lastActive Datetime, fk_gruppe Integer)");

$db->exec("CREATE TABLE gruppe (GID INTEGER PRIMARY KEY AUTOINCREMENT, gruppenname Text NOT NULL UNIQUE, created Datetime)");

$db->exec("CREATE TABLE nachricht (MID Integer PRIMARY KEY AUTOINCREMENT, nachrichtentext Text, fk_autor Integer, fk_gruppe Integer, sent_at Datetime)");

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
$db->exec("insert into nachricht values (1, 'Hallo', 1, 1, CURRENT_TIMESTAMP)");
$db->exec("insert into nutzer values (1, 'Hans', CURRENT_TIMESTAMP, 1)");
$db->exec("insert into nutzer values (2, 'Dieter', CURRENT_TIMESTAMP, 1)");
$db->exec("insert into nachricht values (2, 'Hallo zwei', 1, 1, CURRENT_TIMESTAMP)");

echo "gutgut";

?>