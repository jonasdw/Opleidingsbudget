<?php

namespace Tactics\OpleidingsbudgetBundle\Controller;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Tactics\OpleidingsbudgetBundle\Entity\Transaction;
use Tactics\OpleidingsbudgetBundle\Form\TransactionType;
use Tactics\OpleidingsbudgetBundle\Helper\Balans;

/**
 * Transaction controller.
 */
class TransactionController extends Controller
{
    /**
     * Lists all Transaction entities.
     */
    public function indexAction()
    {
        $transactions = $this->getTransactionsPerUser($this->getCurrentUser());
        $budget = new Balans($transactions);

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:index.html.twig', array(
            'transactions' => $transactions,
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

    /**
     * Lists all Transaction entities.
     */
    public function allAction()
    {
        $transactions = $this->getAllTransactions();

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:all.html.twig', array(
            'transactions' => $transactions
        ));
    }

    private function getAllTransactions()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('TacticsOpleidingsbudgetBundle:Transaction')->findAll(
            array('date' => 'ASC')
        );
    }

    /**
     * Displays a form to create a new Transaction entity.
     */
    public function newAction(Request $request, $userid, $type)
    {
        /*hoe EXPENSE actie opvangen? parameter die default 0 is?*/
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id' => $userid));

        $transaction = new Transaction($user, $type);

        $form = $this->createCreateForm($transaction, $this->generateUrl('transaction_new', array('userid' => $userid, 'type' => $type)));
        $form->handleRequest($request);

        if ($this->processTransactionForm($form, $transaction)){
            return $this->redirect($this->generateUrl('transaction_show', array(
                'id' => $transaction->getId()
            )));
        }

        return $this->render('TacticsOpleidingsbudgetBundle:Transaction:new.html.twig', array(
            'transaction' => $transaction,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Transaction entity.
     *
     * @param Transaction $entity The entity
     *
     * @param string $action
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Transaction $entity, $action)
    {
        $form = $this->createForm(new TransactionType(), $entity, array(
            'action' => $action,
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * @param FormInterface $form
     * @param \Tactics\OpleidingsbudgetBundle\Entity\Transaction $transaction
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function processTransactionForm(FormInterface $form, Transaction $transaction)
    {
        if ($this->get('request')->getMethod() === 'POST' && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($transaction);
            $em->flush();

            return true;
        }

        return false;
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
