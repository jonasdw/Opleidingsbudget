<?php
/**
 * Created by PhpStorm.
 * User: jonas_000
 * Date: 4/07/14
 * Time: 16:27
 */
namespace Tactics\OpleidingsbudgetBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TransactionRepository extends EntityRepository
{
    public function getUserBudget($usrid)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT t.amount
            FROM TacticsOpleidingsbudgetBundle:Transaction t
            WHERE t.user_id = :id');
        $query->setParameter('id', $usrid);

        $transactions = $query->getResult();
        $budget = 10;

        foreach ($transactions as $transaction){
            $budget = $budget+floatval($transaction["amount"]);
         }


        return $budget;
    }
}