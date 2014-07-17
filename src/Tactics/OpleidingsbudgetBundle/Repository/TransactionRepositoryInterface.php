<?php

namespace Tactics\OpleidingsbudgetBundle\Repository;

use Tactics\OpleidingsbudgetBundle\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function save(Transaction $transaction);
}