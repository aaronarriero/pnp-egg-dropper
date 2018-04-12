<?php
declare (strict_types = 1);

use PHPUnit\Framework\TestCase;

final class BasicTest extends TestCase
{

    public function testMidpoint(): void
    {
        // Casos sencillos de ejemplo
        $this->assertEquals(0, midpoint(0, 0));
        $this->assertEquals(1, midpoint(1, 1));
        $this->assertEquals(1, midpoint(1, 2));
        $this->assertEquals(2, midpoint(1, 3));

        // El orden de los argumentos importa
        $this->assertEquals(25, midpoint(1, 50));
        $this->assertNotEquals(25, midpoint(50, 1));

        // También admite números negativos
        $this->assertEquals(-15, midpoint(-10, -20));
    }

}
