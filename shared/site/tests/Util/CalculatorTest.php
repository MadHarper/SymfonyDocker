<?php

namespace App\Tests\Util;

use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase{

    public function testAdd()
    {
        $x = 10 + 32;

        $this->assertEquals(42, $x);
    }
}