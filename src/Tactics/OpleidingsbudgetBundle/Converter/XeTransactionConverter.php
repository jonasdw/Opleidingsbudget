<?php

namespace Tactics\OpleidingsbudgetBundle\Converter;

use Tactics\OpleidingsbudgetBundle\Entity\Transaction;

class XeTransactionConverter implements TransactionConverterInterface
{
    public function convert(Transaction $transaction)
    {
        // http://www.xe.com/datafeed/faq.php
        // 1. retrieve xe xml
        // 2. retrieve correct conversion rate from the xml
        // 3. create currency pair with that conversion rate
        // 4. convert the transaction

        var_dump("this is converter!");
    }
}