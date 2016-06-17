<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Tests\DependencyInjection;

use SymEdit\Bundle\CoreBundle\DependencyInjection\Configuration;
use SymEdit\Bundle\CoreBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfig()
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), []);

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
        $processor->processConfiguration($configuration, [
            'driver' => 'some/other/driver',
        ]);
    }

    public function testExtensions()
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, [[
            'extensions' => [
                [
                    'route' => 'test_route',
                    'label' => 'Foo Extension',
                    'icon' => 'bar',
                ],
            ],
        ]]);

        $this->assertEquals(
            [
                [
                    'route' => 'test_route',
                    'label' => 'Foo Extension',
                    'role' => 'ROLE_ADMIN',
                    'icon' => 'bar',
                ],
            ],
            $config['extensions']
        );
    }

    protected static function getBundleDefaultConfig()
    {
        return [
            'driver' => 'doctrine/orm',
            'extensions' => [],
            'email' => [
                'sender' => 'email@example.com',
            ],
            'template_locations' => [],
            'assets' => [
                'javascripts' => [],
                'stylesheets' => [],
            ],
            'classes' => [
                'page' => [
                    'model' => 'SymEdit\Bundle\CoreBundle\Model\Page',
                    'controller' => 'SymEdit\Bundle\CoreBundle\Controller\PageController',
                    'form' => [
                        'default' => 'SymEdit\Bundle\CoreBundle\Form\Type\PageType',
                        'choose' => 'SymEdit\Bundle\CoreBundle\Form\Type\PageChooseType',
                    ],
                ],
                'role' => [
                    'model' => 'SymEdit\Bundle\CoreBundle\Model\Role',
                ],
                'breadcrumbs' => [
                    'model' => 'SymEdit\Bundle\CoreBundle\Model\Breadcrumbs',
                ],
                'contact' => [
                    'controller' => 'SymEdit\Bundle\CoreBundle\Controller\ContactController',
                    'form' => 'SymEdit\Bundle\CoreBundle\Form\Type\ContactType',
                ],
            ],
            'routing' => [
                'route_uri_filter_regexp' => '',
            ],
        ];
    }
}
