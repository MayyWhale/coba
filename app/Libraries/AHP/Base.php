<?php

namespace App\Libraries\AHP;

class Base
{
    public array $randomIndex = [
        1 => 0.00,
        2 => 0.00,
        3 => 0.58,
        4 => 0.90,
        5 => 1.12,
        6 => 1.24,
        7 => 1.32,
        8 => 1.41,
        9 => 1.45,
        10 => 1.49,
        11 => 1.51,
        12 => 1.48,
        13 => 1.56,
        14 => 1.57,
        15 => 1.59,
    ];

    public int $ordo;

    public function __construct(
        public array $features = [],
    ) {
        $this->setMatrixOrdo();
    }

    protected function setMatrixOrdo()
    {
        $this->ordo = count($this->features);
    }

    public function getPairwiseLength(): int
    {
        return (pow($this->ordo, 2) - $this->ordo) / 2;
    }
}