<?php namespace Aaron;

require_once 'bootstrap.php';
use Aaron\EggDropper\Basic;
use Aaron\EggDropper\Hard;
use Aaron\EggDropper\Intermediate;

echo sprintf("Número mínimo de intentos en el peor de los casos, nivel básico: %d\n", Basic::minEggDropper100());
echo sprintf("Número mínimo de intentos en el peor de los casos, nivel intermedio: %d\n", Intermediate::minEggDropper2());
echo sprintf("Número mínimo de intentos en el peor de los casos, nivel difícil:\n");
$cases = [
    [100, 100],
    [100, 2],
    [100, 1],
    [200, 2],
    [500, 2],
    [1000, 2],
    [100, 3],
    [100, 4],
    [100, 5],
    [1000, 1000],
];
foreach ($cases as $case) {
    $maxFloor = $case[0];
    $eggs = $case[1];
    echo sprintf("Pisos: %d\tHuevos: %d\tIntentos: %d\n", $maxFloor, $eggs, Hard::minEggDropperX($maxFloor, $eggs));
}
