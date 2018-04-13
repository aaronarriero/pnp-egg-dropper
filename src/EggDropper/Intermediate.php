<?php namespace Aaron\EggDropper;

use Aaron\EggDropper\Lib;
use Aaron\EggDropper\PartialSolution;

class Intermediate
{

    /**
     * Determinamos el número de veces que hay que lanzar un huevo para cada
     * criticalFloor. En este caso sólo disponemos de dos huevos, por lo que
     * arriesgamos el primero realizando una búsqueda dando saltos desde un piso
     * relativamente bajo, hasta que se rompa. Esta operación lleva un cierto
     * número de intentos, y acota la búsqueda a un cierto rango de plantas que
     * devuelve la función solvePsJumpSearch().
     *
     * Con el último huevo somos mucho más cuidadosos, lanzándolo desde el
     * primer piso dentro del rango de pisos restante, subiendo las plantas de
     * una en una hasta dar con criticalFloor.
     *
     * Con esta aproximación el número de lanzamientos es mucho más consistente,
     * siendo comprendido entre 3 y 14.
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

    /**
     * Encuentra el número mínimo de lanzamientos necesarios para averiguar un
     * cierto criticalFloor. Esta vez el algoritmo empleado para el primer huevo
     * empieza en un piso relativamente bajo y sube dando saltos hasta agotar el
     * espacio de soluciones.
     *
     * Una vez roto el primer huevo el algoritmo empleado consiste en realizar
     * un lanzamiento de forma secuencial desde la planta más baja hasta la más
     * alta que queda por comprobar.
     *
     * El piso óptimo desde el cual es necesario empezar, considerando que hay
     * 100 pisos en total, es 14. En cada iteración se sube una planta menos que
     * la iteración anterior.
     *
     * Para obtener este número es necesario recordar que estamos tratando de
     * minimizar el número de lanzamientos necesarios. Llamamos N al piso
     * óptimo, y L al número de lanzamientos realizados. Si el primer huevo se
     * rompe, será necesario comprobar secuencialmente las (N - L) plantas
     * restantes. Tras cada lanzamiento, L se incrementa en uno. Esto da lugar a
     * la progresión: N + (N - 1) + (N - 2) ...
     *
     * Como el edificio tiene 100 plantas, la progresión debe dar un número
     * mayor o igual a 100. Si simplificamos la progresión, ésta es equivalente
     * a N (N + 1) / 2 >= 100, ecuación que da un resultado de 14 una vez
     * redondeado.
     *
     * Alternativamente puede encontrarse este número a la fuerza probando todos
     * sus valores posibles.
     */
    public static function solveFor(int $criticalFloor): PartialSolution
    {
        $currentFloor = 14;
        $floorsToClimb = $currentFloor - 1;
        $ps = new PartialSolution(1, 100, $criticalFloor, 0, 2);
        while (2 === $ps->eggs && !$ps->isSolved()) {
            $ps = self::solvePsJumpSearch($ps, $currentFloor, $floorsToClimb);
            $currentFloor = $currentFloor + $floorsToClimb;
            $floorsToClimb--;
        }
        while (!$ps->isSolved()) {
            $ps = self::solvePsSequential($ps);
        }
        return $ps;
    }

    /**
     * Resuelve una iteración del algoritmo de búsqueda mediante saltos.
     */
    private static function solvePsJumpSearch(PartialSolution $ps, int $currentFloor, int $floorsToClimb): PartialSolution
    {
        $ps->drops++;
        if (Lib::doesEggBreak($currentFloor, $ps->criticalFloor)) {
            $ps->maxFloor = $currentFloor;
            $ps->eggs--;
        } else {
            $ps->minFloor = $currentFloor + 1;
            $ps->maxFloor = $currentFloor + $floorsToClimb;
        }
        return $ps;
    }

    /**
     * Determina el número de veces que hay que lanzar un sólo huevo para averiguar
     * $criticalFloor, de forma secuencial desde $minFloor hasta $maxFloor,
     * pretendiendo no conocer $criticalFloor.
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
