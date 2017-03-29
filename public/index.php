<?php

require __DIR__ . '/../vendor/autoload.php';

$hello = new App\Hello();
$date = new DateTime('next week');

$view = [
    'greeting' => $hello->hello('peter'),
    'host' => getenv('EC2_HOST'),
    'date' => $date->format('Y-m-d'),
];

?>

<html>
  <head>
    <title>Jenkins Demo</title>
  </head>
  <body>
    <h1><?= $view['greeting'] ?></h1>
    <div class="host"><?= $view['host'] ?></div>
    <div class="date"><?= $view['date'] ?></div>
  </body>
</html>
