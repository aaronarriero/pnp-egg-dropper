<?php

use Aaron\EggDropper\Lib;
use PHPUnit\Framework\TestCase;

final class LibTest extends TestCase
{

    public function testMidpoint(): void
    {
        // Casos sencillos de ejemplo
        $this->assertEquals(0, Lib::midpoint(0, 0));
        $this->assertEquals(1, Lib::midpoint(1, 1));
        $this->assertEquals(1, Lib::midpoint(1, 2));
        $this->assertEquals(2, Lib::midpoint(1, 3));

        // El orden de los argumentos importa
        $this->assertEquals(25, Lib::midpoint(1, 50));
        $this->assertNotEquals(25, Lib::midpoint(50, 1));

        // También admite números negativos
        $this->assertEquals(-15, Lib::midpoint(-10, -20));
    }

}
