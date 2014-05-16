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

class ResourceController extends BaseResourceController
{
    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->get($this->getConfiguration()->getServiceName('manager'));
    }
}