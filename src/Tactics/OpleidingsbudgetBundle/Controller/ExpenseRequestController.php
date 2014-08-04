<?php

namespace Tactics\OpleidingsbudgetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Tactics\OpleidingsbudgetBundle\Entity\ExpenseRequest;
use Tactics\OpleidingsbudgetBundle\Form\Type\ExpenseRequestType;
use Tactics\OpleidingsbudgetBundle\Helper\Balans;
use Tactics\OpleidingsbudgetBundle\Entity\Transaction;


/**
 * ExpenseRequest controller.
 *
 */
class ExpenseRequestController extends Controller
{

    /**
     * Lists current user ExpenseRequest entities.
     */
    public function indexAction()
    {
        $transactions = $this->getTransactionsPerUser($this->getCurrentUser());
        $budget = new Balans($transactions);

        $expenseRequests = $this->getExpenseRequestsPerUser($this->getCurrentUser());

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:index.html.twig', array(
            'expenseRequests' => $expenseRequests,
            'user' => $this->getCurrentUser(),
            'budget' => $budget->getUserBalans()
        ));
    }

    private function getCurrentUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

    private function getTransactionsPerUser($user)
    {
        $em = $this->getDoctrine()->getManager();

        return  $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findByUser($user);
    }

    private function getExpenseRequestsPerUser($user)
    {
        $em = $this->getDoctrine()->getManager();

        return  $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->findByUser($this->getCurrentUser());
    }

    /**
     * Lists all ExpenseRequest entities.
     */
    public function allAction()
    {
        $expenseRequests = $this->getAllExpenseRequests();

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:all.html.twig', array(
            'expenseRequests' => $expenseRequests
        ));
    }

    private function getAllExpenseRequests()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->findAll();
    }

    /**
     * Creates a new ExpenseRequest entity.
     *
     */
    public function createAction(Request $request)
    {
        $expenseRequest = new ExpenseRequest($this->getCurrentUser());
        $form = $this->createCreateForm($expenseRequest);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($expenseRequest);
            $em->flush();

            return $this->redirect($this->generateUrl('expenserequest_show', array('id' => $expenseRequest->getId())));
        }

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:new.html.twig', array(
            'expenseRequest' => $expenseRequest,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ExpenseRequest entity.
    *
    * @param ExpenseRequest $expenseRequest The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ExpenseRequest $expenseRequest)
    {
        $form = $this->createForm(new ExpenseRequestType(), $expenseRequest, array(
            'action' => $this->generateUrl('expenserequest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ExpenseRequest entity.
     *
     */
    public function newAction()
    {
        $expenseRequest = new ExpenseRequest($this->getCurrentUser());

        $form   = $this->createCreateForm($expenseRequest);

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:new.html.twig', array(
            'expenseRequest' => $expenseRequest,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ExpenseRequest entity.
     *
     */
    public function showAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpenseRequest entity.');
        }

        //EXTRA BUFFER CHECK CURRENT USER vs REQUESTED EXPENSE USER ID
        //WHAT ABOUT EXECUTOR AND APPROVER?!
        if (!$this->get('security.context')->isGranted('ROLE_APPROVER'))
        {
            if (!$this->get('security.context')->isGranted('ROLE_EXECUTOR'))
            {
                if ($entity->getUser()->getId() != $user->getId() )
                {
                    throw $this->createNotFoundException('This is not your expense!');
                }
            }
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ExpenseRequest entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpenseRequest entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ExpenseRequest entity.
    *
    * @param ExpenseRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExpenseRequest $entity)
    {
        $form = $this->createForm(new ExpenseRequestType(), $entity, array(
            'action' => $this->generateUrl('expenserequest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ExpenseRequest entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpenseRequest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('expenserequest_edit', array('id' => $id)));
        }

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updatePendingAction($id, $status, $userid)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExpenseRequest entity.');
        }
        if ($status == "pending")
        {
            $entity->setStatus('approved');
            $entity->setDateApproved(new \DateTime());
        }
        elseif ($status == "approved")
        {
            return $this->redirect($this->generateUrl('transaction_new', array('userid' => $userid, 'type' => 'expense', 'expenserequestid' => $id )));
        }
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * Deletes a ExpenseRequest entity.
     *
     */
    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExpenseRequest entity.');
            }

            $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('home'));
    }

    /**
     * Creates a form to delete a ExpenseRequest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('expenserequest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
