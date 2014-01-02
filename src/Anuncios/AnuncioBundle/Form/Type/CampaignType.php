<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
        		'required' => true,
        		'label'    => 'Nombre'
        ))
        ->add('isActive', 'checkbox', array(
        		'label'    => 'Activo?'
        ))
        ->add('file', 'file', array(
        		'mapped'   => false,
        		'required' => true,
        		'label'    => 'Anuncios'
        ));
    }

    public function getName()
    {
        return 'anuncios_campaign';
    }
}
