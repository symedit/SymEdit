<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\Controller;

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;

/**
 * User controller.
 */
class UserController extends ResourceController
{
    public function createNew()
    {
        return $this->getManager()->createUser(true);
    }

    public function persistAndFlush($resource, $action = 'create')
    {
        $manager = $this->getManager();
        $this->dispatchEvent($action, $resource);
        $manager->updateUser($resource);
        $this->dispatchEvent(sprintf('post_%s', $action), $resource);
    }
}