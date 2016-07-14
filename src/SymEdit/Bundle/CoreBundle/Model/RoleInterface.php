<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface RoleInterface extends ResourceInterface
{
    public function getId();

    public function setRole($role);
    public function getRole();

    public function setDescription($description);
    public function getDescription();
}
