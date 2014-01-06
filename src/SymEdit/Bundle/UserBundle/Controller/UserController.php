<?php

namespace SymEdit\Bundle\UserBundle\Controller;

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
 * User controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_USER')")
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