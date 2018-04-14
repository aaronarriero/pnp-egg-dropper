<?php namespace Aaron\EggDropper;

use Aaron\EggDropper\Lib;
use Aaron\EggDropper\PartialSolution;

class Hard
{

    /**
     * Determinamos el número de veces que hay que lanzar un huevo para cada
     * criticalFloor, dado un número de plantas $maxFloor y huevos $eggs.
     */
    public static function minEggDropperX($maxFloor, $eggs): int
    {
        $minDropsX = 0;
        for ($criticalFloor = 0; $criticalFloor <= $maxFloor; $criticalFloor++) {
            $ps = self::solveFor($criticalFloor, $maxFloor, $eggs);
            $minDropsX = max($minDropsX, $ps->drops);
        }
        return $minDropsX;
    }

    /**
     * Encuentra el número mínimo de lanzamientos necesarios para averiguar un
     * cierto criticalFloor dado un número de pisos $maxFloor y huevos $eggs.
     * Para lograrlo de la forma más eficiente empleamos todos los algoritmos
     * que hemos aplicado en cada dificultad en orden, dependiendo del número de
     * huevos restantes.
     */
    public static function solveFor(int $criticalFloor, int $maxFloor, int $eggs): PartialSolution
    {
        $ps = new PartialSolution(1, $maxFloor, $criticalFloor, 0, $eggs);

        // Casos base en los cuales no es necesario aplicar ningún algoritmo
        if ($eggs <= 0 || $maxFloor <= 0) {
            return $ps;
        }

        // Mientras tengamos huevos de sobra, aplicamos el algoritmo más
        // eficiente, que es el de búsqueda binaria.
        while ($ps->eggs >= 3 && !$ps->isSolved()) {
            $ps = Lib::solvePsBinarySearch($ps);
        }

        // Una vez nos queden sólo dos huevos, aplicamos el algoritmo de
        // búsqueda por saltos. Determinamos la planta desde la que empezamos
        // (F) en función del número de plantas restantes (R) resolviendo la
        // ecuación F*F + F - R*2 = 0
        $remainingFloors = $ps->maxFloor - $ps->minFloor;
        $optimalFloor = Lib::getOptimalFloor($remainingFloors);

        // Empezamos desde la planta más baja que queda por explorar, más la
        // planta óptima, menos uno ya que la planta más baja posible es 1.
        $currentFloor = $ps->minFloor + $optimalFloor - 1;
        $floorsToClimb = $currentFloor - 1;

        while (2 === $ps->eggs && !$ps->isSolved()) {
            $ps = Lib::solvePsJumpSearch($ps, $currentFloor, $floorsToClimb);
            $currentFloor = $currentFloor + $floorsToClimb;
            $floorsToClimb--;
        }

        // Finalmente, si todavía no hemos encontrado la solución, aplicamos el
        // algoritmo secuencial para evitar romper el último huevo antes de
        // encontrar la solución.
        while (!$ps->isSolved()) {
            $ps = Lib::solvePsSequential($ps);
        }

        return $ps;
    }
}
