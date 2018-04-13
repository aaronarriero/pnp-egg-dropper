<?php namespace Aaron\EggDropper;

use Aaron\EggDropper\Lib;

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
            $drops = self::exploreFloorsBinarySearch(1, 100, $criticalFloor);
            $minDrops100 = max($minDrops100, $drops);
        }
        return $minDrops100;
    }

    /**
     * Esta función determina el número mínimo de veces que es necesario lanzar un
     * huevo para averiguar criticalFloor. Su funcionamiento es similar al de una
     * búsqueda binaria, sin embargo como no conocemos criticalFloor, no podemos
     * detener la búsqueda una vez que $currentFloor === $criticalFloor.
     *
     * Es por esto que el algoritmo continúa la búsqueda acotando $minFloor y
     * $maxFloor hasta que ambas son iguales. Llegado a este punto se ha explorado
     * todo el espacio de soluciones y se devuelve el número de $drops o
     * lanzamientos que han sido necesarios.
     *
     * Si $currentFloor > $criticalFloor el huevo se rompe, por lo que exploramos
     * pisos inferiores. No acotamos el piso superior ($currentFloor - 1) ya que de
     * hacerlo el algoritmo nunca convergería.
     *
     * Si $currentFloor <= $criticalFloor, el huevo no se rompe, por lo que
     * exploramos pisos superiores. Esta vez sí es necesario acotar el piso inferior
     * ($currentFloor + 1).
     */
    public static function exploreFloorsBinarySearch(int $minFloor, int $maxFloor, int $criticalFloor, int $drops = 0): int
    {
        // Ya se ha explorado todo el espacio de soluciones
        if ($minFloor === $maxFloor) {
            return $drops;
        }

        // Determinamos desde qué piso lanzamos el huevo
        $currentFloor = Lib::midpoint($minFloor, $maxFloor);

        if (!Lib::doesEggBreak($currentFloor, $criticalFloor)) {
            // Acotamos la búsqueda descartando la mitad superior
            return self::exploreFloorsBinarySearch($minFloor, $currentFloor, $criticalFloor, $drops + 1);
        } else {
            // Acotamos la búsqueda descartando la mitad inferior
            return self::exploreFloorsBinarySearch($currentFloor + 1, $maxFloor, $criticalFloor, $drops + 1);
        }
    }
}
