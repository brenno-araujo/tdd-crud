<?php

namespace Testsz\Service;

use App\Model\Auction;
use App\Model\Bid;
use App\Model\User;
use App\Service\Evaluator;
use PHPUnit\Framework\TestCase;

class EvaluatorTest extends TestCase
{
    /** Evaluator */
    private $evaluator;

    protected function setUp(): void
    {
        $this->evaluator = new Evaluator();
    }

    /**
     * @dataProvider auctionAsc
     * @dataProvider auctionDesc
     */
    public function testEvaluatHighest(Auction $auction)
    {
        $this->evaluator->evaluate($auction);
        $highestValue = $this->evaluator->getHighestValue();
        self::assertEquals(300, $highestValue);
    }

    /**
     * @dataProvider auctionAsc
     * @dataProvider auctionDesc
     */
    public function testEvaluatSmaller(Auction $auction)
    {
        $this->evaluator->evaluate($auction);
        $lowerValue = $this->evaluator->getLowerValue();
        self::assertEquals(100, $lowerValue);
    }

    public function testEvaluationEmptyCannotBeRated()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Não é possível avaliar o leilão sem lances.');
        $auction = new Auction('Nintendo Switch');
        $this->evaluator->evaluate($auction);
    }

    public function auctionAsc()
    {
        $auction = new Auction('Fiat Pulse');

        $brenno = new User('Brenno');
        $joão = new User('João');
        $maria = new User('Maria');

        $auction->receiveBidding(new Bid($maria, 100));
        $auction->receiveBidding(new Bid($joão, 200));
        $auction->receiveBidding(new Bid($brenno, 300));

        return [
            'asc' => [$auction]
        ];
    }

    public function auctionDesc()
    {
        $auction = new Auction('Fiat Pulse');

        $brenno = new User('Brenno');
        $joão = new User('João');
        $maria = new User('Maria');

        $auction->receiveBidding(new Bid($maria, 300));
        $auction->receiveBidding(new Bid($joão, 200));
        $auction->receiveBidding(new Bid($brenno, 100));

        return [
            'desc' => [$auction]
        ];
    }

}
