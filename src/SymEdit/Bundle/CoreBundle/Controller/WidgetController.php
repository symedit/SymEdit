<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use Symfony\Component\Templating\TemplateReference;
use SymEdit\Bundle\CoreBundle\Controller\Controller;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;

class WidgetController extends Controller
{
    public function renderAreaAction($area, PageInterface $_page = null, $path = null)
    {
        $repository = $this->get('symedit.repository.widget_area');
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
