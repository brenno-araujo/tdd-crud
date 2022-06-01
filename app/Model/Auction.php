<?php

namespace App\Model;

class Auction
{
    /** @var Bid[] */
    private $bids;
    /** @var string */
    private $description;
    /** @var bool */
    private $isFinished;

    public function __construct(string $description)
    {
        $this->description = $description;
        $this->bids = [];
        $this->isFinished = false;
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
            throw new \DomainException('O usuário não pode propor dois lances seguidos.');
        }
   
        $totalBidsPerUser = $this->quantityBidsPerUser($bid->getUser());

        if ($totalBidsPerUser >= 5) {
            throw new \DomainException('O usuário não pode propor mais de cinco lances por leilão.');
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

    public function ends(): void
    {
        $this->isFinished = true;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }
}
