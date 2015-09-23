<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Menu\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\Request;

class PageVoter implements VoterInterface
{
    /**
     * @var Request
     */
    protected $request;
    protected $page = null;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * {@inheritdoc}
     */
    public function matchItem(ItemInterface $item)
    {
        if (($page = $this->getPage()) && $page->getId() !== null) {
            return $item->getExtra('_page_id', null) === $page->getId();
        }

        return;
    }

    /**
     * Get current page if there is one.
     *
     * @return SymEdit\Bundle\CoreBundle\Model\PageInterface|null $page
     */
    protected function getPage()
    {
        if ($this->page === null) {
            if (isset($this->request->attributes) && is_object($this->request->attributes) && $this->request->attributes->has('_page')) {
                $this->page = $this->request->attributes->get('_page');
            }
        }

        return $this->page;
    }
}
