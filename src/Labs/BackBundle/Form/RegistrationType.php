<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 20/03/2017
 * Time: 12:01
 */

namespace Labs\BackBundle\Form;


use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->remove('username')
            ->add('firstname',TextType::class,[
                'label' => false
            ])
            ->add('compagny',TextType::class,[
                'label' => false
            ])
            ->add('lastname',TextType::class,[
                'label' => false
            ])
            ->add('number_phone',PhoneNumberType::class,[
                'label' => false,
                'default_region' => 'CI',
                'format' => PhoneNumberFormat::NATIONAL,
                'widget' => PhoneNumberType::WIDGET_COUNTRY_CHOICE,
                'preferred_country_choices' => ['CI', 'GN', 'Bj', 'NG', 'TG', 'FR']
            ])
        ;
    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}