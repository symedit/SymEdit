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
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

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
        $exception = $event->getException();

        // Can't provide route information without request
        if ($request === null) {
            return;
        }

        // Don't do critical for non 5xx http errors
        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();

            if ($code < 500 || $code >= 600) {
                return;
            }
        }

        // Must be either an HttpException with 5xx status code, or a general php error
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
