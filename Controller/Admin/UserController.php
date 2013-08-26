<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * User controller.
 *
 * @Route("/user")
 * @PreAuthorize("hasRole('ROLE_ADMIN_USER')")
 */
class UserController extends Controller
{
    /**
     * Lists all Image entities.
     *
     * @Route("/", name="admin_user")
     * @Template()
     */
    public function indexAction()
    {
        $user_manager = $this->get('fos_user.user_manager');
        $entities = $user_manager->findUsers();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="admin_user_show")
     * @Template()
     */
    public function showAction($id)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $entity = $user_manager->findUserBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to create a new Image entity.
     *
     * @Route("/new", name="admin_user_new")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createForm('symedit_user');

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/create", name="admin_user_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $user         = $user_manager->createUser(true);
        $form         = $this->createForm('symedit_user', $user);

        $form->bind($request);

        if($form->isValid()){
            $user->setEnabled(true);
            $user_manager->updateUser($user);

            $this->get('session')->getFlashBag()->add('notice', 'User Created');

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $user->getId())));
        }

        return array(
            'form' => $form->createView(),
        );
    }


    /**
     * Edit User
     * @Route("/{id}/edit", name="admin_user_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $entity = $user_manager->findUserBy(array('id' => $id));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createForm('symedit_user', $entity);

        return array(
            'form'   => $form->createView(),
            'entity' => $entity,
        );
    }


    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}/update", name="admin_user_update")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserBy(array('id' => $id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $form = $this->createForm('symedit_user', $user);
        $form->bind($request);

        if ($form->isValid()) {

            $user_manager->updateUser($user);

            $this->get('session')->getFlashBag()->add('notice', 'User Updated');

            return $this->redirect($this->generateUrl('admin_user_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $user,
            'form'        => $form->createView(),
        );
    }
}