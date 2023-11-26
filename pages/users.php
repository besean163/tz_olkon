<!DOCTYPE html>
<html>

<head>
  <title>OLKON_TZ</title>
</head>

<body>
  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Логин</th>
        <th>Пароль</th>
        <th>Роль</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($items as $item) {
        $row = '';
        $row .= sprintf("<td>%d</td>", $item->id);
        $row .= sprintf("<td>%s</td>", $item->login);
        $row .= sprintf("<td>%s</td>", $item->password);
        $row .= sprintf("<td>%s</td>", $item->role);
        $row .= sprintf("<td>%s</td>", sprintf("<a href='/editUser/%d'>Редактировать</a>", $item->id));
        $row .= sprintf("<td>%s</td>", sprintf("<a href='/deleteUser/%d'>Удалить</a>", $item->id));

        echo sprintf("<tr>%s</tr>", $row);
      }
      ?>
    </tbody>
  </table>
  <a href="/">Главная</a>
  <a href="/addUser">Добавить</a>
  <a href="/logout">Выйти</a>
</body>

</html>