<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\Templating\TemplateReference;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;

class WidgetController extends Controller
{
    public function renderAreaAction($area, PageInterface $_page = null, $path = null)
    {
        $repository = $this->get('isometriks_symedit.repository.widget_area');
        $widgetArea = $repository->findOneByArea($area);

        $id = $_page === null ? null : $_page->getId();
        $widgets = array();

        foreach($widgetArea->getWidgets() as $widget){

            if(!$widget->isVisible(array($path, $id))){
                continue;
            }

            $content = $widget->getStrategy()->execute($widget, $_page);

            if ($content === false) {
                continue;
            }

            $widgets[] = array(
                'id' => $widget->getId(),
                'name' => $widget->getName(),
                'title' => $widget->getTitle(),
                'content' => $content,
            );
        }

        $response = $this->createResponse();

        $templateName = sprintf('@SymEdit/WidgetArea/%s.html.twig', $area);
        $template = new TemplateReference($templateName);

        if(!$this->templateExists($template)){
            $template->set('name', '@SymEdit/WidgetArea/default.html.twig');
        }

        return $this->render($template, array(
            'widgetArea' => $widgetArea,
            'widgets' => $widgets,
            'area' => $area,
        ), $response);
    }


    private function templateExists($template)
    {
       $loader = $this->get('twig')->getLoader();

       if($loader instanceof \Twig_ExistsLoaderInterface){
           return $loader->exists($template);
       }

       return false;
    }
}
