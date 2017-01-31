<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\WidgetBundle\Behat;

use SymEdit\Bundle\ResourceBundle\Behat\DefaultContext;

class WidgetContext extends DefaultContext
{
    /**
     * @Given I am on the blog index
     */
    public function iAmOnTheBlogIndex()
    {
        $this->visitPath($this->generateUrl('blog'));
    }

    /**
     * For example: I should see 10 products in that list.
     *
     * @Then /^I should see (\d+) widgets? in the ([^""]*) area$/
     */
    public function iShouldSeeThatMuchResourcesInTheList($amount, $area)
    {
        $this->assertSession()->elementsCount(
            'css',
            sprintf('table#widgets-%s tbody > tr', $area),
            $amount
        );
    }
}
