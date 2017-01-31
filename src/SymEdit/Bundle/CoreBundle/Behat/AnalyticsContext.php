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

use SymEdit\Bundle\AnalyticsBundle\Analytics\Tracker;
use SymEdit\Bundle\ResourceBundle\Behat\DefaultContext;

class AnalyticsContext extends DefaultContext
{
    /**
     * @Then /^I should have a tracked (.+)$/
     */
    public function iShouldHaveATrackedObject($modelName)
    {
        foreach ($this->getTracker()->getTrackedVisits() as $visit) {
            if ($visit->getModel() === $modelName) {
                return;
            }
        }

        throw new \Exception(sprintf('No tracking for a %s object', $modelName));
    }

    /**
     * @Then /^I should not have a tracked (.+)$/
     */
    public function iShouldNotHaveATrackedObject($modelName)
    {
        foreach ($this->getTracker()->getTrackedVisits() as $visit) {
            if ($visit->getModel() === $modelName) {
                throw new \Exception(sprintf('There is tracking for %s object', $modelName));
            }
        }
    }

    /**
     * @return Tracker
     */
    protected function getTracker()
    {
        return $this->getContainer()->get('symedit_analytics.tracker');
    }
}
