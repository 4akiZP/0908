<html>
<head></head>
<body>
  <?php if (UserController::userAuthorized()):    ?>
      <form action="user/login" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
      <center><h2>Авторизация</h2></center><br>
      <input type="text" name="login" placeholder="login" /><br><br><br>
      <input type="password" name="password" placeholder="Пароль" /><br><br><br>
      <div class="os"></div>
      <input type="submit" name="submit" class="btn btn-default" style="width: 120px;" value="Вход" />
      <div class="os"></div>
  </form>
  <?php else: ?>
      <div style="display: block; width: 400px; margin: 0 auto; background: #f2f1f0; padding: 20px; color:#555; text-align: center;">
          <center><h2 style="color:#555;">Вы уже авторизированы </h2></center>
          <form action="user/logout" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
            <input type="submit" name="submit" class="btn btn-default" style="width: 120px;" value="Выход" />
          </form>
          <a href='/money'>Сделать транзакцию</a>
      </div>
  <?php endif; ?>
       </body>
       </html>
