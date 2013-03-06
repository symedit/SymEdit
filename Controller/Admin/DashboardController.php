<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Isometriks\Bundle\SymEditBundle\Form\FixMissingType;

/**
 * Dashboard controller.
 */
class DashboardController extends Controller {

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_dashboard")
     * @Template()
     */
    public function indexAction()
    {
        $missing_form = $this->createForm(new FixMissingType());

        return array(
            'missing_templates' => $this->getMissing(),
            'missing_form' => $missing_form->createView(),
        );
    }

    /**
     * Updates all pages missing templates
     * 
     * @Route("/update-missing", name="admin_dashboard_update_missing")
     */
    public function updateMissingAction()
    {
        $missing_form = $this->createForm(new FixMissingType()); 
        $missing_form->bind($this->getRequest()); 
        
        $template = $missing_form->get('template')->getData();
        $em       = $this->getDoctrine()->getManager(); 
        
        foreach($this->getMissing() as $page){
            $page->setTemplate($template); 
            $em->persist($page); 
        }
        
        $em->flush(); 
        
        return $this->redirect($this->generateUrl('admin_dashboard')); 
    }

    private function getMissing()
    {
        $em    = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('p')
                ->from('IsometriksSymEditBundle:Page', 'p')
                ->where('(p.template IS NULL OR p.template = :blank) AND p.root = false AND p.pageController = false')
                ->setParameter('blank', '')
                ->getQuery();

        return $query->getResult();
    }

}
