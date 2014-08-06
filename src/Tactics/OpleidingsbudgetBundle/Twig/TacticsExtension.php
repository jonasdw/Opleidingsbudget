<?php

namespace Tactics\OpleidingsbudgetBundle\Twig;

class TacticsExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('money', array($this, 'moneyFilter')),
            new \Twig_SimpleFilter('moneynocurrency', array($this, 'moneyFilterNoCurrency')),
        );
    }

    public function moneyFilter($number)
    {
        $money = $number->getAmount()/100;
        $money = $number->getCurrency(). ' ' . $money;

        return $money;
    }

    public function moneyFilterNoCurrency($number)
    {
        $money = $number->getAmount()/100;

        return $money;
    }

    public function getName()
    {
        return 'tactics_extension';
    }
}