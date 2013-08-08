<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseController;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends BaseController
{
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        $code = $exception->getStatusCode();

        if (!$this->debug) {
            $template = new TemplateReference(sprintf('@SymEdit/Exception/%d.html.twig', $code));

            if ($this->templateExists($template)) {
                return new Response($this->twig->render($template, array(
                    'status_code' => $code,
                    'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                    'exception' => $exception,
                    'logger' => $logger,
                )));
            }
        }

        return parent::showAction($request, $exception, $logger, $format);
    }
}