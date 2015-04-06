<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Shortcode;

use SymEdit\Bundle\CoreBundle\Shortcode\Link\LinkInterface;
use SymEdit\Bundle\ShortcodeBundle\Shortcode\AbstractShortcode;
use Symfony\Component\Routing\RouterInterface;

class LinkShortcode extends AbstractShortcode
{
    protected $links;
    protected $router;

    public function __construct(array $links, RouterInterface $router)
    {
        $this->links = $links;
        $this->router = $router;
    }

    public function renderShortcode($match, array $attr, $content)
    {
        $out = $match;

        /* @var $link LinkInterface */
        foreach ($this->links as $link) {
            if (!$link->supports($attr)) {
                continue;
            }

            if (($path = $link->generate($this->router, $attr)) !== null) {
                $out = $path;

                break;
            }
        }

        return $out;
    }

    public function getName()
    {
        return 'link';
    }
}
