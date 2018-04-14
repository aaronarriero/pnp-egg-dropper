<?php namespace Aaron\EggDropper;

use Aaron\EggDropper\Lib;
use Aaron\EggDropper\PartialSolution;

class Intermediate
{

    /**
     * Determinamos el número de veces que hay que lanzar un huevo para cada
     * criticalFloor.
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
     * cierto criticalFloor. Para lograrlo de la forma más eficiente empleamos
     * el algoritmo de búsqueda por saltos con el primer huevo y el secuencial
     * con el segundo, ya que el primer algoritmo no garantiza que el huevo no
     * se rompa hasta agotar el espacio de soluciones.
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
    public static function solveFor(int $criticalFloor, $startingFloor = 14): PartialSolution
    {
        $currentFloor = $startingFloor;
        $floorsToClimb = $startingFloor - 1;
        $ps = new PartialSolution(1, 100, $criticalFloor, 0, 2);

        while (2 === $ps->eggs && !$ps->isSolved()) {
            $ps = Lib::solvePsJumpSearch($ps, $currentFloor, $floorsToClimb);
            $currentFloor = $currentFloor + $floorsToClimb;
            $floorsToClimb--;
        }
        while (!$ps->isSolved()) {
            $ps = Lib::solvePsSequential($ps);
        }

        return $ps;
    }
}
