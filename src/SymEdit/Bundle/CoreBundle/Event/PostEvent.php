<?php

namespace SymEdit\Bundle\CoreBundle\Event;

use SymEdit\Bundle\CoreBundle\Model\PostInterface;
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