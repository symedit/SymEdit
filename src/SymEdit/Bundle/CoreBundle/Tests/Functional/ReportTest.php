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

use SymEdit\Bundle\AnalyticsBundle\Report\Reporter;
use SymEdit\Bundle\CoreBundle\Tests\WebTestCase;

class ReportTest extends WebTestCase
{
    protected $reporter;

    /**
     * @return Reporter
     */
    protected function getReporter()
    {
        return static::createClient()->getContainer()->get('symedit_analytics.reporter');
    }

    /**
     * @dataProvider fixtureReportProvider
     */
    public function testReports($reportName, $options = array())
    {
        $this->getReporter()->runReport($reportName, $options);
    }

    /**
     * arg1 - Report Name
     * arg2 - Report Options
     *
     * @return array
     */
    public function fixtureReportProvider()
    {
        return array(
            array('popular_pages'),
            array('popular_posts'),
            array('popular', array('model' => 'page')),
            array('popular', array('model' => 'post')),
        );
    }
}
