<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Isometriks\Bundle\SymEditBundle\Form\WidgetReorderType;
use Isometriks\Bundle\SymEditBundle\Model\WidgetInterface;
use Isometriks\Bundle\SymEditBundle\Widget\WidgetManager;
use Isometriks\Bundle\SymEditBundle\Widget\WidgetRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/widget")
 */
class WidgetController extends Controller
{
    private $manager;

    /**
     * @Route("/", name="admin_widget")
     * @Template()
     */
    public function indexAction()
    {
        $manager = $this->getManager();
        $areas = $manager->getWidgetAreas();

        $reorderForm = $this->createForm(new WidgetReorderType(), null, array(
            'render' => true,
        ));
        
        return array(
            'reorder_form' => $reorderForm->createView(),
            'areas' => $areas,
        );
    }
    
    /**
     * @Route("/reorder", name="admin_widget_reorder")
     */
    public function reorderAction(Request $request)
    {

        $reorder_form = $this->createForm(new WidgetReorderType());
        $reorder_form->handleRequest($request);
        $status = false;

        if($reorder_form->isValid()){
            $status = true;
            $data = $reorder_form->getData();
            $widgetManager = $this->getManager();

            foreach($data['pair'] as $id=>$order){
                if(!$widget = $widgetManager->findWidget($id)){
                    throw $this->createNotFoundException(sprintf('Sorting entity not found (%d)', $id));
                }

                $widget->setWidgetOrder($order);
                $widgetManager->saveWidget($widget);
            }
        }

        return new JsonResponse(array(
            'status' => $status,
        ));
    }

    /**
     * @Route("/new/{strategyName}", name="admin_widget_new")
     * @Template()
     */
    public function newAction($strategyName = null)
    {
        if($strategyName === null){

            /* @var $registry WidgetRegistry */
            $registry = $this->get('isometriks_symedit.widget.registry');
            $strategies = $registry->getStrategies();

            return $this->render('@IsometriksSymEdit/Admin/Widget/choose.html.twig', array(
                'strategies' => $strategies,
            ));

        } else {

            $widget = $this->createWidget($strategyName);
            $form = $this->createCreateForm($widget);

            return array(
                'entity' => $widget,
                'form' => $form->createView(),
            );
        }
    }
    
    private function createCreateForm(WidgetInterface $widget)
    {
        return $this->createForm('symedit_widget', $widget, array(
            'strategy' => $widget->getStrategy(),
            'action' => $this->generateUrl('admin_widget_create', array('strategyName' => $widget->getStrategyName())),
            'method' => 'POST',
        ));
    }

    /**
     * @Route("/create/{strategyName}", name="admin_widget_create")
     * @Template("@IsometriksSymEdit/Admin/Widget/new.html.twig")
     */
    public function createAction(Request $request, $strategyName)
    {
        $widget = $this->createWidget($strategyName);
        $form = $this->createCreateForm($widget);

        $form->handleRequest($request);

        if($form->isValid()){
            $this->getManager()->saveWidget($widget);
            $this->addFlash('notice', 'Widget created successfully.');

            return $this->redirect($this->generateUrl('admin_widget_edit', array('id' => $widget->getId())));
        }

        $this->addFlash('error', 'Error Creating Widget.');

        return array(
            'entity' => $widget,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/edit", name="admin_widget_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $manager = $this->getManager();
        $widget = $manager->getWidgetBy(array('id' => $id));

        if($widget === null){
            throw new \Exception(sprintf('Could not find widget with name "%s".', $name));
        }

        $form = $this->createEditForm($widget);

        return array(
            'entity' => $widget,
            'form' => $form->createView(),
            'delete_form' => $this->createDeleteForm($id)->createView(),
        );
    }
    
    private function createEditForm(WidgetInterface $widget)
    {
        return $this->createForm('symedit_widget', $widget, array(
            'strategy' => $widget->getStrategy(),
            'action' => $this->generateUrl('admin_widget_update', array('id' => $widget->getId())),
            'method' => 'PUT',
        ));
    }

    /**
     * @Route("/{id}/update", name="admin_widget_update")
     * @Method("PUT")
     * @Template("@IsometriksSymEdit/Admin/Widget/edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $manager = $this->getManager();
        $widget = $manager->getWidgetBy(array('id' => $id));

        if($widget === null){
            throw new \Exception(sprintf('Could not find widget with name "%s".', $name));
        }

        $form = $this->createEditForm($widget);
        $form->handleRequest($request);

        if($form->isValid()){
            $manager->saveWidget($widget);

            $this->addFlash('notice', 'Widget Updated.');

            return $this->redirect($this->generateUrl('admin_widget_edit', array('id' => $id)));
        }

        $this->addFlash('error', 'Error Updating Widget');

        return array(
            'entity' => $widget,
            'form' => $form->createView(),
        );
    }


    /**
     * Deletes a Widget entity.
     *
     * @Route("/{id}/delete", name="admin_widget_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $widgetManager = $this->getManager();
            $widget = $widgetManager->findWidget($id);

            if (!$widget) {
                throw $this->createNotFoundException('Unable to find Widget entity.');
            }

            $widgetManager->deleteWidget($widget);
            $this->addFlash('notice', 'Widget Deleted');
        }

        return $this->redirect($this->generateUrl('admin_widget'));
    }

    /**
     * @return WidgetManager $manager
     */
    private function getManager()
    {
        if($this->manager === null){
            $this->manager = $this->get('isometriks_symedit.widget.manager');
        }

        return $this->manager;
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * @param string $strategyName
     * @return WidgetInterface
     */
    private function createWidget($strategyName)
    {
        /**
         * Try to create a new widget, you can type these in the address
         * bar so don't let Symfony crash, just throw a 404.
         */
        try {
            $widget = $this->getManager()->createWidget($strategyName);
        } catch(\Exception $e) {
            throw $this->createNotFoundException(sprintf('Widget with strategy name "%s" does not exist', $strategyName));
        }

        return $widget;
    }
}