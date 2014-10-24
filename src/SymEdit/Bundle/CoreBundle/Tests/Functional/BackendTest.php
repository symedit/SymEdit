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
    /**
     * @dataProvider fixtureUrlProvider
     */
    public function testPages($url)
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'test',
        ));
        $client->followRedirects();

        $crawler = $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function fixtureUrlProvider()
    {
        return array(
            array('/sym-admin'),
            array('/sym-admin/settings'),
            array('/sym-admin/user'),
            array('/sym-admin/post'),
            array('/sym-admin/category'),
            array('/sym-admin/image'),
        );
    }
}
