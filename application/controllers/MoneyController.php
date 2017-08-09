<?php

class MoneyController extends Controller
{

  function actionIndex()
  {
    $this->view->generate('money_view.php', 'template_view.php');
  }

private static function updateDb($login,$value)
  {
    // Соединение с БД
    $db = Db::getConnection();
    // Текст запроса к БД
    $db->query("SET autocommit = 0");
    $db->beginTransaction();
    try {
    $sql = "SELECT * FROM purse WHERE user_id in (SELECT `id` from users WHERE login = '".$login."') LIMIT 1 FOR UPDATE;"; //запрещаем другим изменять
    $db->query($sql);
    $sql = "UPDATE purse SET sum=(sum-".$value.") WHERE user_id in (SELECT `id` from users WHERE login = '".$login."')"; //меняем значение на счету
    $db->query($sql);
    $sql = "INSERT INTO `transactions`(`user`, `date`, `value`) VALUES ('".$login."','".date("Y-m-d H:i:s")."','-".$value."')"; //добавляем лог операций
    $result = $db->query($sql);
    $db->commit();
    }
    catch (PDOException $e) {
        $dbh->rollBack();
        throw $e;
    }
    return $result;
  }

  public static function nowDb($login)
    {
      // Соединение с БД
      $db = Db::getConnection();
      // Текст запроса к БД
      $sql = "SELECT * FROM purse WHERE user_id in (SELECT `id` from users WHERE login = '".$login."') LIMIT 1;"; //текщее значение
      // Получение результатов. Используется подготовленный запрос
      $result = $db->prepare($sql);
      $result->bindParam(':login', $login, PDO::PARAM_STR);
      // Указываем, что хотим получить данные в виде массива
      $result->setFetchMode(PDO::FETCH_ASSOC);
      $result->execute();
      return $result->fetch();
    }

  public static function lastTransactions($login)
      {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "SELECT `date`,`value` FROM transactions WHERE user = '".$login."' ORDER BY `date` DESC"; //последние транзакции
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        return $result->fetch();
      }

	function actionChange() {
    $value = false;
    if (isset($_POST['submit'])) {
        $value = $_POST['value'];
        $errors = false;
        $check = MoneyController::updateDb($_SESSION['login'],$value);
        if ($check)
          {header("Location: /money");
          } else echo $check;
      }
	}

}
