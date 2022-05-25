<?php

namespace Testsz\Service;

use App\Model\Auction;
use App\Model\Bid;
use App\Model\User;
use App\Service\Evaluator;
use PHPUnit\Framework\TestCase;

class EvaluatorTest extends TestCase
{
    public function testAppraiserMustFindeTheHighestBid()
    {
        $auction = new Auction('Fiat Pulse');

        $brenno = new User('Brenno');
        $joão = new User('João');

        $auction->receiveBidding(new Bid($brenno, 1500.0));
        $auction->receiveBidding(new Bid($joão, 150.0));

        $leiloeiro = new Evaluator();
        $leiloeiro->evaluate($auction);

        $highestValue = $leiloeiro->getHighestValue();

        self::assertEquals(1500.0, $highestValue);
    }

    public function testAppraiserMustFindeTheLowerBid()
    {
        $auction = new Auction('Fiat Pulse');

        $brenno = new User('Brenno');
        $joão = new User('João');

        $auction->receiveBidding(new Bid($brenno, 1500.0));
        $auction->receiveBidding(new Bid($joão, 150.0));

        $leiloeiro = new Evaluator();
        $leiloeiro->evaluate($auction);

        $lowerValue  = $leiloeiro->getLowerValue();

        self::assertEquals(150.0, $lowerValue);
    }

    public function testThreeGratestValues()
    {
        $auction = new Auction('Fiat Pulse');

        $brenno = new User('Brenno');
        $joão = new User('João');
        $genivaldo = new User('Genivaldo');
        $cardim = new User('Cardim');

        $auction->receiveBidding(new Bid($brenno, 1500.0));
        $auction->receiveBidding(new Bid($joão, 150.0));
        $auction->receiveBidding(new Bid($genivaldo, 100.0));
        $auction->receiveBidding(new Bid($cardim, 50.0));


        $leiloeiro = new Evaluator();
        $leiloeiro->evaluate($auction);

        $highestBids  = $leiloeiro->getHighestBids();

        static::assertCount(3, $highestBids);
        static::assertEquals(1500.0, $highestBids[0]->getValue());
        static::assertEquals(150.0, $highestBids[1]->getValue());
        static::assertEquals(100.0, $highestBids[2]->getValue());
    }

}