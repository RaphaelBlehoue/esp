<?php

namespace Labs\BackBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartsEditType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Labs\BackBundle\Entity\Parts'
        ));
    }

    public function getParent()
    {
        return PartsType::class;
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'labs_backbundle_parts_edit';
    }


}
