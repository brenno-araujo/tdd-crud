<?php 

namespace app\Service;

use App\Model\Auction;

class Evaluator
{

    private $highestValue;

    public function evaluate(Auction $model): void
    {
        $bids = $model->getBids();
        $lastBid = $bids[count($bids)-1];
        $this->highestValue = $lastBid;
    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }
    
}