<?php
require './vendor/autoload.php';
use App\Model\Auction;
use App\Model\Bid;
use App\Model\User;
use App\Service\Evaluator;

$auction = new Auction('Fiat Pulse');

$brenno = new User('Brenno');
$joão = new User('João');

$auction->receiveBidding(new Bid($brenno, 100.0));
$auction->receiveBidding(new Bid($joão, 150.0));

$leiloeiro = new Evaluator();
$leiloeiro->evaluate($auction);

$highestValue = $leiloeiro->getHighestValue();

echo ($highestValue === 150.0) ? 'OK' : 'Failed';
