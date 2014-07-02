<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 20/06/14
 * Time: 15:55
 */

 namespace Tactics\OpleidingsbudgetBundle\Controller;


 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\Security\Core\SecurityContext;
 use Symfony\Component\HttpFoundation\RedirectResponse;


 class UserController extends Controller
 {

     public function indexAction()
     {
         $userManager = $this->get('fos_user.user_manager');

         if ($this->get('security.context')->isGranted('ROLE_APPROVER')) {
             //return new RedirectResponse("user/list");
             $users = $userManager->findUsers();

             return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
         }
         if ($this->get('security.context')->isGranted('ROLE_APPROVER') || $this->get('security.context')->isGranted('ROLE_EXECUTOR') ){
             $userManager = $this->get('fos_user.user_manager');
             $users = $userManager->findUsers();

             return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
         }
         if ($this->get('security.context')->isGranted('ROLE_APPROVER') || $this->get('security.context')->isGranted('ROLE_EXECUTOR') || $this->get('security.context')->isGranted('ROLE_USER'))
         {
             /*$user = $this->container->get('security.context')->getToken()->getUser();
             return $this->render('TacticsOpleidingsbudgetBundle::profile.html.twig', array('user' => $user));*/
             return new RedirectResponse("transaction");
         }

         return new Response('Gelieve in te loggen!');
     }

     public function usersAction() {
         //access user manager services

         $userManager = $this->get('fos_user.user_manager');
         $users = $userManager->findUsers();


         return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
     }
 }