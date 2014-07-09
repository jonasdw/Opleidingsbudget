<?php
/**
 * Created by PhpStorm.
 * User: jonas_000
 * Date: 4/07/14
 * Time: 16:27
 */
namespace Tactics\OpleidingsbudgetBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ExpenseRequestRepository extends EntityRepository
{
    public function getExpenseRequestPending()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT e
            FROM TacticsOpleidingsbudgetBundle:ExpenseRequest e
            WHERE e.status = 'pending'");


        return $query->getResult();
    }

    public function getExpenseRequestApproved()
    {
        $query = $this->getEntityManager()->createQuery(
            "SELECT e
            FROM TacticsOpleidingsbudgetBundle:ExpenseRequest e
            WHERE e.status = 'approved'");


        return $query->getResult();
    }
}