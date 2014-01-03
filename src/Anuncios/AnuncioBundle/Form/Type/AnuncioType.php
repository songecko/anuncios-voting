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
        ->add('campaign', 'entity', array(
        		'class'    => 'AnunciosAnuncioBundle:Campaign',
        		'label'    => 'Campaña'
        ))
        ->add('category', 'entity', array(
        		'class'    => 'AnunciosAnuncioBundle:Category',
        		'label'    => 'Categoria'
        ))
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
        ->add('file', 'file', array(
        		'label' => 'Imagen'
        ));
    }

    public function getName()
    {
        return 'anuncios_anuncio';
    }
}
