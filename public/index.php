<?php

require __DIR__ . '/../vendor/autoload.php';

$hello = new App\Hello();

echo $hello->hello('peter');

echo "\n<br><br>\n";
echo getenv('EC2_HOST');
echo "\n<br>I am in (not) York Region<br>";
echo "Hi Bob";
