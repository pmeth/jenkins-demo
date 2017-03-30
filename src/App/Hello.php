<?php

namespace App;

class Hello
{
    public function hello($name)
    {
        return "Hello $name";
    }

    public function datetime($datespec)
    {
        $date = new \DateTime($datespec);
        return $date->format('Y-m-d');
    }
}
