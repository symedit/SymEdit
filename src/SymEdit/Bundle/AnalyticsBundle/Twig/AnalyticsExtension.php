<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Twig;

use SymEdit\Bundle\AnalyticsBundle\Analytics\Tracker;
use SymEdit\Bundle\AnalyticsBundle\Exception\InvalidReportException;
use SymEdit\Bundle\AnalyticsBundle\Report\Reporter;

class AnalyticsExtension extends \Twig_Extension
{
    protected $tracker;
    protected $environment;
    protected $reporter;

    public function __construct(Tracker $tracker, Reporter $reporter)
    {
        $this->tracker = $tracker;
        $this->reporter = $reporter;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('symedit_analytics_render', array($this, 'renderAnalytics'), array('needs_environment' => true, 'is_safe' => array('html', 'js'))),
            new \Twig_SimpleFunction('symedit_analytics_report', array($this, 'getReport')),
        );
    }

    public function renderAnalytics(\Twig_Environment $env)
    {
        return $env->render('@SymEditAnalytics/render.html.twig', array(
            'visits' => $this->tracker->getTrackedVisits(),
        ));
    }

    public function getReport($name, array $options = array())
    {
        try {
            $report = $this->reporter->runReport($name, $options);
        } catch (InvalidReportException $exception) {
            return;
        }

        return $report;
    }

    public function getName()
    {
        return 'symedit_analytics';
    }
}
