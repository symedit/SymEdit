<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SeoBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use SymEdit\Bundle\SeoBundle\Annotation\Seo;
use SymEdit\Bundle\SeoBundle\Model\SeoInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Checks to see if you added an SEO annotation to set the currrent SEO subject.
 *
 * Some code from https://github.com/sensiolabs/SensioFrameworkExtraBundle/blob/master/EventListener/ControllerListener.php
 */
class SubjectAnnotationSubscriber implements EventSubscriberInterface
{
    protected $seoManager;
    protected $reader;
    protected $annotationClass = 'SymEdit\\Bundle\\SeoBundle\\Annotation\\Seo';

    public function __construct(SeoManagerInterface $seoManager, Reader $reader)
    {
        $this->seoManager = $seoManager;
        $this->reader = $reader;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        die('trying..');
        $request = $event->getRequest();
        $seo = $this->seoManager->getSeo();

        if (!is_array($controller = $event->getController())) {
            return;
        }

        $className = class_exists('Doctrine\Common\Util\ClassUtils') ? ClassUtils::getClass($controller[0]) : get_class($controller[0]);
        $object    = new \ReflectionClass($className);
        $method    = $object->getMethod($controller[1]);

        foreach ($this->reader->getMethodAnnotations($method) as $annot) {
            if ($annot instanceof $this->annotationClass) {
                $this->setSubject($seo, $annot, $request);
            }
        }
    }

    protected function setSubject(SeoInterface $seo, Seo $annot, Request $request)
    {
        $subjectName = $annot->getSubject();

        if (!$request->attributes->has($subjectName)) {
            throw new \Exception(sprintf('Could not set Seo subject to "%s", attribute not found.', $subjectName));
        }

        $seo->setSubject($request->attributes->get($subjectName));
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }

}
