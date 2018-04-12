<?php
require_once '../bootstrap.php';

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
function minEggDropper2Naive(): int
{
    $minFloor = 1;
    $maxFloor = 100;
    $minDrops2 = 0;

    for ($criticalFloor = $minFloor; $criticalFloor <= $maxFloor; $criticalFloor++) {
        $searchResults = binarySearchOneEgg($minFloor, $maxFloor, $criticalFloor);
        $binarySearchDrops = $searchResults['drops'];
        $sequentialSearchDrops = sequentialSearchOneEgg($searchResults['minFloor'], $searchResults['maxFloor'], $criticalFloor);
        $totalDrops = $binarySearchDrops + $sequentialSearchDrops;
        $minDrops2 = max($minDrops2, $totalDrops);
    }
    return $minDrops2;
}

/**
 * Determina el rango de pisos en los que se encuentra $criticalFloor y el
 * número de lanzamientos empleados usando un sólo huevo.
 *
 * @return array
 */
function binarySearchOneEgg(int $minFloor, int $maxFloor, int $criticalFloor, int $drops = 0): array
{
    // Ya se ha explorado todo el espacio de soluciones
    if ($minFloor === $maxFloor) {
        return [
            'minFloor' => $minFloor,
            'maxFloor' => $maxFloor,
            'drops' => $drops,
        ];
    }

    // Determinamos desde qué piso lanzamos el huevo
    $currentFloor = midpoint($minFloor, $maxFloor);

    // Si el huevo se rompe terminamos la búsqueda devolviendo el rango que
    // queda por comprobar y el número de intentos hasta ahora.
    if (doesEggBreak($currentFloor, $criticalFloor)) {
        return [
            'minFloor' => $minFloor,
            'maxFloor' => $currentFloor,
            'drops' => $drops + 1,
        ];
    } else {
        // Acotamos la búsqueda descartando la mitad inferior
        return binarySearchOneEgg($currentFloor + 1, $maxFloor, $criticalFloor, $drops + 1);
    }
}

/**
 * Determina el número de veces que hay que lanzar un sólo huevo para averiguar
 * $criticalFloor, de forma secuencial desde $minFloor hasta $maxFloor,
 * pretendiendo no conocer $criticalFloor.
 *
 * @param int $minFloor
 * @param int $maxFloor
 * @param int $criticalFloor
 * @return void
 */
function sequentialSearchOneEgg(int $minFloor, int $maxFloor, int $criticalFloor)
{
    $drops = 0;
    for ($floor = $minFloor; $floor < $maxFloor; $floor++) {
        $drops++;
        if (doesEggBreak($floor, $criticalFloor)) {
            break;
        }
    }
    return $drops;
}
