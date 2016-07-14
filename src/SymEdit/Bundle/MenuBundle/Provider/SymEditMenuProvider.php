<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MenuBundle\Provider;

use Knp\Menu\MenuFactory;
use Knp\Menu\Provider\MenuProviderInterface;
use SymEdit\Bundle\MenuBundle\Extension\MenuExtensionInterface;
use SymEdit\Bundle\MenuBundle\Model\Menu;
use SymEdit\Bundle\MenuBundle\Model\MenuBuilderInterface;

class SymEditMenuProvider implements MenuProviderInterface
{
    protected $factory;
    protected $builders;
    protected $extensions;

    public function __construct(MenuFactory $factory, array $builders = [], array $extensions = [])
    {
        $this->factory = $factory;
        $this->builders = $builders;
        $this->extensions = $extensions;
    }

    public function get($name, array $options = [])
    {
        // Create a root node
        $rootOptions = isset($options['root_options']) ? $options['root_options'] : [];
        $menu = new Menu($this->factory->createItem('root', $rootOptions), $name);

        // Run all of the other builders to build on the root node
        foreach ($this->builders[$name] as $builder) {
            if (!$builder instanceof MenuBuilderInterface) {
                throw new \RuntimeException(sprintf('"%s" does not implement MenuBuilderInterface', get_class($builder)));
            }

            $builder->buildMenu($menu, $options);
        }

        // Run extensions
        foreach ($this->extensions as $extension) {
            if (!$extension instanceof MenuExtensionInterface) {
                throw new \RuntimeException(sprintf('"%s" does not implement MenuExtensionInterface', get_class($builder)));
            }

            $extension->modifyMenu($menu, $options);
        }

        return $menu->getRootNode();
    }

    public function has($name, array $options = [])
    {
        return array_key_exists($name, $this->builders);
    }
}
