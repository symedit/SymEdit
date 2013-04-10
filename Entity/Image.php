<?php

namespace Isometriks\Bundle\SymEditBundle\Entity; 

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Isometriks\Bundle\MediaBundle\Entity\File; 

/**
 * Image entity, extends the File entity in MediaBundle 
 */
class Image extends File
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
    
    protected function getUploadName()
    {
        return $this->name.'.'.$this->file->guessExtension(); 
    }
    
    protected function getUploadDir()
    {
        return 'img/uploads';
    }
    
    /**
     * PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            if(file_exists($file)){
                unlink($file);
            }
            
            $info = pathinfo( $file );
            $glob = sprintf( '%s/cache/%s_*', $info[ 'dirname' ], $info[ 'filename' ] );
            
            foreach( glob( $glob ) as $file ){
                unlink( $file );
            }
        }
    }


}