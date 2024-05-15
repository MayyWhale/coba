<?php

namespace App\Libraries\AHP;

use stdClass;

class SubCriteria extends PairwiseComparison
{
    public array $rowSum;
    public array $priorityMain;

    public function __construct(
        array $features,
        array $pairwise,
    ) {
        parent::__construct($features, $pairwise);
    }

    public function getPriority(): object
    {
        $result = new stdClass;
        $priority = [];
        for ($x = 0; $x < $this->ordo; $x++) {
            $priority[] = (float)number_format($this->rowSum[$x] / $this->ordo, 3);
        }

        $priorityMax = max($priority);
        $prioritySub = [];
        for ($i = 0; $i < $this->ordo; $i++) {
            $prioritySub[] = (float)number_format($priority[$i] / $priorityMax, 3);
        }

        $result->main = $priority;
        $result->sub = $prioritySub;

        return $result;
    }

    public function getConstRatio(): ConstRatio
    {
        return new ConstRatio($this->pairwiseMatrix, $this->getPriority()->main);
    }
}