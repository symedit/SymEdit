<?php

namespace SymEdit\Bundle\MediaBundle\Model;

interface MediaInterface
{
    public function getId();
    
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