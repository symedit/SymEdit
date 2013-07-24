<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Component\Templating\TemplateReference;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WidgetController extends Controller
{
    public function renderAreaAction(Request $request, $area, $path = null, $id = null)
    {
        $manager = $this->get('isometriks_symedit.widget.manager');
        $widgetArea = $manager->getWidgetArea($area);

        $response = $this->createResponse();

        $lastUpdated = null;
        $widgets = array();

        foreach($widgetArea->getWidgets() as $widget){

            if(!$widget->isVisible(array($path, $id))){
                continue;
            }

            $lastUpdated = max($widget->getUpdatedAt(), $lastUpdated);

            $widgets[] = array(
                'id' => $widget->getId(),
                'title' => $widget->getTitle(),
                'content' => $widget->getStrategy()->execute($widget),
            );
        }

        if($lastUpdated !== null){
            $response->setLastModified($lastUpdated);

            if($response->isNotModified($request)) {
                $response->setSharedMaxAge(60);
                return $response;
            }
        }

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