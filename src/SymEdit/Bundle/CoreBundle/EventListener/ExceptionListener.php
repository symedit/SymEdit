<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $request = $event->getRequest();
        $code = $event->getException()->getCode();

        /*
         * Can't provide information without a request and we only
         * want to provide this information for critical errors.
         */
        if ($request === null || $code < 500 || $code >= 600) {
            return;
        }

        $message = <<<EOF
An error has occured in the application at url: %s
Route name: %s
Route Parameters: %s
EOF;

        $this->logger->critical(
            sprintf($message,
                $request->getUri(),
                $request->get('_route'),
                json_encode($request->get('_route_params'), \JSON_PRETTY_PRINT)
            )
        );
    }
}
