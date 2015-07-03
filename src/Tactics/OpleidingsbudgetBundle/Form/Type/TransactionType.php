<?php

namespace Tactics\OpleidingsbudgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;


class TransactionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount', 'value_money', array('currency' => false, 'attr' => array('placeholder' => '0.00')) )
            ->add('currency', 'choice', array(
                'choices'   => array('EUR' => 'EUR', 'USD' => 'USD', 'GBP' => 'GBP'),
                'required'  => true,
                'label'     => false,
            ))
            ->add('type', 'hidden')
            ->add('date')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tactics\OpleidingsbudgetBundle\Entity\Transaction'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tactics_opleidingsbudgetbundle_transaction';
    }
}
