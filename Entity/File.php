<?php

namespace Isometriks\Bundle\MediaBundle\Entity; 

use Symfony\Component\Validator\Constraints as Assert;
use Isometriks\Bundle\MediaBundle\EventListener\RootInjectableInterface; 
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class File implements RootInjectableInterface
{
    protected $callback; 
    
    /**
     * @Assert\NotBlank()
     * @Assert\File()
     */
    protected $file; 
    
    protected $rootDir; 
    
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $path;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name; 
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
    
    protected abstract function getUploadDir(); 
    
    public function __toString()
    {
        return $this->getWebPath(); 
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
    
    public function calculatePath()
    {
        if($this->file !== null){
            $this->setPath($this->getUploadDir().'/'.$this->getUploadName()); 
        }
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
    public function setUpdatedAt($updatedAt)
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
    
    public function setRootDir($dir)
    {
        $this->rootDir = $dir; 
    }
    
    public function getRootDir()
    {
        return $this->rootDir; 
    }
    
    protected function getUploadRootDir()
    {
        return $this->getRootDir().'/../web/'.$this->getUploadDir(); 
    }
    
    public function getWebPath()
    {
        return $this->path === null ? null : '/'.$this->path;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getRootDir().'/../web/'.$this->path;
    }
    
    protected function getUploadName()
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
    
    /**
     * Force lazy load so it's available in postRemove
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if($file = $this->getAbsolutePath()){
            if(file_exists($file)){
                unlink($file); 
            }
        }
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->setUpdated(); 
        
        if(($callback = $this->callback) !== null){
            $this->setName($callback($this)); 
        }
        
        if (null !== $this->file) {
            $this->removeUpload(); 
            $this->calculatePath(); 
        }
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        
        $this->file->move($this->getUploadRootDir(), $this->getUploadName());
        chmod($this->getAbsolutePath(), 0644); 

        unset($this->file);
    }
}