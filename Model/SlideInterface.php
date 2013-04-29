<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\SymEditBundle\Entity\Image; 

interface SlideInterface
{
    public function getId(); 
    
    public function setCaption($caption); 
    public function getCaption(); 
    
    public function setSlider(SliderInterface $slider); 
    public function getSlider(); 
    
    public function setImage(Image $image); 
    public function getImage(); 
    
    public function setPosition($position); 
    public function getPosition(); 
}