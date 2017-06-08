<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\StylizerBundle\DependencyInjection;

use SymEdit\Bundle\StylizerBundle\Form\Type\ColorType;
use SymEdit\Bundle\StylizerBundle\Form\Type\GoogleFontType;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('symedit_stylizer');

        $rootNode
            ->children()
                ->scalarNode('storage')->defaultValue('symedit_stylizer.storage.yaml')->end()
                ->arrayNode('form_mappings')
                    ->prototype('scalar')->end()
                    ->defaultValue([
                        'text' => TextType::class,
                        'textarea' => TextareaType::class,
                        'color' => ColorType::class,
                        'integer' => IntegerType::class,
                        'choice' => ChoiceType::class,
                        'google_font' => GoogleFontType::class,
                    ])
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
