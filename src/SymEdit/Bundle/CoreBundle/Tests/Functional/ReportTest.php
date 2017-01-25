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

use SymEdit\Bundle\AnalyticsBundle\Report\ReporterInterface;
use SymEdit\Bundle\CoreBundle\Tests\WebTestCase;

class ReportTest extends WebTestCase
{
    protected $reporter;

    /**
     * @return ReporterInterface
     */
    protected function getReporter()
    {
        return static::createClient()->getContainer()->get('symedit_analytics.reporter');
    }

    /**
     * @dataProvider fixtureReportProvider
     */
    public function testReports($reportName, $options = [])
    {
        $this->getReporter()->runReport($reportName, $options);
    }

    /**
     * arg1 - Report Name
     * arg2 - Report Options.
     *
     * @return array
     */
    public function fixtureReportProvider()
    {
        return [
            ['popular_pages'],
            ['popular_posts'],
            ['popular', ['model' => 'page']],
            ['popular', ['model' => 'post']],
        ];
    }
}
