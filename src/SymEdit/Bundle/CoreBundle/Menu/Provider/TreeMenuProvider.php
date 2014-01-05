<?php

namespace SymEdit\Bundle\CoreBundle\Menu\Provider;

use SymEdit\Bundle\CoreBundle\Event\Events;
use SymEdit\Bundle\CoreBundle\Event\MenuEvent;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Sylius\Bundle\ResourceBundle\Model\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Knp\Menu\NodeInterface;
use Knp\Menu\Provider\MenuProviderInterface;

class TreeMenuProvider implements MenuProviderInterface
{
    protected $pageRepository;
    protected $factory;
    protected $eventDispatcher;

    public function __construct(FactoryInterface $factory, RepositoryInterface $pageRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->pageRepository = $pageRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function get($name, array $options = array())
    {
        $rootOptions = isset($options['root_options']) ? $options['root_options'] : array();
        $menu = $this->factory->createItem('root', $rootOptions);
        $this->populateChildren($menu, $this->getRoot($options));

        /**
         * Dispatch Menu Event
         */
        $event = new MenuEvent($menu, 'tree');
        $this->eventDispatcher->dispatch(Events::MENU_VIEW, $event);

        return $event->getRootNode();
    }

    /**
     * Gets root elements from options
     *
     * @return PageInterface
     */
    protected function getRoot(array $options)
    {
        if (isset($options['root']) && $options['root'] instanceof PageInterface) {
            $root = $options['root'];
        } else {
            $root = $this->pageRepository->findOneBy(array('root' => true));
        }

        /**
         * If you provide a 'level' it will move up the tree until it matches
         * your desired level.
         */
        if (isset($options['level'])) {
            $level = $options['level'];

            if ($level > ($root->getLevel()+1)) {
                throw new \Exception(sprintf('Cannot get a level (%d) higher than this page\'s children (%d), '
                                           . 'it is impossible to tell the path', $level, ($root->getLevel()+1)));
            }

            while ($root->getLevel() >= $level && $root->getLevel() > 0) {
                $root = $root->getParent();
            }
        }

        return $root;
    }

    /**
     *
     * @param NodeInterface $node
     * @param PageInterface $children
     */
    protected function populateChildren(MenuItem $menu, PageInterface $parent)
    {
        foreach($parent as $child) {
            if(!$child->getDisplay()) {
                continue;
            }

            $item = $this->factory->createItem($child->getTitle(), array(
                'route' => $child->getRoute(),
            ));

            // Store Page ID
            $item->setExtra('_page_id', $child->getId());
            $menu->addChild($item);

            $this->populateChildren($item, $child);
        }
    }

    public function has($name, array $options = array())
    {
        return strtolower($name) === 'tree';
    }
}