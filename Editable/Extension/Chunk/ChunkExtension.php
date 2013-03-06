<?php
 
namespace Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk; 

use Isometriks\Bundle\SymEditBundle\Entity\Page; 
use Isometriks\Bundle\SymEditBundle\Entity\Chunk; 
use Isometriks\Bundle\SymEditBundle\Editable\Editable; 
use Isometriks\Bundle\SymEditBundle\Editable\AbstractEditableExtension;  
use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\ChunkRegistry; 
use Isometriks\Bundle\SymEditBundle\Editable\Extension\Chunk\ChunkManager; 
use Symfony\Component\Form\FormFactory; 
use Symfony\Component\Security\Core\SecurityContext; 
use Doctrine\Bundle\DoctrineBundle\Registry; 

class ChunkExtension extends AbstractEditableExtension
{ 
    private $registry; 
    private $manager;
    private $doctrine; 
    
    public function __construct(ChunkRegistry $registry, ChunkManager $manager, Registry $doctrine)
    {
        $this->registry = $registry; 
        $this->manager = $manager; 
        $this->doctrine = $doctrine; 
    }

    public function supports(Editable $editable)
    {
        return ($editable->getSubject() instanceof Page) && (strtolower($editable->getType()) === 'chunk');
    }
    
    public function execute(Editable $editable, FormFactory $factory, SecurityContext $context)
    {
        $chunk = $this->getChunk($editable); 
        $strategy = $chunk->getStrategy(); 
        
        if($context->getToken() !== null && $context->isGranted('ROLE_ADMIN_EDITABLE')){
            $response = $strategy->edit($chunk, $this->getTemplating(), $factory); 
        } else {
            $response = $strategy->render($chunk, $this->getTemplating(), $factory); 
        }
        
        return $response; 
    }
    
    private function getChunk(Editable $editable)
    {
        $page = $this->getScope($editable);  
        $name = $editable->getParameter('name'); 

        if(!$chunk = $page->getChunk($name)){
            
            // Remove extra options
            $options = $editable->getParameters(); 
            unset($options['scope'], $options['name'], $options['strategy']);
            
            $strategy = $editable->getParameter('strategy'); 
            
            $chunk = $this->manager->create($page, $name, $strategy, $options); 
        }
        
        return $chunk; 
    }
    
    private function getScope(Editable $editable)
    {
        $scope = $editable->hasParameter('scope') ? strtoupper($editable->getParameter('scope')) : 'SELF'; 
        $subject = $editable->getSubject(); 
        
        if(defined('\Isometriks\Bundle\SymEditBundle\Entity\Chunk::' . $scope)){
            $scope = constant('\Isometriks\Bundle\SymEditBundle\Entity\Chunk::' . $scope); 
        } else {
            throw new \Exception(sprintf('Chunk scope "%s" not found', $scope)); 
        }   
        
        if ($scope === Chunk::PARENT) {
            $page = $subject->getParent(); 
            
        } elseif ($scope === Chunk::ROOT) {
            $page = $this->doctrine->getManager()->getRepository('IsometriksSymEditBundle:Page')->findRoot(); 
            
        } else {
            $page = $subject; 
        }
        
        return $page; 
    }
    
    public function getJavascripts()
    {
        return array(
            'bundles/isometrikssymedit/js/editable/chunk.js', 
            'bundles/isometrikssymedit/js/editable/jquery.ajaxsubmit.js', 
            'bundles/isometrikssymedit/redactor/redactor.min.js'
        ); 
    }
    
    public function getStylesheets()
    {
        return array(
            'bundles/isometrikssymedit/redactor/redactor-inline.css', 
        ); 
    }
}