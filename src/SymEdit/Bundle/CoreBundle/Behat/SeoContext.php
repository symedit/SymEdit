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

class SeoContext extends DefaultContext
{
    /**
     * @Then I should see a meta description with :description
     */
    public function iShouldHaveAMetaDescriptionOf($description)
    {
        $descriptionValue = $this->getSession()->getPage()->find('css', 'meta[name=description]')->getAttribute('content');

        if ($description !== $descriptionValue) {
            throw new \Exception(sprintf('Invalid Meta Description "%s" !== "%s"', $description, $descriptionValue));
        }
    }
}
