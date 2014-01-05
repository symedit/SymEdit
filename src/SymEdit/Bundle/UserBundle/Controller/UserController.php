<?php

namespace Isometriks\Bundle\UserBundle\Controller;

use Isometriks\Bundle\SymEditBundle\Controller\ResourceController;
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