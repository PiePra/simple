<?php 
//create schema
$db = new SQLite3 ('test.sqlite');
$db->exec("CREATE TABLE group(GID INTEGER PRIMARY KEY AUTOINCREMENT, name Text, created DATEtime)");
$db->exec("CREATE TABLE user(UID INTEGER PRIMARY KEY AUTOINCREMENT, name Text, lastActive DATEtime");
$db->exec("CREATE TABLE message(MID Integer PRIMARY KEY AUTOINCREMENT, text Text, fk_autor Integer, fk_gruppe Integer, sent_at Datetime)");

//
$db->exec("CREATE CREATE TRIGGER [IF NOT EXISTS] Message_Limit 
            After INSERT 
            ON message
            BEGIN
                delete from message
                    where MID not in (
                    select MID
                    from message
                    where GID == NEW.GID
                    order by Time desc
                    limit 15
                ) and GID = NEW.GID
                END;");
//update user lastActive after insert
$db->exec("CREATE TRIGGER [IF NOT EXISTS] Update_lastActive After Insert on message
            BEGIN
                update user set lastactive = CURRENT_TIMESTAMP where UID = NEW.fk_autor
            END;");
$db->exec("SELECT 
            name
        FROM 
            sqlite_master 
        WHERE 
            type ='table' AND 
            name NOT LIKE 'sqlite_%';");

$db->exec("insert into message values (1, 'Hallo', 1, 1, CURRENT_TIMESTAMP)");
?>