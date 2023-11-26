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
        <th>Столбец 1</th>
        <th>Столбец 2</th>
        <th>Столбец 3</th>
        <?php
        if ($isAdmin) {
          echo " <th></th>";
          echo " <th></th>";
        }
        ?>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($items as $item) {
        $row = '';
        $row .= sprintf("<td>%d</td>", $item->id);
        $row .= sprintf("<td>%s</td>", $item->param_1);
        $row .= sprintf("<td>%s</td>", $item->param_2);
        $row .= sprintf("<td>%s</td>", $item->param_3);

        if ($isAdmin) {
          $row .= sprintf("<td>%s</td>", sprintf("<a href='/edit/%d'>Редактировать</a>", $item->id));
          $row .= sprintf("<td>%s</td>", sprintf("<a href='/delete/%d'>Удалить</a>", $item->id));
        }

        echo sprintf("<tr>%s</tr>", $row);
      }
      ?>
    </tbody>
  </table>
  <a href="/add">Добавить</a>
  <?php if ($isAdmin) {
    echo sprintf('<a href="/users">Пользователи</a>');
  } ?>
  <a href="/logout">Выйти</a>
</body>

</html>