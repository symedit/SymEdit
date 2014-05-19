<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Event;

use SymEdit\Bundle\BlogBundle\Model\PostInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

class PostEvent extends Event
{
    private $request;
    private $post;

    public function __construct(PostInterface $post, Request $request)
    {
        $this->post = $post;
        $this->request = $request;
    }

    /**
     * @return PostInterface
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
