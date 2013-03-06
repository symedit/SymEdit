<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseController;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; 
use Isometriks\Bundle\SymEditBundle\Entity\Page; 

class ExceptionController extends BaseController
{
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        $code        = $exception->getStatusCode();
        $host_bundle = $this->container->getParameter('isometriks_sym_edit.host_bundle');
        $templating  = $this->container->get('templating');
        $debug       = $this->container->get('kernel')->isDebug();

        // If not debugging, try to find a template that exists, if not we'll 
        // default to Twig's default behavior.
        if (!$debug) {
            $bundles = array($host_bundle, 'IsometriksSymEditBundle');

            foreach ($bundles as $bundle) {
                $template = new TemplateReference($bundle, 'Exception', $code, 'html', 'twig');

                if ($templating->exists($template)) {
                    return $templating->renderResponse($template, array(
                        'Page' => $this->getPage(), 
                        'status_code' => $code,
                        'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                        'exception' => $exception,
                        'logger' => $logger,
                    ));
                }
            }
        }

        return parent::showAction($request, $exception, $logger, $format);
    }
    
    /**
     * Need to inject a fake Page object so that things can still function.
     * 
     * @return \Isometriks\Bundle\SymEditBundle\Entity\Page
     */
    private function getPage()
    {
        $page = new Page(); 
        
        return $page; 
    }
}