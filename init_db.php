<?php 
#create schema
$db = new SQLite3 ('production.sqlite');
#table nutzer
$db->exec("CREATE TABLE nutzer (UID INTEGER PRIMARY KEY AUTOINCREMENT, nutzername Text NOT NULL UNIQUE, lastActive Datetime, fk_gruppe Integer)");
#table gruppe
$db->exec("CREATE TABLE gruppe (GID INTEGER PRIMARY KEY AUTOINCREMENT, gruppenname Text NOT NULL UNIQUE, created Datetime)");
#table nachricht
$db->exec("CREATE TABLE nachricht (MID Integer PRIMARY KEY AUTOINCREMENT, nachrichtentext Text NOT NULL, fk_autor Integer, fk_gruppe Integer, sent_at Datetime)");

#trigger to save only a group's last 15 messages 
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
//trigger to update lastActive timestamp after sending a message
$db->exec("CREATE TRIGGER updateLastActive After INSERT ON nachricht
            BEGIN
                update nutzer set lastActive = CURRENT_TIMESTAMP where UID = NEW.fk_autor;
            END");

#user feedback after database creation
echo "database created";

?>