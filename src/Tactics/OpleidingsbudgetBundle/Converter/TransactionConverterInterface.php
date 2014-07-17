<?php

namespace Tactics\OpleidingsbudgetBundle\Converter;

use Tactics\OpleidingsbudgetBundle\Entity\Transaction;

interface TransactionConverterInterface
{


    public function convert(Transaction $transaction);
}