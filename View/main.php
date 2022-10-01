<?php
/**
 * @var ViewController $this
 */

$page = $this->getData()['page'];
$limit = $this->getData()['limit'];
$countAllTasks = $this->getData()['countAll'];
$orderBy = $this->getData()['orderBy'];
$isAdmin = ($this->getData()['isAdmin']);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://localhost/project/src/css/main.css">
    <link rel="stylesheet" href="http://localhost/project/src/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/project/src/css/main.css">
    <title>Главная</title>
    <style>
        TABLE {
            width: 1500px;
            border: 2px solid black;
            background: silver;
        }

        TD, TH {
            text-align: center;
            padding: 3px;
        }

        TH {
            background: #4682b4;
            color: white;
            border-bottom: 2px solid black;
        }

        .lc {
            font-weight: bold;
            text-align: left;
        }
    </style>
</head>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<body>

<?php if ($isAdmin) { ?>
    <form class="text-xxl-end" action="http://localhost/project/src/index.php/main/logout">
        <button type="submit">Выйти</button>
    </form>
<?php } else { ?>
    <form class="text-xxl-end"  action="http://localhost/project/src/index.php/main/login">
        <button type="submit">Авторизация</button>
    </form>
<?php } ?>
<ul class="pagination">
    <li class="page-item">
        <a class="page-link" href="?by=status">По статусу</a></li>
    <li class="page-item">
        <a class="page-link" href="?by=user">По пользователю</a></li>
    <li class="page-item">
        <a class="page-link" href="?by=email">По email</a></li>
    <li class="page-item">
        <a class="page-link" href="?">Сбросить фильтры</a></li>
</ul>


<table>
    <tr>
        <td style="background: aliceblue"><h2>Пользователь</h2></td>
        <td style="background: aliceblue"><h2>Email</h2></td>
        <td style="background: aliceblue"><h2>Текст</h2></td>
        <td style="background: aliceblue"><h2>Статус задачи</h2></td>
    </tr>

    <?php
    foreach ($this->getData()['tasks'] as $task) {
        ?>
        <tr>
            <td><h2><?= $task['user'] ?></h2></td>
            <td><h2><?= $task['email'] ?></h2></td>
            <td><h2><?= $task['text'] ?></h2>
                <?php if ($isAdmin) { ?>
                    <form id="editText" method="post" action="http://localhost/project/src/index.php/main/edit">
                        <label>
                            <input hidden type="number" name="id" value="<?= $task['id'] ?>" >
                            <input  type="text" name="text" value="<?= $task['text'] ?>">
                        </label>
                        <button class="btn btn-light">Править</button>
                    </form> <?php } ?>
            </td>
            <td><h2><?= $task['status'] ?></h2>
                <?php if ($isAdmin) { ?>
                <form id="editStatus" method="post" action="http://localhost/project/src/index.php/main/edit">
                <p><label>
                        <select name="newStatus">
                            <option value="<?= $task['status'] ?>"><?= $task['status'] ?></option>
                                    <option value="Ожидание">Ожидание</option>
                                    <option value="В работе">В работе</option>
                                    <option value="Тестируется">Тестируется</option>
                                    <option value="Завершено">Завершено</option>
                                </select>
                    </label></p>
                    <input hidden type="number" name="id" value="<?= $task['id'] ?>" >
                    <p><input type="submit" value="Отправить"></p>
                </form>
                <?php } ?>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<ul class="pagination">
    <li class="page-item">
        <a class="page-link" href="?page=1&by=<?= $orderBy ?>">First</a></li>
    <li class="page-item">
        <a class="page-link" href="<?= ($page <= 1) ? '#&by=$orderBy' : "?by=$orderBy&page=" . ($page - 1); ?>">Prev</a>
    </li>
    <li class="page-item">
        <a class="page-link" href="<?php if ($page * $limit === $countAllTasks) {
            if ($page >= (int)($countAllTasks / $limit) + 1) {
                echo '#';
            }
            {
                echo "?by=$orderBy&page=" . ($page);
            }
        } else {
            if ($page >= (int)($countAllTasks / $limit) + 1) {
                echo '#';
            } else {
                echo "?by=$orderBy&page=" . ($page + 1);
            }
        } ?>">Next</a>
    </li>
    <li class="page-item">
        <a class="page-link"
           href="?by=<?= $orderBy ?>&page=<?= ($countAllTasks % $limit === 0) ? (int)($countAllTasks / $limit) : (int)($countAllTasks / $limit) + 1 ?>">Last</a>
    </li>
</ul>
<br>
<br>
<br>
<br>
<br>
<br>

<form action="http://localhost/project/src/index.php/main/AddTask" method="post">
    <div>
        <h3 class="text-center">Задайте новую задачу</h3>
        <div class="form-group">
            <input class="form-control item" type="text" name="user" id="user" placeholder="Логин">
        </div>
        <div class="form-group">
            <input class="form-control item" type="text" name="email" id="email" placeholder="email" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="text" name="text" id="text" placeholder="текст" required>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block create-account" type="submit">Добавить задачу</button>
        </div>
    </div>
</form>
</body>
</html>