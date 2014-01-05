<?php

namespace Isometriks\Bundle\UserBundle\Model;

use Isometriks\Bundle\MediaBundle\Model\MediaInterface;
use Isometriks\Bundle\SymEditBundle\Util\Util;
use Isometriks\Bundle\SymEditBundle\Model\UserInterface;

class AdminProfile extends Profile
{
    protected $image;

    protected $social;

    protected $summary;

    protected $biography;

    protected $display;

    protected $slug;

    public function __construct()
    {
        $this->display = true;
    }

    /**
     * Gets user's image
     *
     * @return MediaInterface
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the user's image
     *
     * @param MediaInterface $image
     * @return UserInterface
     */
    public function setImage(MediaInterface $image)
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

    public function getSummary()
    {
        return $this->summary;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;

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
     * @return \Isometriks\Bundle\UserBundle\Model\User
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

    public function getSlug()
    {
        return $this->slug;
    }
}