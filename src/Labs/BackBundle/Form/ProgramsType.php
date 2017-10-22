<?php

namespace Labs\BackBundle\Form;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgramsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('times',TextType::class, array('label' => false, 'attr'  => array('class' => 'form-control')))
            ->add('type',ChoiceType::class, array(
                'choices' => array('Matinée' => 1, 'Soirée' => 0),
            ))
            ->add('title',TextType::class, array('label' => false, 'attr'  => array('class' => 'form-control')))
            ->add('content', CKEditorType::class, array(
                'label' => false
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\BackBundle\Entity\Programs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'labs_backbundle_programs';
    }

}
