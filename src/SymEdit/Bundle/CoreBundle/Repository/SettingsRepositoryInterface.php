<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Repository;

use Sylius\Component\Resource\Repository\RepositoryInterface;

interface SettingsRepositoryInterface extends RepositoryInterface
{
    /**
     * Gets DateTime for last updated setting.
     *
     * @return \DateTime DateTime of last updated setting
     */
    public function getLastUpdated();
}
