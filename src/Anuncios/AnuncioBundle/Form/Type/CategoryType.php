<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
        		'required' => true,
        		'label'    => 'Nombre'
        ))
        ->add('isAnual', 'checkbox', array(
        		'label'    => 'Anual?'
        ))
        ->add('isActive', 'checkbox', array(
        		'label'    => 'Visible?'
        ))
        ->add('deleteFile', 'checkbox', array(
        		'label'    => 'Eliminar Imagen'
        ))
        ->add('file', 'file', array(
        		'label' => 'Imagen Titular'
        ));
    }

    public function getName()
    {
        return 'anuncios_category';
    }
}
