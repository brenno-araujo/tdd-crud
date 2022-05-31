<?php

namespace App\Model;

class Auction
{
    /** @var Bid[] */
    private $bids;
    /** @var string */
    private $description;

    public function __construct(string $description)
    {
        $this->description = $description;
        $this->bids = [];
    }

    private function itsFromTheLastUser(Bid $bid): bool
    {
        $lastBid = $this->bids[array_key_last($this->bids)];
        return $bid->getUser() == $lastBid->getUser();
    }

    private function quantityBidsPerUser(User $user): int
    {
        $totalBidsPerUser = array_reduce(
            $this->bids, 
            function ($total, Bid $bidActual) use ($user) {
                if ($bidActual->getUser() == $user) {
                    return $total + 1;
                }
                return $total;
        }, 0);
        return $totalBidsPerUser;
    }

    public function receiveBidding(Bid $bid)
    {
        if (!empty($this->bids) && $this->itsFromTheLastUser($bid)) {
            return;
        }
   
        $totalBidsPerUser = $this->quantityBidsPerUser($bid->getUser());

        if ($totalBidsPerUser >= 5) {
            return;
        }

        $this->bids[] = $bid;
    }

    /**
     * @return Bid[]
     */
    public function getBids(): array
    {
        return $this->bids;
    }
}
