
<?php

try {
  $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
  $db = new PDO("sqlite:$db_path");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $q = $db->prepare('DROP TABLE IF EXISTS posts');
  $q->execute();
  $q = $db->prepare('CREATE TABLE posts(
    post_id        SERIAL UNIQUE,
    post_text      TEXT,
    post_image_path TEXT,
    post_time      TIMESTAMP,
    post_time_last_edit TIMESTAMP,
    user_uuid INT,
    PRIMARY KEY(post_id)
    FOREIGN KEY(user_uuid) REFERENCES users (user_uuid)
  ) WITHOUT ROWID');
  $q->execute();
} catch (PDOException $ex) {
  echo $ex;
}
