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
        $user = $this->getUserManager()->createUser(true);
        $user->setEnabled(true);

        return $user;
    }

    public function getUserManager()
    {
        return $this->container->get('symedit_user.user_manager');
    }
}
