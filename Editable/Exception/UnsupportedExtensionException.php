<?php

namespace Isometriks\Bundle\SymEditBundle\Editable\Exception; 

use Isometriks\Bundle\SymEditBundle\Editable\Editable; 

class UnsupportedExtensionException extends EditableException
{
    protected $editable; 
    
    public function __construct(Editable $editable, $message = null, $code = 0, \Exception $previous = null) {
        
        $this->editable = $editable; 
        
        parent::__construct($message, $code, $previous);
    }
    
    public function getEditable()
    {
        return $this->editable; 
    }
}