<?php

namespace Isometriks\Bundle\SymEditBundle\Event;

final class Events
{
    /**
     * Page Events
     */
    const PAGE_CREATED = 'symedit.page.created';
    const PAGE_VIEW    = 'symedit.page.view';

    /**
     * Post Events
     */
    const POST_CREATED = 'symedit.post.created';
    const POST_VIEW    = 'symedit.post.view';
}