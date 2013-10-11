<?php

namespace Isometriks\Bundle\MediaBundle\Model;

interface FileInterface
{
    public function getUploadDir();
    
    public function setPath($path);
    
    public function getPath();
    
    public function getName();
    
    public function setName($name);
    
    public function setUpdatedAt(\DateTime $updatedAt);
    
    public function getUpdatedAt();
    
    public function setUpdated();
    
    public function hasFile();
    
    public function setFile($file);
    
    public function getFile();
    
    public function getWebPath();
    
    public function getUploadName();
    
    public function setNameCallback($callback);
    
    public function getNameCallback();
}