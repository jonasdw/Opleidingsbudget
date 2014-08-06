<?php
/**
 * Created by PhpStorm.
 * User: jonas_000
 * Date: 4/07/14
 * Time: 16:27
 */
namespace Tactics\OpleidingsbudgetBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;

class TransactionRepository extends EntityRepository implements TransactionRepositoryInterface
{
    public function save(Transaction $transaction)
    {
        var_dump("this is repository, saving");
    }

    public function findAll()
    {
        return $this->findBy(array(), array('date' => 'DESC'));
    }
}