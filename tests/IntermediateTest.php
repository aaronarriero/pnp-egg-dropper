<?php

use Aaron\EggDropper\Intermediate;
use PHPUnit\Framework\TestCase;

final class IntermediateTest extends TestCase
{

    /**
     * Comprobamos que usando el algoritmo intermedio las soluciones encontradas
     * son válidas.
     */
    public function testSolutionsAreValid(): void
    {
        $algorithm = new Intermediate();
        $minDrops2 = 0;
        for ($criticalFloor = 1; $criticalFloor <= 100; $criticalFloor++) {
            $ps = $algorithm->solveFor($criticalFloor);

            // Comprobamos que se ha llegado a una solución
            $this->assertEquals(true, $ps->isSolved());

            // Almacenamos el peor caso
            $minDrops2 = max($minDrops2, $ps->drops);
        }
        // Resolviendo el problema en papel sabemos que el peor caso lleva 14
        // intentos
        $this->assertEquals(14, $minDrops2);
    }
}
