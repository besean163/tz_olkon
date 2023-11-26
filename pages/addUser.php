<!DOCTYPE html>
<html>

<head>
  <title>OLKON_TZ</title>
</head>

<body>
  <form action="/addUser" method="POST">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0 ?>" />
    <label for="login">Логин: </label>
    <input type="text" name="login" id="login" value="<?php echo isset($login) ? $login : '' ?>" />
    <br />
    <label for="password">Пароль: </label>
    <input type="text" name="password" id="password" value="<?php echo isset($password) ? $password : '' ?>" />
    <br />
    <label for="role">Роль: </label>
    <input type="text" name="role" id="role" value="<?php echo isset($role) ? $role : '' ?>" />
    <br />
    <?php
    if ($error !== '') {
      echo sprintf("<div>%s</div>", $error);
    }
    ?>
    <input type="submit" value="Сохранить">
  </form>
  <a href="/users">Назад</a>


</html>