<?php

namespace Tests\Model;

use App\Model\Auction;
use App\Model\Bid;
use App\Model\User;
use PHPUnit\Framework\TestCase;

class AuctionTest extends TestCase
{
    /**
     * @dataProvider createBids
     */
    public function testAuction(int $bidsQuantity, Auction $auction, array $values)
    {
        static::assertCount($bidsQuantity, $auction->getBids());

        foreach ($values as $key => $value) {
            static::assertEquals($value, $auction->getBids()[$key]->getValue());
        }
    }

    public function testAuctionMustNotAcceptFiveBidsPerUser()
    {
        $auction = new Auction('Ihpone 7');
        $cardinJr = new User('cardinJr');
        $joseJr = new User('joseJr');

        $auction->receiveBidding(new Bid($cardinJr, 1000));
        $auction->receiveBidding(new Bid($joseJr, 2000));
        $auction->receiveBidding(new Bid($cardinJr, 3000));
        $auction->receiveBidding(new Bid($joseJr, 4000));
        $auction->receiveBidding(new Bid($cardinJr, 5000));
        $auction->receiveBidding(new Bid($joseJr, 6000));
        $auction->receiveBidding(new Bid($cardinJr, 7000));
        $auction->receiveBidding(new Bid($joseJr, 8000));
        $auction->receiveBidding(new Bid($cardinJr, 9000));        
        $auction->receiveBidding(new Bid($joseJr, 10000));
        $auction->receiveBidding(new Bid($cardinJr, 11000));

        static::assertCount(10, $auction->getBids());
        static::assertEquals(10000, $auction->getBids()[array_key_last($auction->getBids())]->getValue());



    }

    public function testAuctionShouldNotReceiveEqualBids()
    {
        $ana = new User('ana');
        $auction = new Auction('Playstation 20');
        $auction->receiveBidding(new Bid($ana, 100));
        $auction->receiveBidding(new Bid($ana, 200));

        static::assertCount(1, $auction->getBids());
        static::assertEquals(100, $auction->getBids()[0]->getValue());
    }

    public function createBids()
    {
        $joao = new User('João');
        $maria = new User('Maria');

        $auctionTwoBids = new Auction('Macbook Pro 15');
        $auctionTwoBids->receiveBidding(new Bid($joao, 1000));
        $auctionTwoBids->receiveBidding(new Bid($maria, 2000));

        $auctionOneBid = new Auction('Macbook Pro 20');
        $auctionOneBid->receiveBidding(new Bid($maria, 5000));

        return [
            'two-bid' => [2, $auctionTwoBids, [1000, 2000]],
            'one-bids' => [1, $auctionOneBid, [5000]]
        ];
    }
}