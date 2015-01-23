<?php

namespace Anuncios\AnuncioBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImportCampaignType extends AbstractType
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
        ->add('month', 'choice', array(
        		'empty_value' => 'Mes',
    			'empty_data'  => null,
        		'choices'     => array(
        				'1'  => 'Enero',
        				'2'  => 'Febrero',
        				'3'  => 'Marzo',
        				'4'  => 'Abril',
        				'5'  => 'Mayo',
        				'6'  => 'Junio',
        				'7'  => 'Julio',
        				'8'  => 'Agosto',
        				'9'  => 'Septiembre',
        				'10' => 'Octubre',
        				'11' => 'Noviembre',
        				'12' => 'Diciembre'
        		),
        		'label'       => false
        ))
        ->add('year', 'choice', array(
        		'empty_value' => 'Año',
        		'empty_data'  => null,
        		'choices'     => array(
        				'2014' => '2014',
        				'2015' => '2015',
        				'2016' => '2016',
        				'2017' => '2017',
        				'2018' => '2018',
        				'2019' => '2019',
        				'2020' => '2020',
        				'2021' => '2021',
        				'2022' => '2022',
        				'2023' => '2023',
        				'2024' => '2024'
        		),
        		'label'       => false
        ));
    }

    public function getName()
    {
        return 'anuncios_campaign_import';
    }
}
