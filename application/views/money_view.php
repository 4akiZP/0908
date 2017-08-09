<html>
<head></head>
<body>
  <?php if ($_SESSION['login']):    ?>
    <form action="money/change" method="post" class="form-login" style="display: block; width: 400px; margin: 0 auto;  padding: 20px; text-align: center;">
      <center><h2>Списать со счета</h2></center><br>
      На счету: <?php echo MoneyController::nowDb($_SESSION['login'])['sum'];?>
      <div class="os"></div>
      <input type="text" name="value" placeholder="value" />
      <div class="os"></div>
      <input type="submit" name="submit" class="btn btn-default" style="width: 120px;" value="Списать" />
      <div class="os"></div>
      Последние транзакции:
      <div class="os"></div>
      <?php
        $row = MoneyController::lastTransactions($_SESSION['login']);
        while (list($key, $val) = each($row))
        {
          echo $val."<br>";
        }
      ?>
      <div class="os"></div>
    </form>
  <?php else: ?>
    <div style="display: block; width: 400px; margin: 0 auto; background: #f2f1f0; padding: 20px; color:#555; text-align: center;">
      <a href='/login'>Авторизоваться</a>
    </div>
  <?php endif; ?>
       </body>
       </html>
