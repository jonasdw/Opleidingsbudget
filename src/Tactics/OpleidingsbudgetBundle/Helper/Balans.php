<?php

namespace Tactics\OpleidingsbudgetBundle\Helper;

use Money\Money;
use Money\Currency;

class Balans
{
    private $transactions;
    private $balans;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function getUserBalans()
    {
        $this->balans = Money::EUR(0);

        foreach ($this->transactions as $transaction){

            $this->balans = $this->balans->add($transaction->getAmount());
        }

        return $this->balans;
    }
}