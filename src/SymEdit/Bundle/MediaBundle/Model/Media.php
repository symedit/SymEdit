<?php

namespace Isometriks\Bundle\MediaBundle\Model; 

class Media implements MediaInterface
{
    protected $id;
    protected $callback; 
    protected $file; 
    protected $path;
    protected $name; 
    protected $updatedAt;
    
    public function __toString()
    {
        return $this->getWebPath(); 
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set path
     *
     * @param string $path
     * @return BeverageImage
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    public function getName()
    {
        return $this->name; 
    }
    
    public function setName($name)
    {
        $this->name = $name; 
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return BeverageImage
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    
    public function setUpdated()
    {
        $this->setUpdatedAt(new \DateTime()); 
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function hasFile()
    {
        return ($this->file !== null || $this->path !== null); 
    }
    
    public function setFile($file)
    {
        $this->file = $file; 
        $this->setUpdated(); 
    }
    
    public function getFile()
    {
        return $this->file; 
    }
    
    public function getWebPath()
    {
        return $this->path === null ? null : '/'.$this->path;
    }
    
    public function getUploadName()
    {
        return $this->name.'.'.$this->file->guessExtension(); 
    }
    
    public function setNameCallback($callback)
    {
        if(!is_callable($callback)){
            throw new \Exception('Callback is not callable.'); 
        }
        
        $this->callback = $callback; 
    }
    
    public function getNameCallback()
    {
        return $this->callback; 
    }
}