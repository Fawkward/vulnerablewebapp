<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


if (!isset($_SESSION['token'])) {

    header("Location: index.php");
    exit();
} else {


    $username = $_SESSION['username'];
}

$connection = mysqli_connect("localhost", "kali", "kali", "my_new_database");

if (!$connection) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}



if (isset($_POST['submit_comment'])) {
    $comment = mysqli_real_escape_string($connection, $_POST['comment']);
    $username = mysqli_real_escape_string($connection, $_SESSION['username']);


    if (!empty($comment)) {
        $query = "INSERT INTO comments (username, comment) VALUES ('$username', '$comment')";
        if (mysqli_query($connection, $query)) {
            echo "Комментарий добавлен!";
        } else {
            echo "Ошибка добавления комментария: " . mysqli_error($connection);
        }
    } else {
        echo "Комментарий не может быть пустым.";
    }
}



$query = "SELECT * FROM comments ORDER BY created_at DESC";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-direction: column;
            height: 100vh;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            text-align: center;
            margin-top: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #e53935;
        }

        input[type="text"], textarea {
            padding: 10px;
            width: 80%;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .comment {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }

        .comment .username {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Добро пожаловать!</h1>
    <!-- Отображаем приветственное сообщение с именем пользователя из сессии -->
    <p>Привет, <?php echo $username; ?>! Вы успешно авторизованы.</p>

    <!-- Кнопка выхода из системы -->
    <a href="logout.php">
        <button class="logout-btn">Выйти</button>
    </a>

    <!-- Форма для добавления комментария -->
    <h2>Оставьте свой комментарий:</h2>
    <form method="POST" action="">
        <textarea name="comment" placeholder="Введите ваш комментарий" required></textarea><br>
        <input type="submit" name="submit_comment" value="Добавить комментарий">
    </form>

    <h2>Комментарии:</h2>

    <!-- Отображение всех комментариев -->
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='comment'>";
        // Уязвимость: данные не экранируются
        echo "<p class='username'>" . $row['username'] . "</p>";
        echo "<p>" . $row['comment'] . "</p>";
        echo "<p><small>Добавлено: " . $row['created_at'] . "</small></p>";
        echo "</div>";
    }

    // Закрываем соединение с базой данных
    mysqli_close($connection);
    ?>
</div>

</body>
</html>
