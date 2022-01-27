<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/db.php');

try {
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $q = $db->prepare('UPDATE users
                      SET active = :active
                      WHERE user_uuid = :user_uuid');
  $q->bindValue(':active', 1);
  $q->bindValue(':user_uuid', $user_uuid);

  $q->execute();
  $user = $q->fetch();

  header('Location: /webdev/kea-kb/login');
} catch (PDOException $ex) {
  echo $ex;
}
