<?php

namespace Anuncios\AnuncioBundle\Form\Type\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', 'text', array(
        		'label'    => 'Nombre Usuario',
        		'required' => false,
        		'attr'  => array(
                    'placeholder' => 'Nombre de usuario'
                )
        ))
        ->add('isJurado', 'choice', array(
        		'label'    => 'Es Jurado?',
        		'required' => false,
        		'choices'   => array('' => 'Jurados / Populares', '1' => 'Solo Jurados', 'false' => 'Solo Populares')
        ));
    }

    public function getName()
    {
        return 'anuncios_user_filter';
    }
}
