<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Assetic\Factory\Resource;

use Assetic\Factory\Resource\CoalescingDirectoryResource as BaseResource;
use Assetic\Factory\Resource\DirectoryResource;
use SymEdit\Bundle\ThemeBundle\Model\Theme;

class ThemeTwigResource extends BaseResource
{
    public function __construct(Theme $theme)
    {
        $directories = [];

        foreach ($theme->getTemplateDirectories() as $directory) {
            $directories[] = new DirectoryResource($directory);
        }

        parent::__construct($directories);
    }
}
