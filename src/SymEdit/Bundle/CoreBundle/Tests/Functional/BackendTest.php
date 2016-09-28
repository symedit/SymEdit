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
            $this->client = static::createClient([], [
                'PHP_AUTH_USER' => 'admin',
                'PHP_AUTH_PW' => 'test',
            ]);

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
        return [
            ['/'],

            ['/user'],
            ['/user/new'],

            ['/post'],
            ['/post/new'],

            ['/image'],
            ['/image/new'],
            ['/image/gallery'],
            ['/image/gallery/new'],

            ['/file'],
            ['/file/new'],

            ['/widget'],
            ['/widget/new'],

            ['/category'],
            ['/category/new'],

            ['/events'],
            ['/events/new'],

            ['/settings'],

            ['/stylizer'],

            // Profile
            ['/profile', false],
            ['/profile/change-password', false],
        ];
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
        return [
            ['blog_recent_posts'],
            ['blog_latest_post'],
            ['blog_popular_posts'],
            ['blog_categories'],
            ['html'],
            ['template'],
            ['disqus'],
            ['addthis'],
            ['contact_info'],
            ['google_map'],
            ['submenu'],
            ['list_children'],
            ['slider'],
            ['gallery'],
            ['mailchimp_subscribe'],
        ];
    }
}
