<?php

use Aaron\EggDropper\Lib;
use Aaron\EggDropper\PartialSolution;
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

    /**
     * Caso de ejemplo que muestra la acotación realizada mediante el algoritmo
     * de búsqueda binaria. $floors indica el [$minFloor, $maxFloor] tras cada
     * iteración hasta que converge en el piso superior a $criticalFloor.
     */
    public function testSolvePsBinarySearch(): void
    {
        $floors = [
            [51, 100],
            [51, 75],
            [51, 63],
            [51, 57],
            [51, 54],
            [51, 52],
            [51, 51],
        ];
        $index = 0;
        $ps = new PartialSolution(1, 100, 50, 0, 100);
        while (!$ps->isSolved()) {
            $ps = Lib::solvePsBinarySearch($ps);
            $this->assertEquals($floors[$index][0], $ps->minFloor);
            $this->assertEquals($floors[$index][1], $ps->maxFloor);
            $index++;
        }
    }

    /**
     * Caso de ejemplo que muestra el número necesario de lanzamientos mediante
     * el algoritmo de búsqueda por saltos.
     *
     * @return void
     */
    public function testSolvePsJumpSearch(): void
    {
        $currentFloor = 14;
        $floorsToClimb = 13;
        $ps = new PartialSolution(1, 100, 100, 0, 2);
        while (2 === $ps->eggs && !$ps->isSolved()) {
            $ps = Lib::solvePsJumpSearch($ps, $currentFloor, $floorsToClimb);
            $currentFloor = $currentFloor + $floorsToClimb;
            $floorsToClimb--;
        }
        $this->assertEquals(12, $ps->drops);
    }

    /**
     * Caso de ejemplo que muestra el número necesario de lanzamientos mediante
     * el algoritmo de búsqueda secuencial.
     *
     * @return void
     */
    public function testSolvePsSequential(): void
    {
        $ps = new PartialSolution(1, 100, 100, 0, 1);
        while (!$ps->isSolved()) {
            $ps = Lib::solvePsSequential($ps);
        }
        $this->assertEquals(99, $ps->drops);
    }
}
