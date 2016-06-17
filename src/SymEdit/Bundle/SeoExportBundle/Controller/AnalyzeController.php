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

class AnalyzeController extends Controller
{
    /**
     * @Route("/sym-admin/seo-export/analyze", name="symedit_seo_analyze")
     * @Template()
     */
    public function indexAction()
    {
        $repositories = [
            'page' => [
                'route' => 'admin_page_update',
                'criteria' => [
                    'root' => false,
                ],
            ],

            'post' => [
                'route' => 'admin_post_update',
                'criteria' => [],
            ],

            'category' => [
                'route' => 'admin_category_update',
                'criteria' => [],
            ],
        ];

        $entities = [];
        $routes = [];
        $analyzer = $this->get('symedit_seo.analyzer');

        foreach ($repositories as $repositoryName => $config) {
            $repository = $this->get('symedit.repository.'.$repositoryName);
            $entities[$repositoryName] = [];
            $routes[$repositoryName] = $config['route'];

            foreach ($repository->findBy($config['criteria']) as $object) {
                $context = $analyzer->analyze($object);

                if ($context->hasIssues()) {
                    $entities[$repositoryName][] = $context;
                }
            }
        }

        return [
            'groups' => $entities,
            'routes' => $routes,
        ];
    }
}
