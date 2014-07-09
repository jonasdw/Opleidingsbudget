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

             $em = $this->getDoctrine()->getManager();

             $pending = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->getExpenseRequestPending();

             return $this->render('TacticsOpleidingsbudgetBundle::admin.html.twig', array(
                 'users' =>   $users,
                 'expenserequests' => $pending));
         }
         if ($this->get('security.context')->isGranted('ROLE_APPROVER') || $this->get('security.context')->isGranted('ROLE_EXECUTOR') ){
             $userManager = $this->get('fos_user.user_manager');
             $users = $userManager->findUsers();

             return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
         }

         return new RedirectResponse($this->generateUrl('transaction'));
     }

     public function usersAction() {
         //access user manager services

         $userManager = $this->get('fos_user.user_manager');
         $users = $userManager->findUsers();


         return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
     }
 }