<?php

namespace Tactics\OpleidingsbudgetBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;

class TransactionRepository extends EntityRepository implements TransactionRepositoryInterface
{
    public function save(Transaction $transaction)
    {
        $this->getEntityManager()->persist($transaction);
        $this->getEntityManager()->flush();
    }

    public function findAll()
    {
        return $this->findBy(array(), array('date' => 'DESC'));
    }
}