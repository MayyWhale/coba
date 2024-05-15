<?php

namespace App\Libraries\AHP;

class MainCriteria extends PairwiseComparison
{
    public array $rowSum;

    public function __construct(
        array $features,
        array $pairwise,
    ) {
        parent::__construct($features, $pairwise);
    }

    public function getPriority(): array
    {
        $priority = [];
        for ($x = 0; $x < $this->ordo; $x++) {
            $priority[] = (float)number_format($this->rowSum[$x] / $this->ordo, 3);
        }

        return $priority;
    }

    public function getConstRatio(): ConstRatio
    {
        return new ConstRatio($this->pairwiseMatrix, $this->getPriority());
    }
}