<?php

namespace Tactics\OpledingsbudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TacticsOpledingsbudgetBundle:Default:index.html.twig', array('name' => $name));
    }
}
