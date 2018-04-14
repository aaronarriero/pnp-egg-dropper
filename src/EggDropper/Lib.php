<?php namespace Aaron\EggDropper;

/**
 * Esta clase contiene funciones comunes a los diversos métodos de resolución
 * del problema.
 */

class Lib
{

    /**
     * Resuelve una iteración del algoritmo de búsqueda binaria. Su
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

    /**
     * Resuelve una iteración del algoritmo de búsqueda mediante saltos. El
     * algoritmo empieza en un piso relativamente bajo y sube dando saltos hasta
     * agotar el espacio de soluciones.
     */
    public static function solvePsJumpSearch(PartialSolution $ps, int $currentFloor, int $floorsToClimb): PartialSolution
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
     * Resuelve una iteración del algoritmo de búsqueda secuencial.
     */
    public static function solvePsSequential(PartialSolution $ps): PartialSolution
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

    /**
     * Determina el número entero medio entre dos números. Si dos números son
     * válidos favorece al más pequeño. Por ejemplo, midpoint(1, 2) devuelve 1.
     * El resultado es correcto sólo si $min es menor o igual a $max.
     *
     * @param int $min Un número igual o menor a $max.
     * @param int $max Un número igual o mayor a $min.
     * @return int El número entero medio truncado entre $min y $max.
     */
    public static function midpoint(int $min, int $max): int
    {
        return $min + intdiv($max - $min, 2);
    }

    /**
     * Determina si un huevo se rompe o no si se lanza desde una cierta planta
     * dado $criticalFloor.
     */
    public static function doesEggBreak($floor, $criticalFloor): bool
    {
        return $floor > $criticalFloor;
    }
}
