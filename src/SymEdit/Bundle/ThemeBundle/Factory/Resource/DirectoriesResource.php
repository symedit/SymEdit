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
use Assetic\Factory\Resource\CoalescingDirectoryResource as BaseResource;

class DirectoriesResource extends BaseResource
{
    public function __construct(Theme $theme)
    {
        $directories = array();

        foreach ($theme->getTemplateDirectories() as $directory) {
            $directories[] = new \Assetic\Factory\Resource\DirectoryResource($directory);
        }

        parent::__construct($directories);
    }
}