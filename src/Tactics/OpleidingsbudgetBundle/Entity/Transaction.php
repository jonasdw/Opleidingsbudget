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
    private $expenserequest;

    /**
     * @var integer
     */
    private $user;

    public function __construct(User $user, $type)
    {
        $this->date = new \DateTime();
        $this->user = $user;
        $this->type = $type;
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
        $this->handleAmount();
        return $this;
    }

    private function handleAmount()
    {
        if ($this->type == 'expense' || $this->type == 'endofyear')
        {
            $this->amount = -1 * abs($this->amount);
        }
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
     * Get expenserequest
     *
     * @return integer
     */
    public function getExpenserequest()
    {
        return $this->expenserequest;
    }

    public function setExpenserequest($expenserequest)
    {
        $this->expenserequest = $expenserequest;
    }
    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }
}
