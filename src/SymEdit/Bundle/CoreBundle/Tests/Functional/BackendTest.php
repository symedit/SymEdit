<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\Functional;

use SymEdit\Bundle\CoreBundle\Tests\WebTestCase;

class BackendTest extends WebTestCase
{
    protected $client;

    protected function getClient()
    {
        if ($this->client === null) {
            $this->client = static::createClient(array(), array(
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW'   => 'test',
            ));

            $this->client->followRedirects();
        }

        return $this->client;
    }

    /**
     * @dataProvider fixtureUrlProvider
     */
    public function testPages($url, $admin = true)
    {
        $prefix = $admin ? '/sym-admin' : '';

        $client = $this->getClient();
        $client->request('GET', $prefix.$url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function fixtureUrlProvider()
    {
        return array(
            array('/'),

            array('/user'),
            array('/user/new'),

            array('/page'),
            array('/page/new'),

            array('/post'),
            array('/post/new'),

            array('/image'),
            array('/image/new'),
            array('/image/gallery'),
            array('/image/gallery/new'),

            array('/file'),
            array('/file/new'),

            array('/widget'),
            array('/widget/new'),

            array('/category'),
            array('/category/new'),

            array('/events'),
            array('/events/new'),

            array('/settings'),

            array('/stylizer'),

            // Profile
            array('/profile', false),
            array('/profile/change-password', false),
        );
    }

    /**
     * @dataProvider fixtureWidgetProvider
     */
    public function testWidgets($widgetName)
    {
        $client = $this->getClient();
        $client->request('GET', sprintf('/sym-admin/widget/new/%s', $widgetName));
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function fixtureWidgetProvider()
    {
        return array(
            array('blog_recent_posts'),
            array('blog_latest_post'),
            array('blog_popular_posts'),
            array('blog_categories'),
            array('html'),
            array('template'),
            array('disqus'),
            array('addthis'),
            array('contact_info'),
            array('google_map'),
            array('submenu'),
            array('list_children'),
            array('slider'),
            array('gallery'),
            array('mailchimp_subscribe'),
        );
    }
}
