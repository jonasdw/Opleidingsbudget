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

    //protected $roles;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        //$this->$roles = array("ROLE_USER", "ROLE_EXECUTOR", "ROLE_APPROVER");

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


    //Username is required, override function --> username == email | keep FOS happy
    public function setEmail($email){
        parent::setUsername($email);
        parent::setEmail($email);
    }
    public function setEmailCanonical($emailCanonical){
        parent::setUsername($emailCanonical);
        parent::setEmailCanonical($emailCanonical);
    }



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
