<?php

namespace Anuncios\AnuncioBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AnuncioFilterType extends AbstractType
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
        ->add('campaign', 'entity', array(
        		'class'    => 'AnunciosAnuncioBundle:Campaign',
        		'label'    => 'Campaña'
        ))
        ->add('category', 'entity', array(
        		'class'    => 'AnunciosAnuncioBundle:Category',
        		'label'    => 'Categoria'
        ));
    }

    public function getName()
    {
        return 'anuncios_anuncio_filter';
    }
}
