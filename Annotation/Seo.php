<?php

namespace Isometriks\Bundle\SeoBundle\Annotation;

/**
 * @Annotation
 */
class Seo 
{
    private $subject;  
    
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . $key;
            if (!method_exists($this, $method)) {
                throw new \BadMethodCallException(sprintf("Unknown property '%s' on annotation '%s'.", $key, get_class($this)));
            }
            $this->$method($value);
        }
    }
    
    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
        
    public function all()
    {
        return array(
            'subject' => $this->getSubject(),
        );
    }
}