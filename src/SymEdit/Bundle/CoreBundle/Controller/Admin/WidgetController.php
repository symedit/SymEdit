<?php

namespace SymEdit\Bundle\CoreBundle\Controller\Admin;

use SymEdit\Bundle\CoreBundle\Controller\ResourceController;
use SymEdit\Bundle\CoreBundle\Form\WidgetReorderType;
use SymEdit\Bundle\CoreBundle\Widget\WidgetRegistry;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Request;

/**
 * @PreAuthorize("hasRole('ROLE_ADMIN_WIDGET')")
 */
class WidgetController extends ResourceController
{
    public function indexAction(Request $request)
    {
        $areas = $this->get('symedit.repository.widget_area')->findAll();

        $reorderForm = $this->createForm(new WidgetReorderType(), null, array(
            'method' => 'POST',
            'action' => $this->generateUrl('admin_widget_reorder'),
            'render' => true,
            'attr' => array(
                'id' => 'reorder-form',
            )
        ));

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Widget/index.html.twig')
            ->setData(array(
                'form' => $reorderForm->createView(),
                'areas' => $areas,
            ));

        return $this->handleView($view);
    }

    public function getForm($resource = null)
    {
        return $this->createForm($this->getConfiguration()->getFormType(), $resource, array(
            'strategy' => $resource->getStrategy(),
        ));
    }

    /**
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws type
     */
    public function reorderAction(Request $request)
    {
        $reorderForm = $this->createForm(new WidgetReorderType());
        $reorderForm->handleRequest($request);
        $status = false;

        if($reorderForm->isValid()){
            $status = true;
            $data = $reorderForm->getData();
            $manager = $this->getManager();
            $repository = $this->getRepository();

            foreach($data['pair'] as $id=>$order){
                if(!$widget = $repository->find($id)){
                    throw $this->createNotFoundException(sprintf('Sorting entity not found (%d)', $id));
                }

                $widget->setWidgetOrder($order);
                $manager->persist($widget);
            }

            $manager->flush();
        }

        $view = $this
            ->view()
            ->setFormat('json')
            ->setData(array(
                'status' => $status
            ));

        return $this->handleView($view);
    }

    public function chooseAction()
    {
        /* @var $registry WidgetRegistry */
        $registry = $this->get('symedit.widget.registry');
        $strategies = $registry->getStrategies();

        $view = $this
            ->view()
            ->setTemplate('@SymEdit/Admin/Widget/choose.html.twig')
            ->setTemplateVar('strategies')
            ->setData(array(
                'strategies' => $strategies,
            ));

        return $this->handleView($view);
    }

    public function createNew()
    {
        $strategyName = $this->getRequest()->get('strategyName');

        try {
            $widget = $this->getRepository()->createNew($strategyName);
        } catch(\Exception $e) {
            throw $this->createNotFoundException(sprintf('Widget with strategy name "%s" does not exist', $strategyName));
        }

        return $widget;
    }
}