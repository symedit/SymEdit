<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Behat;

use Behat\Gherkin\Node\PyStringNode;
use SymEdit\Bundle\ResourceBundle\Behat\DefaultContext;
use Symfony\Component\DomCrawler\Crawler;

class SitemapContext extends DefaultContext
{
    /**
     * @Then the sitemap should have urls:
     */
    public function theSitemapShouldHaveUrls(PyStringNode $string)
    {
        $xml = $this->getSession()->getPage()->getContent();
        $crawler = new Crawler($xml);
        $assertUrls = explode("\n", $string->getRaw());
        $foundUrls = [];

        foreach ($crawler->filter('url > loc') as $node) {
            $foundUrls[] = parse_url($node->nodeValue, PHP_URL_PATH);
        }

        if (count($diff = array_diff($assertUrls, $foundUrls)) > 0) {
            throw new \InvalidArgumentException(sprintf(
                'Sitemap returned a difference: %s',
                 json_encode(array_values($diff))
            ));
        }
    }
}
