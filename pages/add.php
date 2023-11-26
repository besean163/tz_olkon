<!DOCTYPE html>
<html>

<head>
  <title>OLKON_TZ</title>
</head>

<body>
  <form action="/add" method="POST">
    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : 0 ?>" />
    <label for="param_1">Столбец 1: </label>
    <input type="text" name="param_1" id="param_1" value="<?php echo isset($param_1) ? $param_1 : '' ?>" />
    <br />
    <label for="param_2">Столбец 2: </label>
    <input type="text" name="param_2" id="param_2" value="<?php echo isset($param_2) ? $param_2 : '' ?>" />
    <br />
    <label for="param_3">Столбец 3: </label>
    <input type="text" name="param_3" id="param_3" value="<?php echo isset($param_3) ? $param_3 : '' ?>" />
    <br />
    <input type="submit" value="Сохранить">
  </form>

</html>