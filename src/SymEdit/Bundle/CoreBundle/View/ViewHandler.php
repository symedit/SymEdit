<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\View;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler as BaseViewHandler;
use Symfony\Component\HttpFoundation\Request;

class ViewHandler extends BaseViewHandler
{
    protected $seo;

    public function setSeo($seo)
    {
        $this->seo = $seo;
    }

    public function handle(View $view, Request $request = null)
    {
        $data = $view->getData();

        /**
         * @TODO: Maybe have an option in the config or only
         *        allow classes that you specify the seo for?
         */
        if (is_object($data) && !$data instanceof \Traversable) {
            $this->seo->setSubject($data);
        }

        return parent::handle($view, $request);
    }
}