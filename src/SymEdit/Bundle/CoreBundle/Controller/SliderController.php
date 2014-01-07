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

class SliderController extends Controller
{
    public function indexAction($name, $template = null, $thumbnails = null)
    {
        if($template === null){
            $template = '@SymEdit/Widget/slider.html.twig';
        }

        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('SymEdit\Bundle\CoreBundle\Model\Slider')->findOneByName($name);

        if (!$slider) {
            throw $this->createNotFoundException(sprintf('Slider "%s" not found.', $name));
        }

        return $this->render($template, array(
            'Slider' => $slider,
            'thumbnails' => $thumbnails !== null && $thumbnails,
        ));
    }
}
