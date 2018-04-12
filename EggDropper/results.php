<?php
require_once 'basic.php';
require_once 'intermediate-naive.php';

echo sprintf("Número mínimo de intentos en el peor de los casos, nivel básico: %d\n", minEggDropper100());
echo sprintf("Número mínimo de intentos en el peor de los casos, nivel intermedio, solución naive: %d", minEggDropper2Naive());
