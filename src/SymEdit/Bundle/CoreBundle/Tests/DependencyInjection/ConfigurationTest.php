<?php

namespace SymEdit\Bundle\CoreBundle\Tests\DependencyInjection;

use SymEdit\Bundle\CoreBundle\DependencyInjection\Configuration;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), array());

        $this->assertEquals(
            self::getBundleDefaultConfig(),
            $config
        );
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidDriver()
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $processor->processConfiguration($configuration, array(
            'driver' => 'some/other/driver',
        ));
    }

    public function testExtensions()
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, array(array(
            'extensions' => array(
                array(
                    'route' => 'test_route',
                    'label' => 'Foo Extension',
                    'icon' => 'bar',
                )
            )
        )));

        $this->assertEquals(
            array(
                array(
                    'route' => 'test_route',
                    'label' => 'Foo Extension',
                    'role' => 'ROLE_ADMIN',
                    'icon' => 'bar',
                )
            ),
            $config['extensions']
        );
    }

    protected static function getBundleDefaultConfig()
    {
        return array(
            'driver' => 'doctrine/orm',
            'extensions' => array(),
            'email' => array(
                'sender' => 'email@example.com',
            ),
            'template_locations' => array(),
            'assets' => array(
                'javascripts' => array(),
                'stylesheets' => array(),
            ),
            'classes' => array(
                'page' => array(
                    'model' => 'SymEdit\Bundle\CoreBundle\Model\Page',
                    'controller' => 'SymEdit\Bundle\CoreBundle\Controller\PageController',
                    'form' => 'SymEdit\Bundle\CoreBundle\Form\Type\PageType',
                ),
                'breadcrumbs' => array(
                    'model' => 'SymEdit\Bundle\CoreBundle\Model\Breadcrumbs',
                ),
                'contact' => array(
                    'controller' => 'SymEdit\Bundle\CoreBundle\Controller\ContactController',
                    'form' => 'SymEdit\Bundle\CoreBundle\Form\Type\ContactType',
                ),
            ),
        );
    }
}