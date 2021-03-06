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
        ->add('showFinalist', 'checkbox', array(
        		'label'    => 'Mostrar finalistas?'
        ))
        ->add('dateBegin', 'date', array(
        		'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Dia'),
        		'format' => 'dd-MMMM-yyyy',
        		'years' => range(date('Y')-1, date('Y')+10),
        		'label'    => 'Inicio',
        ))
        ->add('dateEnd', 'date', array(
        		'empty_value' => array('year' => 'Año', 'month' => 'Mes', 'day' => 'Dia'),
        		'format' => 'dd-MMMM-yyyy',
        		'years' => range(date('Y')-1, date('Y')+10),
        		'label'    => 'Fin'
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
        return 'anuncios_campaign';
    }
}
