<?php

namespace Tactics\OpleidingsbudgetBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Tactics\OpleidingsbudgetBundle\Form\DataTransformer\MoneyToNumberTransformer;

class MoneyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new MoneyToNumberTransformer());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
          'currency' => 'EUR',
          'divisor' => 100,
        ));
    }

    public function getParent()
    {
        return 'money';
    }

    public function getName()
    {
        return 'value_money';
    }
}
