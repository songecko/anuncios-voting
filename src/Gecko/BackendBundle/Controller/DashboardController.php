<?php

namespace Gecko\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Backend dashboard controller.
 *
 */
class DashboardController extends Controller
{
    /**
     * Backend dashboard display action.
     */
    public function mainAction()
    {
        return $this->render('GeckoBackendBundle:Dashboard:main.html.twig');
    }
}
