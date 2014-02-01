<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', 'text', array(
        		'required' => true,
        		'label'    => 'Nombre Usuario'
        ))
        ->add('email', 'text', array(
        		'required' => true,
        		'label'    => 'Email'
        ))
        ->add('name', 'text', array(
        		'required' => true,
        		'label'    => 'Nombre'
        ))
        ->add('surname', 'text', array(
        		'required' => false,
        		'label'    => 'Apellido'
        ))
        ->add('isjurado', 'checkbox', array(
        		'required' => true,
        		'label'    => 'Es Jurado?'
        ));
    }

    public function getName()
    {
        return 'anuncios_user';
    }
}
