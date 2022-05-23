<?php

namespace Testsz\Service;

use App\Model\Auction;
use App\Model\Bid;
use App\Model\User;
use App\Service\Evaluator;
use PHPUnit\Framework\TestCase;

class EvaluatorTest extends TestCase
{
    public function testEvaluate()
    {
        $auction = new Auction('Fiat Pulse');

        $brenno = new User('Brenno');
        $joão = new User('João');

        $auction->receiveBidding(new Bid($brenno, 100.0));
        $auction->receiveBidding(new Bid($joão, 150.0));

        $leiloeiro = new Evaluator();
        $leiloeiro->evaluate($auction);

        $highestValue = $leiloeiro->getHighestValue();

        self::assertEquals(1500.0, $highestValue);

    }
}