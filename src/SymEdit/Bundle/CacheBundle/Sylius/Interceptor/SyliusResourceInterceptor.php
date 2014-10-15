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
use Sylius\Bundle\ResourceBundle\Controller\ParametersParser;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use SymEdit\Bundle\CacheBundle\Decision\CacheDecisionManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SyliusResourceInterceptor implements MethodInterceptorInterface
{
    protected $decider;
    protected $parser;

    public function __construct(CacheDecisionManager $decider, ParametersParser $parser)
    {
        $this->decider = $decider;
        $this->parser = $parser;
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

        // Current Resource
        $resource = $controller->findOr404($request);

        // Cache Options
        $options = $request->attributes->get('_sylius', array());
        $cacheOptions = array_key_exists('cache', $options) ? $options['cache'] : array();

        // Build the actual cache options since we'll need to use it twice
        $this->parser->process($cacheOptions, $resource);

        // Create a preliminary response to see if it is already cached
        $cachedResponse = new Response();
        $cachedResponse->setCache($cacheOptions);

        if ($cachedResponse->isNotModified($request)) {
            return $cachedResponse;
        }

        // If not we take the response back from the controller and modify it again
        $controllerResponse = $invocation->proceed();
        $controllerResponse->setCache($cacheOptions);

        return $controllerResponse;
    }
}
