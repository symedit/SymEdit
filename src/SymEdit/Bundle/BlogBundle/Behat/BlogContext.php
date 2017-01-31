<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\BlogBundle\Behat;

use SymEdit\Bundle\ResourceBundle\Behat\DefaultContext;

class BlogContext extends DefaultContext
{
    /**
     * @Given I am on the blog index
     */
    public function iAmOnTheBlogIndex()
    {
        $this->visitPath($this->generateUrl('blog'));
    }

    /**
     * @Then I should see :num recent posts
     */
    public function iShouldSeeRecentPosts($num)
    {
        // Check num
    }
}
