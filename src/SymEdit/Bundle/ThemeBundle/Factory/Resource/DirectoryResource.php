<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Factory\Resource;

use SymEdit\Bundle\ThemeBundle\Model\Theme;
use Assetic\Factory\Resource\DirectoryResource as BaseResource;

class DirectoryResource extends BaseResource
{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;

        parent::__construct($theme->getTemplateDirectory());
    }
}
