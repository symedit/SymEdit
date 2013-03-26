<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

class SliderController extends Controller
{
    public function indexAction($name, $template = null)
    {
        if($template === null){
            $template = $this->getHostTemplate('Widget', 'slider.html.twig'); 
        }
        
        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('IsometriksSymEditBundle:Slider')->findOneByName($name);

        if (!$slider) {
            throw $this->createNotFoundException(sprintf('Slider "%s" not found.', $name));
        }

        return $this->render($template, array(
            'Slider' => $slider,
        ));
    }
}