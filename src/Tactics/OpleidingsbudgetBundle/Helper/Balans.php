<?php

namespace Tactics\OpleidingsbudgetBundle\Helper;

use Money\Money;
use Money\CurrencyPair;

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
        $pair = CurrencyPair::createFromIso('USD/EUR 1.2500');

        $this->balans = Money::EUR(0);

        foreach ($this->transactions as $transaction)
        {
                $this->balans = $this->balans->add($transaction->getAmount());
        }

        return $this->balans;
    }
}