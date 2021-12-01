<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div><p>Hello!</p></div>
    <?php
    // header('Location: /rpm');
    // use vlucas\phpdotenv\src\Dotenv;

    $dotenv = new Dotenv\Dotenv(__DIR__);
    // include('../src/Dotenv.php');
    // $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    echo getenv("TEST");
    // echo $_ENV['TEST'];
    ?>
</body>
</html>