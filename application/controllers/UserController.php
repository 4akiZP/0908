<?php

class UserController extends Controller
{

  function actionIndex()
  {
    $this->view->generate('login_view.php', 'template_view.php');
  }

  private function verify($password, $hashedPassword, $login) {
    $salt = substr(md5($login), 0, 22);
    return hash_equals(crypt($password, $salt), $hashedPassword); // сверка паролей
  }

  public static function auth($login)
{
    // Записываем идентификатор пользователя в сессию
    $_SESSION['login'] = $login;
    session_write_close();
}

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


	function actionLogin() {
    $login = false;
    $password = false;
    if (isset($_POST['submit'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $errors = false;
        $check = UserController::checkUserDataHash($login);
        $hashed_password = $check['password'];
        if ($this->verify($password,$hashed_password,$login))
          {UserController::auth($login); //если такой есть записываем в сессию
          }
      }
	}

  public static function userAuthorized()
{
    if (isset($_SESSION['login'])) return false;
    else return true;
}

  public function actionLogout(){
    unset($_SESSION["login"]);
    session_destroy();
    header("Location: /money");
    return true;
  }
}
