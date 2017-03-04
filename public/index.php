<?php

require __DIR__ . '/../vendor/autoload.php';

$hello = new App\Hello();

echo $hello->hello('peter');
