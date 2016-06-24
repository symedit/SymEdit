<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ResourceBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController as BaseResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ResourceController extends BaseResourceController
{
    /**
     * {@inheritdoc}
     *
     * Here for AOP
     */
    public function showAction(Request $request)
    {
        return parent::showAction($request);
    }

    /**
     * Bulk reorder, for drag and drops.
     */
    public function reorderAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $resource = $this->findOr404($configuration);
        $position = $configuration->getSortablePosition();
        $accessor = PropertyAccess::createPropertyAccessor();

        if (($index = $request->request->get('index', null)) !== null) {
            $accessor->setValue($resource, $position, $index);

            // Don't setup flashes
            $this->getManager()->flush();
        }

        $view = View::create()
            ->setFormat('json')
            ->setTemplateVar('status')
            ->setData([
                'status' => true,
            ])
        ;

        return $this->viewHandler->handle($configuration, $view);
    }

    public function historyAction(Request $request)
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
        $resource = $this->findOr404($configuration);
        $repository = $this->get('doctrine')->getManager()->getRepository('Gedmo\Loggable\Entity\LogEntry');
        $entries = $repository->getLogEntries($resource);

        $view = View::create()
            ->setTemplate($configuration->getTemplate('history.html'))
            ->setData([
                $this->metadata->getName() => $resource,
                'entries' => $entries,
            ])
        ;

        return $this->viewHandler->handle($configuration, $view);
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->manager;
    }
}
