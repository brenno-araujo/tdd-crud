<?php 

namespace App\Service;

use App\Model\Auction;

class Evaluator
{

    private $highestValue;

    public function evaluate(Auction $model): void
    {
        $bids = $model->getBids();
        $lastBid = end($bids);
        $this->highestValue = $lastBid->getValue();
    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }
    
}