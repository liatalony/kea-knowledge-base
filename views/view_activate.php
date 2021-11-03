<?php

try{
    $db_path = $_SERVER['DOCUMENT_ROOT'].'/db/users.db';
    $db = new PDO("sqlite:$db_path");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('UPDATE users
                      SET active = :active
                      WHERE user_uuid = :user_uuid');
    $q->bindValue(':active', 1);
    $q->bindValue(':user_uuid', $user_uuid);

    $q->execute();
    $user = $q->fetch();
  
    header('Location: /login');

  }catch(PDOException $ex){
    echo $ex;
  }
