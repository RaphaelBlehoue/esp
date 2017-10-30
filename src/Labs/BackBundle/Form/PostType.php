<?php

namespace Labs\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, array('label' => false, 'attr'  => array('class' => 'form-control')))
            ->add('videoLink',TextType::class, array('label' => false, 'required' => false, 'attr'  => array('class' => 'form-control')))
            ->add('docsName',TextType::class, array('label' => false, 'required' => false, 'attr'  => array('class' => 'form-control')))
            ->add('status',ChoiceType::class,[
                'label' => false,
                'choices' => array(
                    'Mettre en Ligne' => true,
                    'Garder Hors ligne' => false
                )
            ])
            ->add('content', CKEditorType::class, array(
                'label' => false,
                'required' => false
            ))            
            ->add('imageFile',VichImageType::class,array(
                'label' => false,
                'required' => false,
                'allow_delete' => true
            ))
            ->add('documentFile',VichImageType::class,array(
                'label' => false,
                'required' => false,
                'allow_delete' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\BackBundle\Entity\Post'
        ));
    }
}
