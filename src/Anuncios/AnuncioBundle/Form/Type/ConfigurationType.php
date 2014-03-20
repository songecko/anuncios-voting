<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titleHomeImageFile', 'file', array(
        		'label' => 'Imagen titular del Home'
        ))
        ->add('logoHomeFile', 'file', array(
        		'label' => 'Logo del home'
        ))
        ->add('faviconFile', 'file', array(
        		'label' => 'Favicon'
        ))
        ->add('newPassword', 'password', array(
        		"mapped" => false,
        		'label' => 'Modificar password'
        ));
    }

    public function getName()
    {
        return 'anuncios_configuration';
    }
}
