<?php

namespace Tactics\OpleidingsbudgetBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tactics\OpleidingsbudgetBundle\Entity\ExpenseRequest;

class ExpenseRequestRepository extends EntityRepository implements ExpenseRequestRepositoryInterface
{
    public function save(ExpenseRequest $expenseRequest)
    {
        $this->getEntityManager()->persist($expenseRequest);
        $this->getEntityManager()->flush();
    }

    public function getPendingExpenseRequest()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT e
            FROM TacticsOpleidingsbudgetBundle:ExpenseRequest e
            WHERE e.status = 'pending'");


        return $query->getResult();
    }

    public function getApprovedExpenseRequest()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT e
            FROM TacticsOpleidingsbudgetBundle:ExpenseRequest e
            WHERE e.status = 'approved'");


        return $query->getResult();
    }
}