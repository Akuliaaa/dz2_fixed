<?php
$file = 'text.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = nl2br(htmlspecialchars(trim($_POST['message'])));
    
    if ($name && $email && $message) {
        $entry = "$name | $email | " . date('Y-m-d H:i:s') . " | $message\n";
        file_put_contents($file, $entry, FILE_APPEND);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$messages = [];
if (file_exists($file) && filesize($file) > 0) {
    $messages = array_reverse(file($file));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>dz2</title>
</head>
<body>
    <style>
        body{
            background: #040511;
            color: #fff;
        }
        form{
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            width: 30%;
        }
        input{
            margin: 2%;
            border: none;
            box-shadow: none;
            outline: none;
            padding: 8px;
            border-radius: 5px;
            background: #F1A93B;
        }
        textarea{
            margin: 5% 0 2% 0;
            border: none;
            box-shadow: none;
            outline: none;
            padding: 8px;
            border-radius: 5px;
            background: #F1A93B;
        }
        button{
            margin: auto;
            width: 200px;
            background: #F1B150;
            padding: 8px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
        }
    </style>
    <h1>Гостевая книга</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Ваше имя" required>
        <input type="email" name="email" placeholder="Ваш Email" required>
        <textarea name="message" placeholder="Ваше сообщение" required></textarea>
        <button type="submit">Отправить сообщение</button>
    </form>

    <h2>Сообщения:</h2>
    <div>
        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): list($name, $email, $datetime, $text) = explode('|', $msg); ?>
                <div>
                    <strong><?= trim($name) ?></strong> (<?= trim($email) ?>) <br>
                    <em><?= trim($datetime) ?></em> <br>
                    <p><?= trim($text) ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Сообщений пока нет.</p>
        <?php endif; ?>
    </div>
</body>
</html>