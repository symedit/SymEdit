<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
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
        $entities = $this->getUserManager()->findAdmins();

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
        $entity = $this->getUserManager()->findAdminBy(array('id' => $id));

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
        $user = $this->getUserManager()->createUser(true);
        $form = $this->createForm('symedit_user', $user);

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Image entity.
     *
     * @Route("/create", name="admin_user_create")
     * @Method("POST")
     * @Template("@SymEdit/Admin/User/new.html.twig")
     */
    public function createAction(Request $request)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->createUser(true);
        $form = $this->createForm('symedit_user', $user);

        $form->handleRequest($request);

        if($form->isValid()){
            $user->setEnabled(true);
            $userManager->updateUser($user);

            $this->addFlash('notice', 'User Created');

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
        $entity = $this->getUserManager()->findAdminBy(array('id' => $id));

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
     * @Template("@SymEdit/Admin/User/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $userManager = $this->getUserManager();
        $user = $userManager->findAdminBy(array('id' => $id));

        if (!$user) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $form = $this->createForm('symedit_user', $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);
            $this->addFlash('notice', 'User Updated');

            return $this->redirect($this->generateUrl('admin_user_edit', array('id' => $id)));
        }

        return array(
            'entity' => $user,
            'form' => $form->createView(),
        );
    }
}