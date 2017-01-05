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

use Sylius\Component\Resource\Model\ResourceInterface;

interface EventInterface extends ResourceInterface
{
    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getSlug();

    public function setSlug($slug);

    public function setDescription($description);

    public function getEventStart();

    public function setEventStart(\DateTime $eventStart);

    public function getEventEnd();

    public function setEventEnd(\DateTime $eventEnd);

    public function getUrl();

    public function setUrl($url);

    public function getEmail();

    public function setEmail($email);

    public function getPhone();

    public function setPhone($phone);

    public function getPrice();

    public function setPrice($price);

    public function getAddress();

    public function setAddress($address);

    public function getShowMap();

    public function setShowMap($showMap);
}
