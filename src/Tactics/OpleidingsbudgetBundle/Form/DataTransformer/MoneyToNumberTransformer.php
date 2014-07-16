<?php

namespace Tactics\OpleidingsbudgetBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Money\Currency;
use Symfony\Component\Form\DataTransformerInterface;
use Money\Money;

class MoneyToNumberTransformer implements DataTransformerInterface
{
    /**
     * @param Money|null $money
     * @return int
     */
    public function transform(Money $money = null)
    {
        if (null === $money) {
            return 0;
        }

        return $money->getAmount();
    }


    public function reverseTransform($number)
    {
        if (!$number) {
            return 0;
        }

        return Money::EUR($number);
    }
}
