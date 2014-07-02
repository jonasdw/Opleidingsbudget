<?php

namespace Tactics\OpleidingsbudgetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Tactics\OpleidingsbudgetBundle\Entity\ExpenseRequest;
use Tactics\OpleidingsbudgetBundle\Form\ExpenseRequestType;

/**
 * ExpenseRequest controller.
 *
 */
class ExpenseRequestController extends Controller
{

    /**
     * Lists all ExpenseRequest entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //GET CURRENT USER
        $user = $this->get('security.context')->getToken()->getUser();

        //GET ALL TRANSACTIONS
        //$entities = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->findAll();

        //GET TRANSACTIONS PER current USER | sort by date
        $entities = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->findBy(
            array('user_id' => $user->getId()),
            array('date_pending' => 'ASC')
        );

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:index.html.twig', array(
            'entities' => $entities,
            'user' => $user
        ));
    }
    /**
     * Creates a new ExpenseRequest entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ExpenseRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('expenserequest_show', array('id' => $entity->getId())));
        }

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ExpenseRequest entity.
    *
    * @param ExpenseRequest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ExpenseRequest $entity)
    {
        $form = $this->createForm(new ExpenseRequestType(), $entity, array(
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
        $entity = new ExpenseRequest();
        $form   = $this->createCreateForm($entity);

        return $this->render('TacticsOpleidingsbudgetBundle:ExpenseRequest:new.html.twig', array(
            'entity' => $entity,
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
        if (!$this->get('security.context')->isGranted('ROLE_APPROVER') || !$this->get('security.context')->isGranted('ROLE_APPROVER')) {
        if ($entity->getUserId() != $user->getId() ){
            throw $this->createNotFoundException('This is not your expense!');
        }}

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
    /**
     * Deletes a ExpenseRequest entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:ExpenseRequest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExpenseRequest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('expenserequest'));
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
