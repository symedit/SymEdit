<?php

namespace Isometriks\Bundle\SymEditBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController as BaseController;
use Symfony\Component\HttpKernel\Exception\FlattenException;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;
use Isometriks\Bundle\SymEditBundle\Entity\Page; 

class ExceptionController extends BaseController
{
    private $host_bundle; 
    
    public function __construct(\Twig_Environment $twig, $debug, $host_bundle)
    {
        parent::__construct($twig, $debug); 
        
        $this->host_bundle = $host_bundle; 
    }
    
    public function showAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null, $format = 'html')
    {
        $code = $exception->getStatusCode();

        // If not debugging, try to find a template that exists, if not we'll 
        // default to Twig's default behavior.
        if (!$this->debug) {
            $bundles = array($this->host_bundle, 'IsometriksSymEditBundle');

            foreach ($bundles as $bundle) {
                $template = new TemplateReference($bundle, 'Exception', $code, 'html', 'twig');

                if ($this->templateExists($template)) {
                    return new Response($this->twig->render($template, array(
                        'Page' => $this->getPage(), 
                        'status_code' => $code,
                        'status_text' => isset(Response::$statusTexts[$code]) ? Response::$statusTexts[$code] : '',
                        'exception' => $exception,
                        'logger' => $logger,
                    )));
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