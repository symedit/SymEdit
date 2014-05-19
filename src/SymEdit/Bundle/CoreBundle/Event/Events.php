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

final class Events
{
    /**
     * Page Events
     */
    const PAGE_PRE_CREATE   = 'symedit.page.pre_create';
    const PAGE_CREATE       = 'symedit.page.create';
    const PAGE_POST_CREATE  = 'symedit.page.post_create';

    const PAGE_PRE_UPDATE   = 'symedit.page.pre_update';
    const PAGE_UPDATE       = 'symedit.page.update';
    const PAGE_POST_UPDATE  = 'symedit.page.post_update';

    const PAGE_PRE_DELETE   = 'symedit.page.pre_delete';
    const PAGE_DELETE       = 'symedit.page.delete';
    const PAGE_POST_DELETE  = 'symedit.page.post_delete';

    const PAGE_VIEW         = 'symedit.page.view';

    /**
     * Post Events
     */
    const POST_PRE_CREATE   = 'symedit.post.pre_create';
    const POST_CREATE       = 'symedit.post.create';
    const POST_POST_CREATE  = 'symedit.post.post_create';

    const POST_PRE_UPDATE   = 'symedit.post.pre_update';
    const POST_UPDATE       = 'symedit.post.update';
    const POST_POST_UPDATE  = 'symedit.post_post_update';

    /**
     * Menu Events
     */
    const MENU_VIEW         = 'symedit.menu.view';

    /**
     * FOS View / Subject Set
     */
    const SUBJECT_SET       = 'symedit.subject.set';
}
