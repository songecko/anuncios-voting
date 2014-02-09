<?php

namespace Gecko\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend forms controller.
 */
class FormController extends Controller
{
    /**
     * Render form.
     *
     * @param Request $request
     */
    public function showAction($type, $template)
    {
        return $this->render($template, array(
            'form' => $this->createForm($type)->createView()
        ));
    }
    
    /**
     * Render filter form.
     *
     * @param string $type
     * @param string $template
     *
     * @return Response
     */
    public function filterAction($type, $template)
    {
        return $this->render($template, array(
            'form' => $this->get('form.factory')->createNamed('criteria', $type)->createView()
        ));
    }
}