<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\EventsBundle\Model;

class Event implements EventInterface
{
    protected $id;
    protected $title;
    protected $slug;
    protected $description;
    protected $eventStart;
    protected $eventEnd;
    protected $url;
    protected $email;
    protected $phone;
    protected $price;
    protected $address;
    protected $showMap;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getEventStart()
    {
        return $this->eventStart;
    }

    public function setEventStart(\DateTime $eventStart)
    {
        $this->eventStart = $eventStart;

        return $this;
    }

    public function getEventEnd()
    {
        return $this->eventEnd;
    }

    public function setEventEnd(\DateTime $eventEnd = null)
    {
        $this->eventEnd = $eventEnd;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getShowMap()
    {
        return $this->showMap;
    }

    public function setShowMap($showMap)
    {
        $this->showMap = $showMap;

        return $this;
    }
}
