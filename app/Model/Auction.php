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
        $lastBid = $this->bids[count($this->bids) - 1];
        return $bid->getUser() == $lastBid->getUser();
    }

    public function receiveBidding(Bid $bid)
    {
        if (!empty($this->bids) && $bid->getUser() == $this->itsFromTheLastUser($bid)) {
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
