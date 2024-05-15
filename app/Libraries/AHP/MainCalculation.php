<?php

namespace App\Libraries\AHP;

use Phpml\Math\Matrix;
use Exception;
use stdClass;

class MainCalculation
{
    public array $IR = [
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

    public int $ordo = 0;
    public array $pairwise = [];
    public array $columnSum = [];
    public array $rowSum = [];
    public array $priority = [];
    public array $prioritySub = [];
    public array $rowSumMatrixVal = [];
    public Matrix $pairwiseMatrix;
    public Matrix $normalizeMatrix;
    public Matrix $rowSumMatrix;


    public object $constRatio;

    public function __construct(
        public array $features = [],
    ) {
        $this->setMatrixOrdo();
    }

    public function setPairwiseComparisenValue(array $value)
    {
        if ($this->validatePairwiseValue($value)) {
            $this->pairwise = $value;
            $this->init();
            $this->constRatio = $this->generateCR();
        }
        


    }

    protected function init()
    {
        // Generate Pairwise Comparison Matrix
        $matrixValue = [];
        for ($row = 0; $row < $this->ordo; $row++) {
            $rowVal = [];
            for ($col = 0; $col < $this->ordo; $col++) {
                $rowVal[] = $row == $col ? 1 : 0;
            }
            $matrixValue[] = $rowVal;
        }

        $setter = $this->ordo - 1;
        $position = 0;
        $increment = 1;
        foreach ($this->pairwise as $i => $v) {
            if (!($i < $setter)) {
                $setter = $setter + ($setter - 1);
                $position += 1;
                $increment = 1;
            }
            $v = $v == 0 ? 1 : ($v > 0 ? $v + 1 : $v - 1);
            $Xval = $v > 0 ? abs($v) : 1 / abs($v);
            $Yval = $v < 0 ? abs($v) : 1 / abs($v);
            $matrixValue[$position][$position + $increment] = $Xval < 1 ? (float)number_format($Xval, 3) : $Xval;
            $matrixValue[$position + $increment][$position] = $Yval < 1 ? (float)number_format($Yval, 3) : $Yval;
            $increment++;
        }

        $matrix = $matrixValue;
        $this->pairwiseMatrix = new Matrix($matrix);

        // Generate Jumlah per kolom dari Pairwise Comparison Matrix
        $columnSum = [];
        for ($i = 0; $i < $this->ordo; $i++) {
            $columnSum[] = array_sum($this->pairwiseMatrix->getColumnValues($i));
        }
        $this->columnSum = $columnSum;


        // Normalisasi Matrix
        $matrix2 = $matrix;
        for ($col = 0; $col < $this->ordo; $col++) {
            for ($row = 0; $row < $this->ordo; $row++) {
                $value = $matrix2[$col][$row] / $columnSum[$row];
                $matrix2[$col][$row] = (float)number_format($value, 3);
            }
        }
        $rowSum = [];
        $priority = [];
        for ($x = 0; $x < $this->ordo; $x++) {
            $rowSumVal = array_sum($matrix2[$x]);
            $rowSum[] = $rowSumVal;
            $priority[] = (float)number_format($rowSumVal / $this->ordo, 3);
        }
        $this->rowSum = $rowSum;
        $this->priority = $priority;
        $this->normalizeMatrix = new Matrix($matrix2);

        // Menentukan sub prioritas untuk sub kriteria
        $priorityMax = max($priority);
        $prioritySub = [];
        for ($i = 0; $i < $this->ordo; $i++) {
            $prioritySub[] = (float)number_format($priority[$i] / $priorityMax, 3);
        }
        $this->prioritySub = $prioritySub;

        // Matrix Penjumlahan setiap baris
        $matrix3 = $matrix;

        $result = [];

        for ($col = 0; $col < $this->ordo; $col++) {
            for ($row = 0; $row < $this->ordo; $row++) {
                $value = $matrix3[$col][$row] * $priority[$row];
                $matrix3[$col][$row] = (float)number_format($value, 3);
            }
        }

        for ($x = 0; $x < $this->ordo; $x++) {
            $result[] = array_sum($matrix3[$x]);
        }

        $this->rowSumMatrixVal = $result;

        $this->rowSumMatrix = new Matrix($matrix3);
    }

    protected function generateCR(): object
    {
        $result = new stdClass;
        $result->jumlah = array_sum($this->rowSumMatrixVal) + array_sum($this->priority);
        $result->n = $this->ordo;
        $result->lambdaMax = (float)number_format($result->jumlah / $result->n, 3);
        $result->IR = $this->IR[$result->n];
        $result->CI = (float)number_format(($result->lambdaMax - $result->n) / ($result->n - 1), 3);
        $result->CR = (float)number_format($result->CI / $result->IR, 3);
        $result->consistency = $result->CR <= 0.1;
        return $result;
    }

    public function getValidatePairwiseLength(): int
    {
        return (pow($this->ordo, 2) - $this->ordo) / 2;
    }

    public function validatePairwiseValue(array $value)
    {
        if (!$this->ordo > 0) {
            throw new Exception('Ordo Matrix tidak lebih dari 0x0');
        }
        if ($this->ordo == 1) {
            throw new Exception('Ordo Matrix 1x1 tidak perlu untuk melakukan set pairwise value');
        }
        if (count($value) != $this->getValidatePairwiseLength()) {
            throw new Exception("Panjang value untuk mengisi pairwise tidak valid, Panjang yang valid adalah {$this->getValidatePairwiseLength()}");
        }
        return true;
    }

    protected function setMatrixOrdo()
    {
        $this->ordo = count($this->features);
    }
}