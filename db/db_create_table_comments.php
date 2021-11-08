
<?php

try {
  $db_path = $_SERVER['DOCUMENT_ROOT'] . '/db/users.db';
  $db = new PDO("sqlite:$db_path");
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $q = $db->prepare('DROP TABLE IF EXISTS comments');
  $q->execute();
  $q = $db->prepare('CREATE TABLE comments(
    comment_id        SERIAL UNIQUE,
    comment_text      TEXT,
    comment_image_path TEXT,
    comment_time      TIMESTAMP,
    comment_time_last_edit TIMESTAMP,
    user_uuid INT,
    post_id INT,
    PRIMARY KEY(comment_id)
    FOREIGN KEY(user_uuid) REFERENCES users (user_uuid)
    FOREIGN KEY(post_id) REFERENCES posts (post_id)
  ) WITHOUT ROWID');
  $q->execute();
} catch (PDOException $ex) {
  echo $ex;
}
