<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SliderController extends Controller
{
    public function indexAction($name, $template = null)
    {
        if($template === null){
            $host_bundle = $this->container->getParameter('isometriks_sym_edit.host_bundle');
            $template = sprintf('%s:Widget:%s', $host_bundle, 'slider.html.twig');
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