<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Isometriks\Bundle\SymEditBundle\Event\Events;
use Isometriks\Bundle\SymEditBundle\Event\PostEvent;
use Isometriks\Bundle\SymEditBundle\Model\PostManagerInterface;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Model\PostInterface;


/**
 * Post controller.
 *
 * @Route("/blog")
 * @PreAuthorize("hasRole('ROLE_ADMIN_BLOG')")
 */
class PostController extends Controller
{

    /**
     * Lists all Post entities.
     *
     * @Route("/", name="admin_blog")
     * @Template()
     */
    public function indexAction()
    {
        $postManager = $this->getPostManager();
        $postManager->disableStatusFilter();

        return array(
            'entities' => $postManager->findAll(),
        );
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/new", name="admin_blog_new")
     * @Template()
     */
    public function newAction()
    {
        $post = $this->getPostManager()->createPost();
        $post->setAuthor($this->getUser());

        $form = $this->createCreateForm($post);

        return array(
            'entity' => $post,
            'form'   => $form->createView(),
        );
    }

    private function createCreateForm(PostInterface $post)
    {
        return $this->createForm('symedit_post', $post, array(
            'action' => $this->generateUrl('admin_blog_create'),
            'method' => 'POST',
        ));
    }
    
    /**
     * Creates a new Post entity.
     *
     * @Route("/create", name="admin_blog_create")
     * @Method("POST")
     * @Template("IsometriksSymEditBundle:Admin/Post:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $postManager = $this->getPostManager();
        $post = $postManager->createPost();

        $form = $this->createCreateForm($post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $postManager->updatePost($post);

            $event = new PostEvent($post, $request);
            $this->get('event_dispatcher')->dispatch(Events::POST_CREATED, $event);

            return $this->redirect($this->generateUrl('admin_blog_edit', array('id' => $post->getId())));
        }

        return array(
            'entity' => $post,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", name="admin_blog_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $postManager = $this->getPostManager();
        $postManager->disableStatusFilter();

        $post = $postManager->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createEditForm($post);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $post,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    private function createEditForm(PostInterface $post)
    {
        return $this->createForm('symedit_post', $post, array(
            'action' => $this->generateUrl('admin_blog_update', array('id' => $post->getId())),
            'method' => 'PUT',
        ));
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/{id}/update", name="admin_blog_update")
     * @Method("PUT")
     * @Template("IsometriksSymEditBundle:Admin/Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $postManager = $this->getPostManager();
        $postManager->disableStatusFilter();
        $post = $postManager->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($post);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $postManager->updatePost($post);
            $this->addFlash('notice', 'Post Updated');

            return $this->redirect($this->generateUrl('admin_blog_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $post,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}/delete", name="admin_blog_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $postManager = $this->getPostManager();
            $postManager->disableStatusFilter();
            $post = $postManager->find($id);

            if (!$post) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $postManager->deletePost($post);
            $this->addFlash('notice', 'Post deleted.');
        }

        return $this->redirect($this->generateUrl('admin_blog'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * @return PostManagerInterface
     */
    private function getPostManager()
    {
        return $this->get('isometriks_symedit.post_manager');
    }
}
