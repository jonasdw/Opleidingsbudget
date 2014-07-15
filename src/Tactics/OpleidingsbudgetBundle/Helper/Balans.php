<?php

namespace Tactics\OpleidingsbudgetBundle\Helper;

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
            $this->balans += floatval($transaction->getAmount());
          //  var_dump($transaction->getAmount());
        }

        return $this->balans;
    }
}