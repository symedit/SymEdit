<?php

namespace Isometriks\Bundle\SymEditBundle\Menu\Provider;

use Knp\Menu\Provider\MenuProviderInterface;
use Isometriks\Bundle\SymEditBundle\Model\PageManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;

class TreeMenuProvider implements MenuProviderInterface
{
    protected $pageManager;
    protected $factory;

    public function __construct(FactoryInterface $factory, PageManagerInterface $pageManager)
    {
        $this->factory = $factory;
        $this->pageManager = $pageManager;
    }

    public function get($name, array $options = array())
    {
        $root = $this->pageManager->findRoot();
        $menu = $this->factory->createItem('root');

        $this->populateChildren($menu, $root->getChildren());

        return $menu;
    }

    /**
     *
     * @param \Knp\Menu\NodeInterface $node
     * @param \Isometriks\Bundle\SymEditBundle\Model\PageInterface $children
     */
    protected function populateChildren(MenuItem $menu, $children)
    {
        foreach($children as $child) {
            if(!$child->getDisplay()) {
                continue;
            }

            $item = $this->factory->createItem($child->getTitle(), array(
                'route' => $child->getRoute(),
            ));

            // Store Page ID
            $item->setExtra('_page_id', $child->getId());

            $menu->addChild($item);

            $this->populateChildren($item, $child->getChildren());
        }
    }

    public function has($name, array $options = array())
    {
        return strtolower($name) === 'tree';
    }
}