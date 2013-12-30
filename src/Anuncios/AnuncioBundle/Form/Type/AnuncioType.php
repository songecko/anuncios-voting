<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnuncioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
        		'required' => true,
        		'label'    => 'Nombre'
        ))
        ->add('agency', 'text', array(
        		'required' => true,
        		'label'    => 'Agencia'
        ))
        ->add('advertiser', 'text', array(
        		'required' => true,
        		'label'    => 'Anunciante'
        ))
        ->add('product', 'text', array(
        		'required' => true,
        		'label'    => 'Producto'
        ))
        ->add('brand', 'text', array(
        		'required' => true,
        		'label'    => 'Marca'
        ))
        ->add('otherFields', 'textarea', array(
        		'required' => true,
        		'label'    => 'Otros Campos'
        ))
        ->add('image', 'file', array(
        		'required' => true,
        		'label' => 'Imagen'
        ));
    }

    public function getName()
    {
        return 'anuncios_anuncio';
    }
}
