<?php

namespace Tactics\OpleidingsbudgetBundle\Repository;

use Tactics\OpleidingsbudgetBundle\Entity\ExpenseRequest;

interface ExpenseRequestRepositoryInterface
{
    public function save(ExpenseRequest $expenseRequest);
}