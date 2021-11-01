
<?php

try {
  $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
  $db = new PDO("sqlite:$db_path");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $q = $db->prepare('DROP TABLE IF EXISTS users');
  $q->execute();
  $q = $db->prepare('CREATE TABLE users(
    user_uuid         SERIAL UNIQUE,
    first_name        TEXT,
    last_name         TEXT,
    email             TEXT UNIQUE,
    age               INT,
    user_password     TEXT,
    user_role         INT,
    active            BOOLEAN,
    PRIMARY KEY(user_uuid)
  ) WITHOUT ROWID');
  $q->execute();
} catch (PDOException $ex) {
  echo $ex;
}
