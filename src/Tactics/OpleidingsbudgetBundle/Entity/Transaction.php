<?php

namespace Tactics\OpleidingsbudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;
use Money\Currency;
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
     * @var integer
     */
    private $amount = 0;

    private $currency = 'EUR';

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

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param Money $amount
     * @return ExpenseRequest
     */
    public function setAmount(Money $amount)
    {
        $this->amount = $amount->getAmount();
        $this->currency = $amount->getCurrency()->getName();
        $this->handleAmount();
    }

    /**
     * Get amount
     *
     * @return Money
     */
    public function getAmount()
    {
        return new Money($this->amount, new Currency($this->currency));
    }

    private function handleAmount()
    {
        if ($this->type == 'expense' || $this->type == 'endofyear')
        {
            $this->amount = (-1 * $this->amount);
        }
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency()
    {
        return $this->currency;
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

    public function setExpenserequest(ExpenseRequest $expenserequest)
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
