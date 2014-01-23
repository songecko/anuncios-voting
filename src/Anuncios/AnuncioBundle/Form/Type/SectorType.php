<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text', array(
        		'required' => true,
        		'label'    => 'Nombre'
        ))
        ->add('sectorId', 'text', array(
        		'required' => true,
        		'label'    => 'Sector ID'
        ));
    }

    public function getName()
    {
        return 'anuncios_sector';
    }
}
