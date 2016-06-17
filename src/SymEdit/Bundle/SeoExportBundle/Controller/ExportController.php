<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoExportBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    /**
     * @Route("/sym-admin/seo-export/export", name="symedit_seo_export")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->get('symedit.repository.page');
        $pages = $repository->findBy([
            'root' => false,
        ]);

        $fh = fopen('php://temp', 'w+');

        fputcsv($fh, [
            'id', 'path', 'title', 'tagline', 'meta description', 'meta keywords', 'seo title', 'index', 'follow',
        ]);

        foreach ($pages as $page) {
            $seo = array_replace([
                'description' => '',
                'keywords' => '',
                'title' => '',
                'index' => '',
                'follow' => '',
            ], (array) $page->getSeo());

            $data = [
                'id' => $page->getId(),
                'path' => $page->getPath(),
                'title' => $page->getTitle(),
                'tagline' => $page->getTagline(),
            ] + $seo;

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
