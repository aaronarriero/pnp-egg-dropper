<?php namespace Aaron\EggDropper;

/**
 * Clase que almacena el estado de una solución parcial al problema. Una
 * solución parcial comprende toda la información necesaria para determinar el
 * estado de la resolución del problema.
 *
 * $minFloor y $maxFloor indican el rango restante de pisos que queda por
 * comprobar.
 *
 * $drops es el número de lanzamientos de huevo que se han realizado.
 *
 * $eggs indica el número de huevos restantes.
 */
class PartialSolution
{

    public $minFloor;
    public $maxFloor;
    public $criticalFloor;
    public $drops;
    public $eggs;

    public function __construct($minFloor, $maxFloor, $criticalFloor, $drops, $eggs)
    {
        $this->minFloor = $minFloor;
        $this->maxFloor = $maxFloor;
        $this->criticalFloor = $criticalFloor;
        $this->drops = $drops;
        $this->eggs = $eggs;
    }

    /**
     * Una solución parcial se considera resuelta cuando se ha explorado todo el
     * espacio de soluciones, es decir, cuando el rango de pisos entre $minFloor
     * y $maxFloor se ha explorado completamente.
     *
     * Cuando se ha esta situación, y si no se han usado más huevos de los
     * disponibles, $drops indica el número de lanzamientos que han sido
     * necesarios para determinar $criticalFloor.
     */
    public function isSolved(): bool
    {
        return $this->eggs >= 0 && $this->minFloor == $this->maxFloor;
    }

}
