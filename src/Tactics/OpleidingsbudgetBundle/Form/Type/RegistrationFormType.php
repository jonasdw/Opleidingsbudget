<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 20/06/14
 * Time: 16:38
 */

namespace Tactics\OpleidingsbudgetBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
                ->remove('username')
                ->add('email', 'email', array('label' => 'email', 'translation_domain' => 'FOSUserBundle'))
                ->remove('plainPassword')
                ->add('name', 'text', array('label' => 'last name', 'translation_domain' => 'FOSUserBundle'))
                ->add('firstname', 'text', array('label' => 'first name', 'translation_domain' => 'FOSUserBundle'))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'password'),
                    'second_options' => array('label' => 'confirm password'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ));


    }
    public function getName()
    {
        return 'registration_name';
    }
    public function getFirstName()
    {
        return 'registration_first_name';
    }
}