<?php namespace Aaron;

require_once 'bootstrap.php';
use Aaron\EggDropper\Basic;
use Aaron\EggDropper\Hard;
use Aaron\EggDropper\Intermediate;

echo sprintf("Número mínimo de intentos en el peor de los casos, nivel básico: %d\n", Basic::minEggDropper100());
echo sprintf("Número mínimo de intentos en el peor de los casos, nivel intermedio: %d\n", Intermediate::minEggDropper2());
echo sprintf("Número mínimo de intentos en el peor de los casos, nivel difícil:\n");
$cases = [
    [0, 0],
    [0, 1],
    [1, 0],
    [1, 1],
    [100, 100],
    [100, 2],
];
foreach ($cases as $case) {
    $maxFloor = $case[0];
    $eggs = $case[1];
    echo sprintf("Pisos: %d\tHuevos: %d\tIntentos: %d\n", $maxFloor, $eggs, Hard::minEggDropperX($maxFloor, $eggs));
}
