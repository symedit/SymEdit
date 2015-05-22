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

class SitemapTest extends WebTestCase
{
    public function testEntries()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sitemap.xml');

        $urls = array(
            '/',
            '/about',
            '/blog/',
            '/events/',
            '/contact',
            '/blog/hello-world',
            '/blog/category/general',
        );

        $foundUrls = array();

        foreach ($crawler->filter('url > loc') as $node) {
            $foundUrls[] = parse_url($node->nodeValue, PHP_URL_PATH);
        }

        $this->assertEquals($urls, $foundUrls);
    }
}
