<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture as BaseAbstractFixture;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractFixture extends BaseAbstractFixture implements ContainerAwareInterface
{
    protected $container;
    protected $applicationName = 'symedit';

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * @param string $type
     *
     * @return RepositoryInterface
     */
    protected function getRepository($type)
    {
        return $this->getContainer()->get(sprintf('%s.repository.%s', $this->applicationName, $type));
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory($type)
    {
        return $this->getContainer()->get(sprintf('%s.factory.%s', $this->applicationName, $type));
    }
}
