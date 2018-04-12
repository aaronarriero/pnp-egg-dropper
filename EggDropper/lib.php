<?php
/**
 * Este fichero contiene funciones comunes a los diversos métodos de resolución
 * del problema.
 */

/**
 * Determina el número entero medio entre dos números. Si dos números son
 * válidos favorece al más pequeño. Por ejemplo, midpoint(1, 2) devuelve 1.
 * El resultado es correcto sólo si $min es menor o igual a $max.
 *
 * @param int $min Un número igual o menor a $max.
 * @param int $max Un número igual o mayor a $min.
 * @return int El número entero medio truncado entre $min y $max.
 */
function midpoint(int $min, int $max): int
{
    return $min + intdiv($max - $min, 2);
}

function doesEggBreak($floor, $criticalFloor)
{
    return $floor > $criticalFloor;
}
