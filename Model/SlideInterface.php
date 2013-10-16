<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;

interface SlideInterface
{
    public function getId(); 
    
    public function setCaption($caption); 
    public function getCaption(); 
    
    public function setSlider(SliderInterface $slider); 
    public function getSlider(); 
    
    public function setImage(MediaInterface $image); 
    public function getImage(); 
    
    public function setPosition($position); 
    public function getPosition(); 
}