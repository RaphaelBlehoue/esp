<?php

namespace Labs\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,array('label' => false, 'attr' => array('placeholder'=> 'Titre de L\'album', 'class' => 'form-control')))
            ->add('libelle', TextareaType::class,array('label' => false, 'attr' => array('placeholder'=> 'Resumé de l\'evenement', 'class' => 'form-control')))
            ->add('online',ChoiceType::class, array(
                'label' => false,
                'choices' => array(
                    'En Ligne' => true,
                    'Hors ligne' => false
                )
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\BackBundle\Entity\Gallery'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'labs_adminbundle_gallery';
    }


}
