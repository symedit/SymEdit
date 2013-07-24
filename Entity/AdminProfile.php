<?php

namespace Isometriks\Bundle\UserBundle\Entity;

use Isometriks\Bundle\SymEditBundle\Entity\Image;
use Isometriks\Bundle\SymEditBundle\Util\Util;

class AdminProfile extends Profile
{
    protected $image;

    protected $social;

    protected $biography;

    protected $display;


    public function __construct()
    {
        $this->display = true;
    }

    /**
     * Gets user's image
     *
     * @return \Isometriks\Bundle\SymEditBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the user's image
     *
     * @param \Isometriks\Bundle\UserBundle\Entity\Image $image
     * @return \Isometriks\Bundle\UserBundle\Entity\User
     */
    public function setImage(Image $image)
    {
        $user = $this->getUser();

        $image->setNameCallback(function() use ($user){
            return Util::slugify($user->getProfile()->getFullname());
        });

        $this->image = $image;

        return $this;
    }

    public function getSocial()
    {
        return $this->social;
    }

    public function setSocial(array $social)
    {
        $this->social = $social;

        return $this;
    }

    /**
     * Get the user's biography
     *
     * @return string $biography
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * Set user biography
     *
     * @param string $biography
     * @return \Isometriks\Bundle\UserBundle\Entity\User
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;

        return $this;
    }

    public function getDisplay()
    {
        return $this->display;
    }

    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }
}