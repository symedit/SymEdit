<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseController;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Component\Templating\TemplateReference;

class ExceptionController extends BaseController
{
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = NULL)
    {
        $code = $exception->getStatusCode();

        if (!$this->debug) {
            $template = new TemplateReference(sprintf('@SymEdit/Exception/%d.html.twig', $code));

            if ($this->templateExists($template)) {
                return new Response($this->twig->render($template, [
                    'status_code' => $code,
                    'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                    'exception' => $exception,
                    'logger' => $logger,
                ]));
            }
        }

        return parent::showAction($request, $exception, $logger);
    }
}
