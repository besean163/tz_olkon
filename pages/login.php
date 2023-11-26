<!DOCTYPE html>
<html>

<head>
  <title>OLKON_TZ</title>
</head>

<body>
  <form action="" method="post" class="form-example">
    <div class="form-example">
      <label for="login">Логин: </label>
      <input type="text" name="login" id="login" value="<?php echo isset($login) ? $login : '' ?>" required />
    </div>
    <div class="form-example">
      <label for="password">Пароль: </label>
      <input type="password" name="password" id="password" value="<?php echo isset($password) ? $password : '' ?>" required />
    </div>
    <div class="form-example">
      <input type="submit" value="Вход" />
    </div>
  </form>
  <?php
  if ($error !== '') {
    echo sprintf("<div>%s</div>", $error);
  }
  ?>
</body>

</html>