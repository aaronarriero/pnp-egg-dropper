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
        for ($criticalFloor = 1; $criticalFloor <= 100; $criticalFloor++) {
            $ps = new PartialSolution(1, 100, $criticalFloor, 0, 100);
            while (!$ps->isSolved()) {
                $ps = self::solvePsBinarySearch($ps);
            }
            $minDrops100 = max($minDrops100, $ps->drops);
        }
        return $minDrops100;
    }

    /**
     * Esta función resuelve una iteración del algoritmo de búsqueda binaria. Su
     * funcionamiento consiste en lanzar un huevo desde la planta intermedia
     * entre $minFloor y $maxFloor, sin embargo al no conocer criticalFloor, no
     * podemos detener la búsqueda una vez que $currentFloor === $criticalFloor.
     *
     * Si el huevo se rompe exploramos pisos inferiores. No acotamos el piso
     * superior ($currentFloor - 1) ya que de hacerlo el algoritmo nunca
     * convergería.
     *
     * Si el huevo no se rompe exploramos pisos superiores. Esta vez sí es
     * necesario acotar el piso inferior ($currentFloor + 1).
     */
    public static function solvePsBinarySearch(PartialSolution $ps): PartialSolution
    {
        // Determinamos desde qué piso lanzamos el huevo
        $currentFloor = Lib::midpoint($ps->minFloor, $ps->maxFloor);

        $ps->drops++;
        if (Lib::doesEggBreak($currentFloor, $ps->criticalFloor)) {
            // Acotamos la búsqueda descartando la mitad superior
            $ps->maxFloor = $currentFloor;
            $ps->eggs--;
        } else {
            // Acotamos la búsqueda descartando la mitad inferior más una planta
            $ps->minFloor = $currentFloor + 1;
        }
        return $ps;
    }
}
