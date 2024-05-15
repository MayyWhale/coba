<?php

namespace App\Libraries\AHP;

use Exception;
use Phpml\Math\Matrix;

class PairwiseComparison extends Base
{
    public array $rowSum = [];
    public Matrix $pairwiseMatrix;

    public function __construct(
        array $features,
        public array $pairwise,
    ) {
        parent::__construct($features);
        $this->setPairwiseComparisenValue($pairwise);
    }

    public function setPairwiseComparisenValue(array $value)
    {
        if ($this->validatePairwiseValue($value)) {
            $this->pairwise = $value;
            $this->init();
        }
    }

    public function setFeatures(array $features)
    {
        $this->features = $features;
    }

    public function validatePairwiseValue(array $value)
    {
        if (!$this->ordo > 0) {
            throw new Exception('Ordo Matrix tidak lebih dari 0x0');
        }
        if ($this->ordo == 1) {
            throw new Exception('Ordo Matrix 1x1 tidak perlu untuk melakukan set pairwise value');
        }
        if (count($value) != $this->getPairwiseLength()) {
            throw new Exception("Panjang value untuk mengisi pairwise tidak valid, Panjang yang valid adalah {$this->getPairwiseLength()}");
        }
        return true;
    }

    protected function init()
    {
        $matrixValue = [];
        for ($row = 0; $row < $this->ordo; $row++) {
            $rowVal = [];
            for ($col = 0; $col < $this->ordo; $col++) {
                $rowVal[] = $row == $col ? 1 : 0;
            }
            $matrixValue[] = $rowVal;
        }

        $setter = $this->ordo - 1;
        $setterGo = $setter;
        $position = 0;
        $increment = 1;
        foreach ($this->pairwise as $i => $v) {
            if (!($i < $setterGo)) {
                $setter = $setter - 1;
                $setterGo = $setterGo + $setter;
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

        $this->pairwiseMatrix = new Matrix($matrixValue);

        $rowSum = [];
        for ($x = 0; $x < $this->ordo; $x++) {
            $rowSumVal = array_sum($this->getNormalizeMatrix()->toArray()[$x]);
            $rowSum[] = $rowSumVal;
        }

        $this->rowSum = $rowSum;
    }

    public function getColumnSum(): array
    {
        $result = [];
        for ($i = 0; $i < $this->ordo; $i++) {
            $result[] = array_sum($this->pairwiseMatrix->getColumnValues($i));
        }
        return $result;
    }

    public function getNormalizeMatrix(): Matrix
    {
        $matrix = $this->pairwiseMatrix->toArray();
        for ($col = 0; $col < $this->ordo; $col++) {
            for ($row = 0; $row < $this->ordo; $row++) {
                $value = $matrix[$col][$row] / $this->getColumnSum()[$row];
                $matrix[$col][$row] = (float)number_format($value, 3);
            }
        }
        return new Matrix($matrix);
    }
}