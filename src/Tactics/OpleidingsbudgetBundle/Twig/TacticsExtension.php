<?php

namespace Tactics\OpleidingsbudgetBundle\Twig;

class TacticsExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('money', array($this, 'moneyFilter')),
        );
    }

    public function moneyFilter($number)
    {
        $money = $number->getAmount()/100;
        $money = '€'.$money;

        return $money;
    }

    public function getName()
    {
        return 'tactics_extension';
    }
}