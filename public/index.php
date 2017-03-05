<?php

require __DIR__ . '/../vendor/autoload.php';

$hello = new App\Hello();

echo $hello->hello('peter');

echo "\n<br><br>\n";
echo getenv('EC2_HOST');
