<?php
/**
 * Created by PhpStorm.
 * User: jonas
 * Date: 23/06/14
 * Time: 13:31
 */

namespace Tactics\OpleidingsbudgetBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;



class ProfileController extends Controller
{

    public function editAction($username)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if ($this->get('security.context')->isGranted('ROLE_APPROVER')) {
            $form = $this->container->get('fos_user.profile.form');

            $formHandler = $this->container->get('fos_user.profile.form.handler');
            $process = $formHandler->process($user);

            if ($process) {
                $this->setFlash('fos_user_success', 'profile.flash.updated');

                //return new RedirectResponse($this->getRedirectionUrl($user));
                //return $this->redirect($this->generateUrl('/user/list'));
                return new Response("Updated!");
            }

            return $this->container->get('templating')->renderResponse(
                'FOSUserBundle:Profile:edit.html.'.$this->container->getParameter('fos_user.template.engine'),
                array('form' => $form->createView(), 'username' => $username)
            );

        }else{
            echo("no acces for this user!");
            die();
        }


    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}