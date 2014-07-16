<?php

namespace Tactics\OpleidingsbudgetBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Money\Currency;
use Symfony\Component\Form\DataTransformerInterface;
use Money\Money;

class MoneyToNumberTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * @param Money|null $money
     * @return int
     */
    public function transform($money)
    {
        if (null === $money)
        {
            return 0;
        }

        return $money->getAmount();
    }


    public function reverseTransform($number)
    {
        if (!$number)
        {
            return 0;
        }

        //currency?

        $money = new Money($number, new Currency($currency));

        return $money;
    }

}