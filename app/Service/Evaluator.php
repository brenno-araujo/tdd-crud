<?php 

namespace App\Service;

use App\Model\Auction;

class Evaluator
{

    private $highestValue = -INF;
    private $lowerValue = INF;

    public function evaluate(Auction $model): void
    {
        $bids = $model->getBids();
        foreach ($bids as $bid) {
            if ($bid->getValue() > $this->highestValue) {
                $this->highestValue = $bid->getValue();
            }
            if ($bid->getValue() < $this->lowerValue) {
                $this->lowerValue = $bid->getValue();
            }
        }
    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }

    public function getLowerValue(): float
    {
        return $this->lowerValue;
    }
    
}