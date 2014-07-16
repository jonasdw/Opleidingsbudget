<?php

namespace Tactics\OpleidingsbudgetBundle\Helper;

use Money\Money;
use Money\Currency;

class Balans
{
    private $transactions;
    private $balans = 0;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;

    }

    public function getUserBalans()
    {
        foreach ($this->transactions as $transaction){
            $this->balans += floatval($transaction->getAmount()->getAmount());
        }

        return Money::EUR((int)$this->balans);
    }
}