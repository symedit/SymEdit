<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\Sylius\Interceptor;

use CG\Proxy\MethodInterceptorInterface;
use CG\Proxy\MethodInvocation;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\Controller\SingleResourceProviderInterface;
use Sylius\Component\Resource\Metadata\RegistryInterface;
use SymEdit\Bundle\CacheBundle\Decision\CacheDecisionManager;
use SymEdit\Bundle\CacheBundle\Sylius\AttributeParser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SyliusResourceInterceptor implements MethodInterceptorInterface
{
    protected $decider;
    protected $parser;
    protected $configurationFactory;
    protected $registry;
    protected $singleResourceProvider;
    protected $container;

    public function __construct(
        CacheDecisionManager $decider,
        AttributeParser $parser,
        RequestConfigurationFactoryInterface $configurationFactory,
        RegistryInterface $registry,
        SingleResourceProviderInterface $singleResourceProvider,
        ContainerInterface $container)
    {
        $this->decider = $decider;
        $this->parser = $parser;
        $this->configurationFactory = $configurationFactory;
        $this->registry = $registry;
        $this->singleResourceProvider = $singleResourceProvider;
        $this->container = $container;
    }

    public function intercept(MethodInvocation $invocation)
    {
        /*
         * First let's make sure we can even bother caching this
         * if we can't then just return the controller response
         */
        if (!$this->decider->decide()) {
            return $invocation->proceed();
        }

        /* @var $controller ResourceController */
        $controller = $invocation->object;

        /* @var $request Request */
        $request = $invocation->arguments[0];
        $controllerPath = $request->attributes->get('_controller', null);

        // Split into controller:method
        list($controllerString, $method) = explode(':', $controllerPath, 2);

        // Split into vendor.controller.type
        list($appName, $ignored, $alias) = explode('.', $controllerString, 3);

        // Get metadata
        $metadata = $this->registry->get(sprintf('%s.%s', $appName, $alias));
        $requestConfiguration = $this->configurationFactory->create($metadata, $request);

        // Get Repository
        $repository = $this->container->get($metadata->getServiceId('repository'));
        $resource = $this->singleResourceProvider->get($requestConfiguration, $repository);

        // Cache Options
        $options = $request->attributes->get('_sylius', []);
        $cacheOptions = array_key_exists('cache', $options) ? $options['cache'] : [];

        // Build the actual cache options since we'll need to use it twice
        $parsedOptions = $this->parser->process($cacheOptions, $resource);

        // Create a preliminary response to see if it is already cached
        $cachedResponse = new Response();
        $cachedResponse->setCache($parsedOptions);

        if ($cachedResponse->isNotModified($request)) {
            return $cachedResponse;
        }

        // If not we take the response back from the controller and modify it again
        $controllerResponse = $invocation->proceed();
        $controllerResponse->setCache($parsedOptions);

        return $controllerResponse;
    }
}
