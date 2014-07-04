<?php

namespace Tactics\OpleidingsbudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 */
class Transaction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $expenserequest_id;

    /**
     * @var integer
     */
    private $user_id;

    public function __construct()
    {
        $this->date = new \DateTime();
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

    /**
     * Set amount
     *
     * @param string $amount
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Transaction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set expenserequest_id
     *
     * @param integer $expenserequestId
     * @return Transaction
     */
    public function setExpenserequestId($expenserequestId)
    {
        $this->expenserequest_id = $expenserequestId;

        return $this;
    }

    /**
     * Get expenserequest_id
     *
     * @return integer 
     */
    public function getExpenserequestId()
    {
        return $this->expenserequest_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Transaction
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
