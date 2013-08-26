<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Isometriks\Bundle\SymEditBundle\Annotation\PageController as Bind;
use Isometriks\Bundle\SitemapBundle\Annotation\Sitemap;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;

/**
 * @Bind(name="symedit-contact")
 */
class ContactController extends Controller
{
    /**
     * @Route("/", name="contact")
     * @Sitemap()
     */
    public function indexAction(Request $request, PageInterface $_page)
    {
        $form = $this->createForm('symedit_contact');

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $data = $form->getData();

                /**
                 * Set replyTo if it was sent so it's easier for people
                 * to email back.
                 */
                $options = empty($data['email']) ? array() : array(
                    'replyTo' => $data['email'],
                );

                $this->getMailer()->sendAdmin('@SymEdit/Contact/contact.html.twig', array(
                    'Form' => $data,
                ), $options);

                return $this->render('@SymEdit/Contact/success.html.twig');
            }
        }

        return $this->render('@SymEdit/Contact/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}