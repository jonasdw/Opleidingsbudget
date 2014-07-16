<?php

namespace Tactics\OpleidingsbudgetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;


/**
 * ExpenseRequest
 */
class ExpenseRequest
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     *
     */
    private $amount;

    private $currency = 'EUR';

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $status = 'pending';

    /**
     * @var \DateTime
     */
    private $date_pending;

    /**
     * @var \DateTime
     */
    private $date_approved;

    /**
     * @var \DateTime
     */
    private $date_executed;

    /**
     * @var integer
     */
    private $user;

    public function __construct(User $user)
    {
        $this->date_pending = new \DateTime();
        $this->user = $user;
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
     * @param Money $amount
     * @return ExpenseRequest
     */
    public function setAmount(Money $amount)
    {
        $this->amount = $amount->getAmount();
        $this->currency = $amount->getCurrency();
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

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return ExpenseRequest
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return ExpenseRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date_pending
     *
     * @param \DateTime $datePending
     * @return ExpenseRequest
     */
    public function setDatePending($datePending)
    {
        $this->date_pending = $datePending;

        return $this;
    }

    /**
     * Get date_pending
     *
     * @return \DateTime
     */
    public function getDatePending()
    {
        return $this->date_pending;
    }

    /**
     * Set date_approved
     *
     * @param \DateTime $dateApproved
     * @return ExpenseRequest
     */
    public function setDateApproved($dateApproved)
    {
        $this->date_approved = $dateApproved;

        return $this;
    }

    /**
     * Get date_approved
     *
     * @return \DateTime
     */
    public function getDateApproved()
    {
        return $this->date_approved;
    }

    /**
     * Set date_executed
     *
     * @param \DateTime $dateExecuted
     * @return ExpenseRequest
     */
    public function setDateExecuted($dateExecuted)
    {
        $this->date_executed = $dateExecuted;

        return $this;
    }

    /**
     * Get date_executed
     *
     * @return \DateTime
     */
    public function getDateExecuted()
    {
        return $this->date_executed;
    }

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }
}
