<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\SettingsBundle\Tests\Loader;

use SymEdit\Bundle\SettingsBundle\Loader\SettingsConfiguration;
use SymEdit\Bundle\SettingsBundle\Tests\TestCase;
use Symfony\Component\Config\Definition\Processor;

class SettingsConfigurationTest extends TestCase
{
    public function testBasicConfiguration()
    {
        $config = array(
            'group1' => array(
                'label' => 'group 1',
                'role' => 'ROLE_ADMIN',
                'default_options' => array(
                    'required' => false,
                ),
                'settings' => array(
                    'group1setting1' => array(
                        'type' => 'choice',
                        'default' => 0,
                        'options' => array(
                            'choices' => array(
                                'Yes', 'No',
                            ),
                        ),
                    )
                )
            ),
            'group2' => array(
                'label' => 'group 2',
                'settings' => array(
                    'group2setting1' => array(
                        'default' => 'Some Text',
                    ),
                )
            ),
        );

        $processor = new Processor();
        $configuration = new SettingsConfiguration();
        $processed = $processor->processConfiguration($configuration, array($config));

        $this->assertEquals('group 1', $processed['group1']['label']);
        $this->assertEquals('choice', $processed['group1']['settings']['group1setting1']['type']);
        $this->assertEquals('text', $processed['group2']['settings']['group2setting1']['type']);
    }

    public function testCombinedGroups()
    {
        $config1 = array(
            'group1' => array(
                'label' => 'First Label',
                'settings' => array(
                    'group1setting1' => array(
                        'default' => 'Some Text',
                    ),
                ),
            ),
        );

        $config2 = array(
            'group1' => array(
                'label' => 'Second Label',
                'settings' => array(
                    'group1setting2' => array(
                        'default' => 'Some Text 2',
                    ),
                ),
            ),
        );

        $processor = new Processor();
        $configuration = new SettingsConfiguration();
        $processed = $processor->processConfiguration($configuration, array($config1, $config2));

        $this->assertEquals(1, count($processed));
        $this->assertEquals('Second Label', $processed['group1']['label']);
        $this->assertArrayHasKey('group1setting2', $processed['group1']['settings']);
    }
}