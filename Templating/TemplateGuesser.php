<?php

namespace Isometriks\Bundle\SymEditBundle\Templating; 

use Sensio\Bundle\FrameworkExtraBundle\Templating\TemplateGuesser as BaseGuesser; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpKernel\KernelInterface; 

class TemplateGuesser extends BaseGuesser
{
    private $host_bundle; 
    
    public function __construct(KernelInterface $kernel, $host_bundle)
    {
        parent::__construct($kernel);
        
        $this->host_bundle = $host_bundle; 
    }
    
    /**
     * Check to see if there is a _page attribute associate to this request, 
     * if there is, then it came from a page controller, so let's switch the 
     * template to the host bundle. 
     */
    public function guessTemplateName($controller, Request $request, $engine = 'twig')
    {
        $reference = parent::guessTemplateName($controller, $request, $engine);
        
        if($request->attributes->get('_page')){
            $reference->set('bundle', $this->host_bundle); 
        } 
        
        return $reference; 
    }
}