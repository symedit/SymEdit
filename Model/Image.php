<?php

namespace Isometriks\Bundle\SymEditBundle\Model; 

use Isometriks\Bundle\MediaBundle\Model\Media; 

/**
 * Image entity, extends the File entity in MediaBundle 
 */
class Image extends Media
{
    /**
     * @var int Primary Key
     */
    private $id; 

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}