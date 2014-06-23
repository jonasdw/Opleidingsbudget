<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 20/06/14
 * Time: 15:55
 */

 namespace Tactics\OpleidingsbudgetBundle\Controller;


 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\Security\Core\SecurityContext;;


 class UserController extends Controller
 {

     public function indexAction()
     {


         //$user = $this->getUser();
         //$securityContext = $this->securityContext;
         var_dump($this->getUser());

         if ($this->get('security.context')->isGranted('ROLE_APPROVER')) {
             echo("hier mag gert binnen");
         }
         if ($this->get('security.context')->isGranted('ROLE_APPROVER') || $this->get('security.context')->isGranted('ROLE_EXECUTOR') ){
             echo("      hier kathleen");
         }
         if ($this->get('security.context')->isGranted('ROLE_APPROVER') || $this->get('security.context')->isGranted('ROLE_EXECUTOR') || $this->get('security.context')->isGranted('ROLE_USER'))
         {
             echo('       test');
         }
         die();
         return null;
     }

     public function usersAction() {
         //access user manager services

         $userManager = $this->get('fos_user.user_manager');
         $users = $userManager->findUsers();


         return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
     }
 }