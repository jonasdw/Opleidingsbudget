<?php

namespace Tactics\OpleidingsbudgetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        //return $this->render('TacticsOpleidingsbudgetBundle:Default:index.html.twig', array('name' => $name));
        return new RedirectResponse("login");
    }
}
