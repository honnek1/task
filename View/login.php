<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>
<h1>Вход</h1>
</head>
<body>
<form method="post" action="http://localhost/project/src/index.php/main/login">
    <div class="row">
        <label for="user">Пользователь</label>
        <input name="user" id="user" autocomplete="off" >
    </div>
    <div class="row">
        <label for="pass">Пароль</label>
        <input type="password" name="pass" id="pass" autocomplete="off">
    </div>
    <br>
    <div class="row">
        <input type="submit">
    </div>
</form>
</body>
</html>