<?php

namespace Isometriks\Bundle\SymEditBundle\Event;

final class Events
{
    /**
     * Page Events
     */
    const PAGE_CREATED  = 'isometriks_symedit.page.create';
    const PAGE_UPDATED  = 'isometriks_symedit.page.update';
    const PAGE_VIEW     = 'isometriks_symedit.page.view';

    /**
     * Post Events
     */
    const POST_CREATED  = 'isometriks_symedit.post.create';
    const POST_UPDATED  = 'isometriks_symedit.post.update';
    const POST_VIEW     = 'isometriks_symedit.post.view';

    /**
     * Menu Events
     */
    const MENU_VIEW     = 'isometriks_symedit.menu.view';
}