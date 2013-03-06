<?php

namespace Isometriks\Bundle\SymEditBundle\Entity; 

use Symfony\Component\Validator\Constraints as Assert;
use Isometriks\Bundle\SymEditBundle\Listener\RootInjectableInterface; 
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class File implements RootInjectableInterface
{
    /**
     * @Assert\Image(maxSize="6000000") 
     * @Assert\NotBlank()
     */
    protected $file; 
    protected $rootDir; 
    
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $path;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name; 
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
    
    protected abstract function getUploadDir(); 
    
    public function __toString()
    {
        return $this->getName(); 
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
        
        if (null !== $this->file) {
            $this->removeUpload(); 
            $this->path = $this->getUploadDir().'/'.$this->getUploadName();
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