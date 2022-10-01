<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Авторизация </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<form action="index.php" method="post">
    <div class="registration-cssave">
        <form>
            <h3 class="text-center">Форма входа</h3>
            <div class="form-group">
                <input class="form-control item" type="text" name="username" maxlength="15" minlength="4" pattern="^[a-zA-Z0-9_.-]*$" id="username" placeholder="Логин" required>
            </div>
            <div class="form-group">
                <input class="form-control item" type="password" name="Пароль" minlength="6" id="password" placeholder="Пароль" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block create-account" type="submit">Вход в аккаунт</button>
            </div>
        </form>
    </div>
</form>
</body>
</html>