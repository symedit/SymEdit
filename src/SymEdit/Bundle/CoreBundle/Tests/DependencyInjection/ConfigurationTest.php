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

use Sylius\Component\Resource\Factory\Factory;
use SymEdit\Bundle\CoreBundle\Controller\PageController;
use SymEdit\Bundle\CoreBundle\DependencyInjection\Configuration;
use SymEdit\Bundle\CoreBundle\Form\Type\PageType;
use SymEdit\Bundle\CoreBundle\Model\Page;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use SymEdit\Bundle\CoreBundle\Model\Role;
use SymEdit\Bundle\CoreBundle\Model\RoleInterface;
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
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidDriver()
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $processor->processConfiguration($configuration, [
            'driver' => 'some/other/driver',
        ]);
    }

    protected static function getBundleDefaultConfig()
    {
        return [
            'driver' => 'doctrine/orm',
            'email' => [
                'sender' => 'email@example.com',
            ],
            'template_locations' => [],
            'assets' => [
                'javascripts' => [],
                'stylesheets' => [],
            ],
            'resources' => [
                'page' => [
                    'classes' => [
                        'model' => Page::class,
                        'interface' => PageInterface::class,
                        'controller' => PageController::class,
                        'form' => PageType::class,
                        'factory' => Factory::class,
                    ],
                ],
                'role' => [
                    'classes' => [
                        'model' => Role::class,
                        'interface' => RoleInterface::class,
                        'factory' => Factory::class,
                    ],
                ],
            ],
        ];
    }
}
