<?php

namespace SymEdit\Bundle\CoreBundle\Tests\Controller;

use SymEdit\Bundle\CoreBundle\Tests\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
