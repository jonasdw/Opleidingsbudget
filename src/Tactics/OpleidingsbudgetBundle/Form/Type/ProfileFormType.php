<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 20/06/14
 * Time: 16:38
 */

namespace Tactics\OpleidingsbudgetBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\FormEvents;
use Symfony\component\Form\FormEvent;

class ProfileFormType extends BaseType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        //$builder
        $builder
            ->remove('username')
            ->add('email', 'email', array('label' => 'email', 'translation_domain' => 'FOSUserBundle'))
            ->add('first_name', 'text', array('label' => 'first name', 'translation_domain' => 'FOSUserBundle'))
            ->add('name', 'text', array('label' => 'last name', 'translation_domain' => 'FOSUserBundle'))
            ->add('roles', 'choice', array(
                'choices'   => array(
                    'ROLE_USER'   => 'user',
                    'ROLE_EXECUTOR' => 'executor',
                    'ROLE_APPROVER'   => 'approver',
                ),
                'multiple'  => true,
                'expanded' => true,
            ))
            ->add('enabled', 'checkbox', array('label' => 'enabled', 'required' => false))
            ->remove('current_password', 'password');
    }




    public function getName()
    {
        return 'alter_users';
    }

}