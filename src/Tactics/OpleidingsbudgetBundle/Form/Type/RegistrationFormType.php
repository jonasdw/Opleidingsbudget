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
                ->add('email', 'email', array(
                    'label' => 'email',
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array('class' => 'form-control'),
                ))
                ->remove('plainPassword')
                ->add('first_name', 'text', array(
                    'label' => 'first name',
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('name', 'text', array(
                    'label' => 'last name',
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'password', 'attr' => array('class' => 'form-control')),
                    'second_options' => array('label' => 'confirm password', 'attr' => array('class' => 'form-control')),
                    'invalid_message' => 'fos_user.password.mismatch',
                ));
    }

    public function getName()
    {
        return 'registration';
    }
}