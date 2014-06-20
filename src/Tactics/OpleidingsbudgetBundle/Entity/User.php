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

    private $first_name;

    private $name;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getFirstName(){
        return $this->first_name;
    }
    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }


}
