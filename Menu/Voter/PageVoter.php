<?php

namespace Isometriks\Bundle\SymEditBundle\Menu\Voter;

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

    public function matchItem(ItemInterface $item)
    {
        if ($page = $this->getPage()) {
            return $item->getExtra('_page_id', null) === $page->getId();
        }

        return false;
    }

    protected function getPage()
    {
        if($this->page === null) {
            if($this->request->attributes->has('_page')) {
                $this->page = $this->request->attributes->get('_page');
            }
        }

        return $this->page;
    }
}