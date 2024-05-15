<?php

namespace App\Libraries\AHP;

use Phpml\Math\Matrix;

class ConstRatio extends Base
{
    public float $jumlah;
    public int $n;
    public float $lambdaMax;
    public float $randomIndexVal;
    public float $constIndexVal;
    public float $constRatioVal;
    public bool $consistency;

    public function __construct(
        public Matrix $matrix,
        public array $priority = [],
    ) {
        $this->generateConstRatio();
    }

    public function getRowSumMatrix(): Matrix
    {
        $matrix = $this->matrix->toArray();
        $ordo = count($matrix);

        for ($col = 0; $col < $ordo; $col++) {
            for ($row = 0; $row < $ordo; $row++) {
                $value = $matrix[$col][$row] * $this->priority[$row];
                $matrix[$col][$row] = (float)number_format($value, 3);
            }
        }

        return new Matrix($matrix);
    }

    protected function generateConstRatio()
    {
        $rowSum = [];
        $priority = $this->priority;
        $ordo = count($priority);

        for ($x = 0; $x < $ordo; $x++) {
            $rowSum[] = array_sum($this->getRowSumMatrix()->toArray()[$x]);
        }

        $jumlah = array_sum($rowSum) + array_sum($priority);
        $n = $ordo;
        $lambdaMax = (float)number_format($jumlah / $n, 3);
        $IR = $this->randomIndex[$n];
        $CI = (float)number_format(($lambdaMax - $n) / ($n - 1), 3);
        $CR = (float)number_format($CI / $IR, 3);
        $consistency = $CR <= 0.1;

        $this->jumlah = $jumlah;
        $this->n = $n;
        $this->lambdaMax = $lambdaMax;
        $this->randomIndexVal = $IR;
        $this->constIndexVal = $CI;
        $this->constRatioVal = $CR;
        $this->consistency = $consistency;
    }
}