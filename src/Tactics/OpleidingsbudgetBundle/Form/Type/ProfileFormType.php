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
use Symfony\Component\Security\Core\SecurityContextInterface;

class ProfileFormType extends BaseType
{
    private $security;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        //$builder
        $builder
            ->remove('username')
            ->add('email', 'email', array('label' => 'email', 'translation_domain' => 'FOSUserBundle'))
            ->add('first_name', 'text', array('label' => 'first name', 'translation_domain' => 'FOSUserBundle'))
            ->add('name', 'text', array('label' => 'last name', 'translation_domain' => 'FOSUserBundle'))
            ->remove('current_password', 'password');

        if ($this->security->isGranted('ROLE_APPROVER')){
            $builder
            ->add('roles', 'choice', array(
                'choices'   => array(
                    'ROLE_USER'   => 'user',
                    'ROLE_EXECUTOR' => 'executor',
                    'ROLE_APPROVER'   => 'approver',
                ),
                'multiple'  => true,
                'expanded' => true,
            ))
            ->add('enabled', 'checkbox', array('label' => 'enabled', 'required' => false));
        }

    }

    public function __construct($class, SecurityContextInterface $security)
    {
        parent::__construct($class);
        $this->security = $security;
    }

    public function getName()
    {
        return 'alter_users';
    }

}