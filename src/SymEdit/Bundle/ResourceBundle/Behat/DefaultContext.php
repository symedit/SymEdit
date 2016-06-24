<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ResourceBundle\Behat;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class DefaultContext extends RawMinkContext implements Context, KernelAwareContext
{
    protected $kernel;
    protected $applicationName = 'symedit';

    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    protected function generateUrl($route, array $parameters = [], $absolute = false)
    {
        return $this->locatePath($this->getService('router')->generate($route, $parameters, $absolute));
    }

    protected function generatePageUrl($page, array $parameters = [])
    {
        $route = str_replace(' ', '_', trim($page));

        return $this->generateUrl($route, $parameters);
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return object
     */
    protected function findOneByName($type, $name)
    {
        return $this->findOneBy($type, ['name' => trim($name)]);
    }
    
    /**
     * @param string $type
     * @param array  $criteria
     *
     * @return object
     *
     * @throws \InvalidArgumentException
     */
    protected function findOneBy($type, array $criteria)
    {
        $resource = $this
            ->getRepository($type)
            ->findOneBy($criteria)
        ;

        if (null === $resource) {
            throw new \InvalidArgumentException(
                sprintf('%s for criteria "%s" was not found.', str_replace('_', ' ', ucfirst($type)), serialize($criteria))
            );
        }

        return $resource;
    }

    /**
     * Get Container.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }

    public function getService($service)
    {
        return $this->getContainer()->get($service);
    }

    /**
     * @param string $resourceName
     *
     * @return RepositoryInterface
     */
    public function getRepository($resourceName)
    {
        return $this->getService($this->applicationName.'.repository.'.$resourceName);
    }
}
