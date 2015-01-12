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
    public function testPages($url)
    {
        $client = $this->getClient();
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function fixtureUrlProvider()
    {
        return array(
            array('/sym-admin'),

            array('/sym-admin/user'),
            array('/sym-admin/user/new'),

            array('/sym-admin/page'),
            array('/sym-admin/page/new'),

            array('/sym-admin/post'),
            array('/sym-admin/post/new'),

            array('/sym-admin/image'),
            array('/sym-admin/image/new'),
            array('/sym-admin/image/gallery'),
            array('/sym-admin/image/gallery/new'),

            array('/sym-admin/file'),
            array('/sym-admin/file/new'),

            array('/sym-admin/widget'),
            array('/sym-admin/widget/new'),

            array('/sym-admin/settings'),
            array('/sym-admin/category'),
            array('/sym-admin/category/new'),
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
