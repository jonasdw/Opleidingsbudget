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
} 