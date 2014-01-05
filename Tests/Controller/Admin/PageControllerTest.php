<?php

namespace Isometriks\Bundle\SymEditBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Tests\Functional\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/sym-admin/page/');
        $this->assertGreaterThan(0, $crawler->filter('html:contains("Showing Pages")')->count());
    }
}