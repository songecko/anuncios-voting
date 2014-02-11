<?php

namespace Anuncios\AnuncioBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
        		'label'    => 'Nombre',
        		'required' => false,
        		'attr'  => array(
                    'placeholder' => 'Nombre'
                )
        ))
        ->add('isAnual', 'choice', array(
        		'label'    => 'Es Anual?',
        		'required' => false,
        		'choices'   => array('' => 'Anual / No Anual', '1' => 'Es Anual', 'false' => 'No es Anual')
        ));
    }

    public function getName()
    {
        return 'anuncios_category_filter';
    }
}
