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
use Sylius\Bundle\ResourceBundle\Controller\ResourceController as BaseResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ResourceController extends BaseResourceController
{
    /**
     * Bulk reorder, for drag and drops
     */
    public function reorderAction(Request $request)
    {
        $pairs = $request->request->get('pairs', array());
        $repository = $this->getRepository();
        $manager = $this->getManager();

        $position = $this->config->getSortablePosition();
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach (array_reverse($pairs, true) as $id => $order) {
            if (!$resource = $repository->find($id)) {
                throw $this->createNotFoundException('Sorting entity not found');
            }

            $accessor->setValue($resource, $position, $order);
        }

        $manager->flush();

        $view = $this->view()
            ->setFormat('json')
            ->setTemplateVar('status')
            ->setData(array(
                'status' => true,
            ));

        return $this->handleView($view);
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->get($this->getConfiguration()->getServiceName('manager'));
    }
}
