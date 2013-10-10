<?php

namespace Isometriks\Bundle\SymEditBundle\Event;

final class Events
{
    /**
     * Dispatched when a new Page is created
     */
    const PAGE_CREATED = 'symedit.page.created';

    /**
     * Dispatched when a new Post is created
     */
    const POST_CREATED = 'symedit.post.created';
}