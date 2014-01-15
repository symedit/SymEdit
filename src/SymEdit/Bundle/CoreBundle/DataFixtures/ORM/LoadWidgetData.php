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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use SymEdit\Bundle\CoreBundle\Model\Widget;

class LoadWidgetData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /**
         * Create sidebar
         */
        $sidebar = $this->getWidgetAreaRepository()->createNew();
        $sidebar->setArea('sidebar');
        $sidebar->setDescription('Sidebar Widget Area');

        /**
         * Fetch Blog Page
         */
        $blog = $this->getReference('page-blog');

        /**
         * Add Categories to Blog
         */
        $categories = $this->getWidgetRepository()->createNew('blog_categories');
        $categories->setName('blog_categories')
                   ->setTitle('Blog Categories')
                   ->setVisibility(Widget::INCLUDE_ONLY)
                   ->addAssoc($blog->getId());

        /**
         * Add Recent Posts to Blog
         */
        $recent = $this->getWidgetRepository()->createNew('blog_recent_posts');
        $recent->setName('blog_recent_posts')
               ->setTitle('Recent Posts')
               ->setVisibility(Widget::INCLUDE_ONLY)
               ->addAssoc($blog->getId());

        /**
         * Add Widgets to Sidebar
         */
        $sidebar->addWidget($categories);
        $sidebar->addWidget($recent);

        $manager->persist($sidebar);

        $this->addReference('widgetarea-sidebar', $sidebar);
        $this->addReference('widget-blog-categories', $categories);
        $this->addReference('widget-blog-recent-posts', $recent);


        /**
         * Add Featured Area
         */
        $featured = $this->getWidgetAreaRepository->createNew();
        $featured
            ->setArea('featured')
            ->setDescription('Featured Widget Area at top of page');

        $slider = $this->getWidgetRepository()->createNew('slider');
        $slider
            ->setName('homepage_slider')
            ->setTitle('Homepage Slider')
            ->setOption('slider', 'homepage')
            ->setVisibility(Widget::INCLUDE_ONLY)
            ->addAssoc('/');

        // Google Map for Contact Page
        $contact_page = $this->getReference('page-contact');

        $map = $this->getWidgetRepository()->createNew('google_map');
        $map
            ->setName('google_map_featured')
            ->setVisibility(Widget::INCLUDE_ONLY)
            ->addAssoc($contact_page->getId());


        $featured->addWidget($slider);
        $featured->addWidget($map);

        $manager->persist($featured);

        $this->addReference('widgetarea-featured', $featured);
        $this->addReference('widget-homepage_slider', $slider);
        $this->addReference('widget-google_map_featured', $map);


        /**
         * Add Supplemental Area
         */
        $supplemental = $this->getWidgetAreaRepository()->createNew();
        $supplemental
            ->setArea('supplemental')
            ->setDescription('Widget area following the content region');

        $manager->persist($supplemental);

        $this->addReference('widgetarea-supplemental', $supplemental);

        /**
         * Add Footer Area
         */
        $footer = $this->getWidgetAreaRepository()->createNew();
        $footer->setArea('footer');
        $footer->setDescription('Footer Widget Area');

        $contact = $this->getWidgetRepository()->createNew('contact_info');
        $contact->setName('contact_info')
                ->setTitle('Contact Information')
                ->setVisibility(Widget::INCLUDE_ALL);

        $about = $this->getWidgetRepository()->createNew('html');
        $about->setName('about')
              ->setTitle('About Us')
              ->setVisibility(Widget::INCLUDE_ALL)
              ->setOption('html', '<p>This is all about our company...</p>');

        /**
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

    protected function getWidgetRepository()
    {
        return $this->container->get('symedit.repository.widget');
    }

    protected function getWidgetAreaRepository()
    {
        return $this->container->get('symedit.repository.widget_area');
    }

    public function getOrder()
    {
        return 25;
    }
}