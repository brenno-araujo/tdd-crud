<?php 

namespace App\Service;

use App\Model\Auction;
use App\Model\Bid;

class Evaluator
{

    private $highestValue = -INF;
    private $lowerValue = INF;
    private $highestBids = [];

    public function evaluate(Auction $model): void
    {

        if ($model->isFinished()) {
            throw new \DomainException('Leilão já finalizado.');
        }

        if (empty($model->getBids())) {
            throw new \DomainException('Não é possível avaliar o leilão sem lances.');
        }

        $bids = $model->getBids();
        foreach ($bids as $bid) {
            if ($bid->getValue() > $this->highestValue) {
                $this->highestValue = $bid->getValue();
            }
            if ($bid->getValue() < $this->lowerValue) {
                $this->lowerValue = $bid->getValue();
            }
        }
        usort($bids, function (Bid $bidOne, Bid $bidTwo) {
            return $bidTwo->getValue() - $bidOne->getValue();
        });
        $this->highestBids = array_slice($bids, 0, 3);

    }

    public function getHighestValue(): float
    {
        return $this->highestValue;
    }

    public function getLowerValue(): float
    {
        return $this->lowerValue;
    }

    public function getHighestBids(): array
    {
        return $this->highestBids;
    }
    
}