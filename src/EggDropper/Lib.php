<?php namespace Aaron\EggDropper;

/**
 * Esta clase contiene funciones comunes a los diversos métodos de resolución
 * del problema.
 */

class Lib
{

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