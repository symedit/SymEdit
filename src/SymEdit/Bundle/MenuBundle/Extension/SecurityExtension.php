<?php

namespace SymEdit\Bundle\MenuBundle\Extension;

use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityExtension extends AbstractMenuItemExtension
{
    protected $securityContext;

    public function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    protected function modifyItem(ItemInterface $item, array $options)
    {
        $extras = $item->getExtras();

        if (!isset($extras['is_granted'])) {
            return;
        }

        if (!$this->securityContext->isGranted($extras['is_granted'])) {
            $this->removeItem($item);
        }
    }
}
