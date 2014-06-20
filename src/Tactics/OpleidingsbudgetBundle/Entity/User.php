<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 20/06/14
 * Time: 09:53
 */

namespace Tactics\OpleidingsbudgetBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


class User extends BaseUser
{

    protected $id;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


}
