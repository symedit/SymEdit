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

class FrontendTest extends WebTestCase
{
    /**
     * @dataProvider fixtureUrlProvider
     */
    public function testPages($url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function fixtureUrlProvider()
    {
        return [
            ['/'],                         // Home
            ['/about'],                    // About
            ['/events/'],                  // Events
            ['/blog/'],                    // Blog
            ['/blog/hello-world'],         //  - Hello World
            ['/blog/category/general'],    //  - Category: General
            ['/sitemap.xml'],
            ['/robots.txt'],
        ];
    }
}
