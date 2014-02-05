<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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