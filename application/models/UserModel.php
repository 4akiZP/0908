<?php

class UserModel extends Model
{

  public static function checkUserDataHash($login)
    {
      // Соединение с БД
      $db = Db::getConnection();
      // Текст запроса к БД
      $sql = 'SELECT * FROM users WHERE login = :login';
      // Получение результатов. Используется подготовленный запрос
      $result = $db->prepare($sql);
      $result->bindParam(':login', $login, PDO::PARAM_STR);
      // Указываем, что хотим получить данные в виде массива
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $result->execute();
      return $result->fetch();
    }

}
