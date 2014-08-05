<?php

namespace SymEdit\Bundle\AnalyticsBundle\Twig;

use SymEdit\Bundle\AnalyticsBundle\Analytics\Tracker;

class AnalyticsExtension extends \Twig_Extension
{
    protected $tracker;
    protected $environment;

    public function __construct(Tracker $tracker)
    {
        $this->tracker = $tracker;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('symedit_analytics_render', array($this, 'renderAnalytics'), array('is_safe' => array('html', 'js'))),
        );
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function renderAnalytics()
    {
        return $this->environment->render('@SymEditAnalytics/render.html.twig', array(
            'visits' => $this->tracker->getTrackedVisits(),
        ));
    }

    public function getName()
    {
        return 'symedit_analytics';
    }
}