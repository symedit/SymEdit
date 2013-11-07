<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

class Seo implements SeoInterface
{
    protected $title;
    protected $description;
    protected $keywords;
    protected $index;
    protected $follow;
    
    protected static $allowedKeys = array(
        'title', 'description', 'keywords',
        'index', 'follow',
    );
    
    public function __construct(array $values = array())
    {
        $this->index = true;
        $this->follow = true;
        
        $this->merge($values);
    }
    
    public function merge(array $values = array(), $mergeEmpty = false)
    {
        foreach ($values as $key => $value)
        {
            if (!in_array($key, self::$allowedKeys)) {
                throw new \Exception(sprintf('Invalid SEO key: "%s"', $key));
            }
            
            if ($mergeEmpty || !empty($value)) {
                $this->$key = $value;
            }
        }
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }    

    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
        
        return $this;
    }    

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        
        return $this;
    }
    
    public function getIndex()
    {
        return $this->index;
    }    

    public function setIndex($index)
    {
        $this->index = $index;
        
        return $this;
    }
        
    public function setFollow($follow)
    {
        $this->follow = $follow;
        
        return $this;
    }
    
    public function getFollow()
    {
        return $this->follow;
    }
}