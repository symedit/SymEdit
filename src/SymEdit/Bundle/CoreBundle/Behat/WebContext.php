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

use SymEdit\Bundle\ResourceBundle\Behat\DefaultContext;

class WebContext extends DefaultContext
{
    /**
     * @Given /^I am on the (.+) page$/
     * @When /^I go to the (.+) page$/
     */
    public function iAmOnThePage($page)
    {
        $this->getSession()->visit($this->generatePageUrl($page));
    }

    /**
     * @Then /^I should be on the (.+) page$/
     */
    public function iShouldBeOnThePage($page)
    {
        $this->assertSession()->addressEquals($this->generatePageUrl($page));
    }

    /**
     * @Given website has default configuration
     */
    public function websiteHasDefaultConfiguration()
    {
        // Setup later
    }

    /**
     * @Then I should see a title tag with :title
     */
    public function iShouldSeeATitleTagWith($title)
    {
        $titleValue = $this->getSession()->getPage()->find('css', 'title')->getText();

        if ($title !== $titleValue) {
            throw new \Exception(sprintf('Title should be "%s" got "%s"', $title, $titleValue));
        }
    }


    /**
     * @Given I am logged in as admin
     */
    public function iAmLoggedInAsAdmin()
    {
        $this->getSession()->visit($this->generatePageUrl('fos_user_security_login'));
        $page = $this->getSession()->getPage();

        $page->fillField('username', 'admin');
        $page->fillField('password', 'test');
        $page->pressButton('Log in');
    }

    /**
     * For example: I should see 10 products in that list.
     *
     * @Then /^I should see (\d+) ([^""]*) in (?:that|the) list$/
     */
    public function iShouldSeeThatMuchResourcesInTheList($amount, $type)
    {
        if (1 === count($this->getSession()->getPage()->findAll('css', 'table'))) {
            $this->assertSession()->elementsCount('css', 'table tbody > tr', $amount);
        } else {
            $selector = $type === 'page' ? '#page-tree li' : sprintf('table#%s tbody > tr', str_replace(' ', '-', $type));

            $this->assertSession()->elementsCount(
                'css',
                $selector,
                $amount
            );
        }
    }

    /**
     * @Then /^I should have a ([^""]+) resource with ([^""]+) "(.+)"$/
     */
    public function iShouldHaveAResourceWithProperty($type, $property, $value)
    {
        $this->findOneBy($type, [
            $property => $value,
        ]);
    }

    /**
     * @When /^I go to the website root$/
     */
    public function iGoToTheWebsiteRoot()
    {
        $this->getSession()->visit('/');
    }
}
