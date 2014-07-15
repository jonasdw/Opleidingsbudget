<?php
/**
 * Created by PhpStorm.
 * User: jonas_000
 * Date: 3/07/14
 * Time: 13:46
 */

namespace Tactics\OpleidingsbudgetBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getApprovers()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT u
            FROM TacticsOpleidingsbudgetBundle:User u
            WHERE u.roles LIKE :role'
        )->setParameter('role', '%ROLE_APPROVER%');

        return $query->getResult();
    }
/*
    public function getUsersWithData()
    {
        $q = $this->getEntityManager()->createQuery("SELECT u FROM TacticsOpleidingsbudgetBundle:User u");
        $users = $q->getResult();

        $usersWithData = array();

        foreach ($users as $user)
        {
            $qtrans = $this->getEntityManager()->createQuery(
                "SELECT t
                FROM TacticsOpleidingsbudgetBundle:Transaction t
                WHERE t.user = :user"
            );
            $qtrans->setParameter('user', $user);
            $transactions = $qtrans->getResult();

            $budget = 0;
            $countTrans = 0;

            foreach ($transactions as $transaction){
                $budget = $budget+floatval($transaction->getAmount());
                $countTrans ++;
            }

            $qexpense = $this->getEntityManager()->createQuery(
                "SELECT COUNT(e)
                FROM TacticsOpleidingsbudgetBundle:ExpenseRequest e
                WHERE e.user = :user"
            );
            $qexpense->setParameter('user', $user);

            $cexpense = $qexpense->getSingleScalarResult();

            $userWithData = array(['id' => $user->getId(), 'name' => $user->getFirstName(),'budget' => $budget, 'trans' => $countTrans, 'expense' => $cexpense]);
            array_push($usersWithData, $userWithData);


        }

        return $usersWithData;
    }
*/
} 