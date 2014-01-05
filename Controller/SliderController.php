<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

class SliderController extends Controller
{
    public function indexAction($name, $template = null, $thumbnails = null)
    {
        if($template === null){
            $template = '@SymEdit/Widget/slider.html.twig';
        }

        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('Isometriks\Bundle\SymEditBundle\Model\Slider')->findOneByName($name);

        if (!$slider) {
            throw $this->createNotFoundException(sprintf('Slider "%s" not found.', $name));
        }

        return $this->render($template, array(
            'Slider' => $slider,
            'thumbnails' => $thumbnails !== null && $thumbnails,
        ));
    }
}
