<?php

use PHPUnit\Framework\TestCase;
use App\Hello;

class HelloTest extends TestCase
{
    private $subject;

    public function setUp()
    {
        $this->subject = new Hello;
    }

    public function testHello()
    {
        $this->assertEquals('Hello peter', $this->subject->hello('peter'));
    }
}
