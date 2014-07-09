<?php

namespace Tactics\OpleidingsbudgetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Tactics\OpleidingsbudgetBundle\Entity\Transaction;
use Tactics\OpleidingsbudgetBundle\Form\TransactionType;

/**
 * Transaction controller.
 *
 */
class TransactionController extends Controller
{

    /**
     * Lists all Transaction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //GET CURRENT USER
        $user = $this->get('security.context')->getToken()->getUser();

        //GET ALL TRANSACTIONS
        //$entities = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findAll();

        $budget = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->getUserBudget($user->getId());


        //GET TRANSACTIONS PER current USER | sort by date
        $entities = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findBy(
            array('user_id' => $user->getId()),
            array('date' => 'ASC')
        );

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:index.html.twig', array(
            'entities' => $entities,
            'user' => $user,
            'budget' => $budget
        ));
    }
    public function allAction()
    {
        $em = $this->getDoctrine()->getManager();

        //GET ALL TRANSACTIONS
        $entities = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findAll(
            array('date' => 'ASC')
        );

        //GET TRANSACTIONS PER current USER | sort by date
       // $entities = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findBy(
         //   array('date' => 'ASC')
        //);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:all.html.twig', array(
            'entities' => $entities
        ));
    }
    /**
     * Creates a new Transaction entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Transaction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transaction_show', array('id' => $entity->getId())));
        }

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Transaction entity.
    *
    * @param Transaction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Transaction $entity)
    {
        $form = $this->createForm(new TransactionType(), $entity, array(
            'action' => $this->generateUrl('transaction_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Transaction entity.
     *
     */
    public function newBudgetAction($usrid)
    {
        $entity = new Transaction();
        $entity->setType('budget');
        $entity->setUserId($usrid);
        $form   = $this->createCreateForm($entity);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function newEndofYearAction($usrid)
    {
        $entity = new Transaction();
        $entity->setType('endofyear');
        $entity->setUserId($usrid);
        $form   = $this->createCreateForm($entity);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    public function newExpenseAction($usrid, $expreid)
    {
        $entity = new Transaction();
        $entity->setType('expense');
        $entity->setUserId($usrid);
        $entity->setExpenserequestId($expreid);
        $form   = $this->createCreateForm($entity);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Transaction entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transaction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Transaction entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transaction entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Transaction entity.
    *
    * @param Transaction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Transaction $entity)
    {
        $form = $this->createForm(new TransactionType(), $entity, array(
            'action' => $this->generateUrl('transaction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Transaction entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transaction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('transaction_edit', array('id' => $id)));
        }

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Transaction entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Transaction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('transaction'));
    }

    /**
     * Creates a form to delete a Transaction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transaction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
