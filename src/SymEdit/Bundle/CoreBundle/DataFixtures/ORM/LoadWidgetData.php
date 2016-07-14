<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SymEdit\Bundle\CoreBundle\DataFixtures\AbstractFixture;
use SymEdit\Bundle\WidgetBundle\Model\WidgetAreaInterface;
use SymEdit\Bundle\WidgetBundle\Model\WidgetInterface;

class LoadWidgetData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /*
         * Create sidebar
         */
        $sidebar = $this->createWidgetArea();
        $sidebar->setArea('sidebar');
        $sidebar->setDescription('Sidebar Widget Area');

        /*
         * Fetch Blog Page
         */
        $blog = $this->getReference('page-blog');

        /*
         * Add Categories to Blog
         */
        $categories = $this->createWidget('blog_categories');
        $categories->setName('blog_categories')
                   ->setTitle('Blog Categories')
                   ->setVisibility(WidgetInterface::INCLUDE_ONLY)
                   ->addAssoc($blog->getId());

        /*
         * Add Recent Posts to Blog
         */
        $recent = $this->createWidget('blog_recent_posts');
        $recent->setName('blog_recent_posts')
               ->setTitle('Recent Posts')
               ->setVisibility(WidgetInterface::INCLUDE_ONLY)
               ->addAssoc($blog->getId());

        /*
         * Add Widgets to Sidebar
         */
        $sidebar->addWidget($categories);
        $sidebar->addWidget($recent);

        $manager->persist($sidebar);

        $this->addReference('widgetarea-sidebar', $sidebar);
        $this->addReference('widget-blog-categories', $categories);
        $this->addReference('widget-blog-recent-posts', $recent);

        /*
         * Add Featured Area
         */
        $featured = $this->createWidgetArea();
        $featured
            ->setArea('featured')
            ->setDescription('Featured Widget Area at top of page');

        // Google Map for Contact Page
        $contact_page = $this->getReference('page-contact');

        $map = $this->createWidget('google_map');
        $map
            ->setName('google_map_featured')
            ->setVisibility(WidgetInterface::INCLUDE_ONLY)
            ->addAssoc($contact_page->getId());

        $featured->addWidget($map);

        $manager->persist($featured);

        $this->addReference('widgetarea-featured', $featured);
        $this->addReference('widget-google_map_featured', $map);

        /*
         * Add Supplemental Area
         */
        $supplemental = $this->createWidgetArea();
        $supplemental
            ->setArea('supplemental')
            ->setDescription('Widget area following the content region');

        $manager->persist($supplemental);

        /*
         * Add Contact Page Info Widget
         */
        $contactInfo = $this->createWidget('template');
        $contactInfo
            ->setName('contact_page_info')
            ->setTitle('Our Contact Details')
            ->setVisibility(WidgetInterface::INCLUDE_ONLY)
            ->setOption('template', '@SymEdit/Widget/contact-page-info.html.twig')
            ->addAssoc($contact_page->getId())
        ;

        // Add widget to area
        $supplemental->addWidget($contactInfo);

        /*
         * Add Widget to Contact Page
         */
        $formBuilder = $this->getReference('form_builder-contact');
        $contactFormWidget = $this->createWidget('form_builder')
            ->setName('contact-us-form')
            ->setTitle('Send us a message')
            ->setOptions([
                'form_builder_id' => $formBuilder->getId(),
                'template' => '@SymEdit/Widget/FormBuilder/contact.html.twig',
            ])
            ->setVisibility(WidgetInterface::INCLUDE_ONLY)
            ->addAssoc($contact_page->getId())
        ;

        // Add widget to area
        $supplemental->addWidget($contactFormWidget);

        $this->addReference('widgetarea-supplemental', $supplemental);

        /*
         * Add Footer Area
         */
        $footer = $this->createWidgetArea();
        $footer->setArea('footer');
        $footer->setDescription('Footer Widget Area');

        $contact = $this->createWidget('contact_info');
        $contact->setName('contact_info')
                ->setTitle('Contact Information')
                ->setVisibility(WidgetInterface::INCLUDE_ALL);

        $about = $this->createWidget('html');
        $about->setName('about')
              ->setTitle('About Us')
              ->setVisibility(WidgetInterface::INCLUDE_ALL)
              ->setOption('html', '<p>This is all about our company...</p>');

        /*
         * Add Widgets to footer
         */
        $footer->addWidget($contact);
        $footer->addWidget($about);

        $manager->persist($footer);

        $this->addReference('widgetarea-footer', $footer);
        $this->addReference('widget-contact_info', $contact);
        $this->addReference('widget-about', $about);

        $manager->flush();
    }

    /**
     * @param string $strategy
     *
     * @return WidgetInterface
     */
    protected function createWidget($strategy)
    {
        return $this->getFactory('widget')->createFromStrategy($strategy);
    }

    /**
     * @return WidgetAreaInterface
     */
    protected function createWidgetArea()
    {
        return $this->getFactory('widget_area')->createNew();
    }

    public function getOrder()
    {
        return 30;
    }
}
