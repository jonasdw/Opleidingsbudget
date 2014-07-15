<?php

 namespace Tactics\OpleidingsbudgetBundle\Controller;

 use Symfony\Bundle\FrameworkBundle\Controller\Controller;
 use Symfony\Component\Security\Core\SecurityContext;
 use Symfony\Component\HttpFoundation\RedirectResponse;
 use Tactics\OpleidingsbudgetBundle\Helper\Summary;

 class UserController extends Controller
 {
     public function indexAction()
     {
         if ($this->isApprover())
         {
             $em = $this->getDoctrine()->getManager();

             $users = $em->getRepository('TacticsOpleidingsbudgetBundle:User')->findAll();
             $transactions = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findAll();
             $requests = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->findAll();

             $summary = new Summary($users, $transactions, $requests);



             $pending = $this->getPendingExpenseRequests();

             return $this->render('TacticsOpleidingsbudgetBundle::approver.html.twig', array(
                 'expenserequests' => $pending,
                 'usersdata' => $summary->getData()
             ));
         }

         if ($this->isExecutor() )
         {
             $users = $this->userManager()->findUsers();

             return $this->render('TacticsOpleidingsbudgetBundle::users.html.twig', array('users' =>   $users));
         }

         return new RedirectResponse($this->generateUrl('transaction'));
     }

     /**
      * @return object
      */
     private function userManager()
     {
         return $this->get('fos_user.user_manager');
     }

     /**
      * @return bool
      */
     private function isApprover()
     {
         if ($this->get('security.context')->isGranted('ROLE_APPROVER'))
         {
             return true;
         }

         return false;
     }

     /**
      * @return bool
      */
     private function isExecutor()
     {
         if ($this->get('security.context')->isGranted('ROLE_EXECUTOR'))
         {
             return true;
         }

         return false;
     }

     /**
      * @return array
      */
     private function getPendingExpenseRequests()
     {
         $em = $this->getDoctrine()->getManager();
         $pending = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->getPendingExpenseRequest();

         return $pending;
     }
 }