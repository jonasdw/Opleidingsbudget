<?php

namespace Tactics\OpleidingsbudgetBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Money\Money;

class MoneyToNumberTransformer implements DataTransformerInterface
{
    /**
     * @param Money|null $money
     * @return int
     */
    public function transform($money)
    {
        if (null === $money) {
            return 0;
        }

        $this->guardMoney($money);

        return $money->getAmount();
    }


    public function reverseTransform($number)
    {
        if (!$number) {
            return Money::EUR(0);
        }

        return Money::EUR((int)$number);
    }

    /**
     * @param $money
     * @throws \Exception
     */
    private function guardMoney($money)
    {
        if (!$money instanceof Money) {
            throw new \Exception('Expected money');
        }
    }
}
