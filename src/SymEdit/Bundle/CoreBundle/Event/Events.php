<?php

namespace SymEdit\Bundle\CoreBundle\Event;

final class Events
{
    /**
     * Page Events
     */
    const PAGE_PRE_CREATE   = 'isometriks_symedit.page.pre_create';
    const PAGE_CREATE       = 'isometriks_symedit.page.create';
    const PAGE_POST_CREATE  = 'isometriks_symedit.page.post_create';

    const PAGE_PRE_UPDATE   = 'isometriks_symedit.page.pre_update';
    const PAGE_UPDATE       = 'isometriks_symedit.page.update';
    const PAGE_POST_UPDATE  = 'isometriks_symedit.page.post_update';

    const PAGE_PRE_DELETE   = 'isometriks_symedit.page.pre_delete';
    const PAGE_DELETE       = 'isometriks_symedit.page.delete';
    const PAGE_POST_DELETE  = 'isometriks_symedit.page.post_delete';

    const PAGE_VIEW         = 'isometriks_symedit.page.view';

    /**
     * Post Events
     */
    const POST_PRE_CREATE   = 'isometriks_symedit.post.pre_create';
    const POST_CREATE       = 'isometriks_symedit.post.create';
    const POST_POST_CREATE  = 'isometriks_symedit.post.post_create';

    const POST_PRE_UPDATE   = 'isometriks_symedit.post.pre_update';
    const POST_UPDATE       = 'isometriks_symedit.post.update';
    const POST_POST_UPDATE  = 'isometriks_symedit.post_post_update';

    const POST_VIEW         = 'isometriks_symedit.post.view';

    /**
     * Menu Events
     */
    const MENU_VIEW    = 'isometriks_symedit.menu.view';
}