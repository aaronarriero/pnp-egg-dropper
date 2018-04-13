<?php namespace Aaron\EggDropper;

use Aaron\EggDropper\Lib;
use Aaron\EggDropper\PartialSolution;

class Intermediate
{

    /**
     * Determinamos el número de veces que hay que lanzar un huevo para cada
     * criticalFloor. En este caso sólo disponemos de dos huevos, por lo que
     * arriesgamos el primero realizando una búsqueda binaria de forma similar al
     * método básico, hasta que se rompa. Esta operación lleva un cierto número de
     * intentos, y acota la búsqueda a un cierto rango de plantas que devuelve la
     * función binarySearchOneEgg().
     *
     * Con el último huevo somos mucho más cuidadosos, lanzándolo desde el primer
     * piso dentro del rango de pisos restante, subiendo las plantas de una en una
     * hasta dar con criticalFloor.
     *
     * Con esta aproximación varía mucho el número de lanzamientos dependiendo de
     * criticalFloor. Por ejemplo, si criticalFloor = 50
     */
    public static function minEggDropper2(): int
    {
        $minDrops2 = 0;
        for ($criticalFloor = 1; $criticalFloor <= 100; $criticalFloor++) {
            $ps = self::solveFor($criticalFloor);
            $minDrops2 = max($minDrops2, $ps->drops);
        }
        return $minDrops2;
    }

    public static function solveFor($criticalFloor): PartialSolution
    {
        $ps = new PartialSolution(1, 100, $criticalFloor, 0, 2);
        while (2 === $ps->eggs && !$ps->isSolved()) {
            $ps = self::solvePsBinarySearch($ps);
        }
        while (!$ps->isSolved()) {
            $ps = self::solvePsSequential($ps);
        }
        return $ps;
    }

    private static function solvePsBinarySearch($ps): PartialSolution
    {
        // Ya se ha explorado todo el espacio de soluciones
        if ($ps->minFloor === $ps->maxFloor) {
            return $ps;
        }

        // Determinamos desde qué piso lanzamos el huevo
        $currentFloor = Lib::midpoint($ps->minFloor, $ps->maxFloor);

        // Si el huevo se rompe terminamos la búsqueda devolviendo el rango que
        // queda por comprobar y el número de intentos hasta ahora.
        if (Lib::doesEggBreak($currentFloor, $ps->criticalFloor)) {
            $ps->maxFloor = $currentFloor;
            $ps->eggs--;
        } else {
            $ps->minFloor = $currentFloor + 1;
        }
        $ps->drops++;
        return $ps;
    }

    /**
     * Determina el número de veces que hay que lanzar un sólo huevo para averiguar
     * $criticalFloor, de forma secuencial desde $minFloor hasta $maxFloor,
     * pretendiendo no conocer $criticalFloor.
     *
     * @param int $minFloor
     * @param int $maxFloor
     * @param int $criticalFloor
     * @return PartialSolution
     */
    private static function solvePsSequential(PartialSolution $ps): PartialSolution
    {
        $ps->drops++;
        if (Lib::doesEggBreak($ps->minFloor, $ps->criticalFloor)) {
            $ps->eggs--;
            $ps->maxFloor = $ps->minFloor;
        } else {
            $ps->minFloor++;
        }
        return $ps;
    }
}
