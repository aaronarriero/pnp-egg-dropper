<?php namespace Aaron;

require_once 'bootstrap.php';
use Aaron\EggDropper\Basic;
use Aaron\EggDropper\Intermediate;

echo sprintf("Número mínimo de intentos en el peor de los casos, nivel básico: %d\n", Basic::minEggDropper100());
echo sprintf("Número mínimo de intentos en el peor de los casos, nivel intermedio: %d", Intermediate::minEggDropper2());
