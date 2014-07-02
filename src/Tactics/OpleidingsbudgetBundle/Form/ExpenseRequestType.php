<?php

namespace Tactics\OpleidingsbudgetBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpenseRequestType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amount')
            ->add('description')
//            ->add('status')
//            ->add('date_pending')
//            ->add('date_approved')
//            ->add('date_executed')
//            ->add('user_id')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tactics\OpleidingsbudgetBundle\Entity\ExpenseRequest'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tactics_opleidingsbudgetbundle_expenserequest';
    }
}
