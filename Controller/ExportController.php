<?php

namespace SymEdit\Bundle\SeoExportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    /**
     * @Route("%isometriks_symedit.admin_dir%/seo-export/export", name="symedit_seo_export")
     * @Template()
     */
    public function indexAction()
    {
        if ($this->container->has('isometriks_symedit.repository.page')) {
            $repository = $this->get('isometriks_symedit.repository.page');
            $pages = $repository->findBy(array(
                'root' => false,
            ));
        } else {
            $repository = $this->get('isometriks_symedit.page_manager');
            $pages = $repository->findPagesBy(array(
                'root' => false,
            ));
        }

        $fh = fopen('php://temp', 'w+');

        fputcsv($fh, array(
            'id', 'path', 'title', 'tagline', 'meta description', 'meta keywords', 'seo title', 'index', 'follow',
        ));

        foreach ($pages as $page) {

            $seo = array_replace(array(
                'description' => '',
                'keywords' => '',
                'title' => '',
                'index' => '',
                'follow' => '',
            ), (array)$page->getSeo());

            $data = array(
                'id' => $page->getId(),
                'path' => $page->getPath(),
                'title' => $page->getTitle(),
                'tagline' => $page->getTagline(),
            ) + $seo;

            fputcsv($fh, $data);
        }

        rewind($fh);
        $csv = stream_get_contents($fh);

        $response = new Response($csv);
        $response->headers->set('Content-type', 'text/x-comma-separated-values');

        fclose($fh);

        return $response;
    }
}
