<?php namespace Aaron\EggDropper;

use Aaron\EggDropper\Lib;
use Aaron\EggDropper\PartialSolution;

class Basic
{

    /**
     * Determinamos el número de veces que hay que lanzar un huevo para cada
     * criticalFloor. En cada iteración almacenamos el mínimo número de lanzamientos
     * necesarios del peor caso con la función max().
     *
     * El coste computacional de esta operación es O(n logn), ya que se realiza una
     * búsqueda binaria con coste (log n) por cada criticalFloor (n = 100).
     *
     * @return int El número de lanzamientos necesarios en el peor de los casos
     */
    public static function minEggDropper100(): int
    {
        $minDrops100 = 0;
        for ($criticalFloor = 0; $criticalFloor <= 100; $criticalFloor++) {
            $ps = self::solveFor($criticalFloor);
            $minDrops100 = max($minDrops100, $ps->drops);
        }
        return $minDrops100;
    }

    public static function solveFor(int $criticalFloor): PartialSolution
    {
        $ps = new PartialSolution(1, 100, $criticalFloor, 0, 100);
        while (!$ps->isSolved()) {
            $ps = Lib::solvePsBinarySearch($ps);
        }
        return $ps;
    }
}
