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

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Root Node
        $page_root = $this->createPage();
        $page_root
            ->setRoot(true)
            ->setName(null)
            ->setTagline('')
            ->setSummary('')
            ->setTitle('Root')
            ->setContent('')
            ->setDisplay(true)
            ->setCrawl(true)
            ->setPageController(false)
        ;

        $manager->persist($page_root);
        $this->addReference('page-root', $page_root);

        // Homepage
        $page_home = $this->createPage();
        $page_home
            ->setHomepage(true)
            ->setParent($page_root)
            ->setTemplate('home.html.twig')
            ->setName('')
            ->setTagline('Welcome to My Wonderful Website!')
            ->setTitle('Home')
            ->setContent('<p>Welcome to SymEdit</p>')
        ;

        $manager->persist($page_home);
        $this->addReference('page-homepage', $page_home);

        // About Page
        $page_about = $this->createPage();
        $page_about
            ->setParent($page_root)
            ->setTemplate('base.html.twig')
            ->setName('about')
            ->setTagline('About My Website')
            ->setTitle('About')
            ->setContent('<p>Here is some information about my website</p>')
        ;

        $manager->persist($page_about);
        $this->addReference('page-about', $page_about);

        // Blog Page
        $page_blog = $this->createPage();
        $page_blog
            ->setParent($page_root)
            ->setName('blog')
            ->setTagline('My Blog')
            ->setTitle('Blog')
            ->setContent('')
            ->setPageController(true)
            ->setPageControllerPath('symedit_blog')
        ;

        $manager->persist($page_blog);
        $this->addReference('page-blog', $page_blog);

        // Events Page
        $page_events = $this->createPage();
        $page_events
            ->setParent($page_root)
            ->setName('events')
            ->setTagline('Upcoming Events')
            ->setTitle('Events')
            ->setContent('')
            ->setPageController(true)
            ->setPageControllerPath('symedit_events')
        ;

        $manager->persist($page_events);
        $this->addReference('page-events', $page_events);

        $page_contact = $this->createPage();
        $page_contact
            ->setParent($page_root)
            ->setName('contact')
            ->setTagline('Contact Us Now!')
            ->setTitle('Contact')
            ->setContent('')
            ->setPageController(true)
            ->setPageControllerPath('symedit_contact')
        ;

        $manager->persist($page_contact);
        $this->addReference('page-contact', $page_contact);

        // Write them all
        $manager->flush();
    }

    protected function createPage()
    {
        return $this->container->get('symedit.repository.page')->createNew();
    }

    public function getOrder()
    {
        return 5;
    }
}
