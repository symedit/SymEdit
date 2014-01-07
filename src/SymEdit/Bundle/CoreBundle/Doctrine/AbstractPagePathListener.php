<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CoreBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use SymEdit\Bundle\CoreBundle\Model\PageInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

abstract class AbstractPagePathListener implements EventSubscriber
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @TODO: Maybe we should move to dynamic routing?
     *
     * @param type $args
     */
    protected function updateRoutes($args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof PageInterface) {
            $matcher_class = $this->router->getOption('matcher_cache_class');
            $generator_class = $this->router->getOption('generator_cache_class');
            $cache_dir = $this->router->getOption('cache_dir');

            $matcher_file = sprintf('%s/%s.php', $cache_dir, $matcher_class);
            $generator_file = sprintf('%s/%s.php', $cache_dir, $generator_class);

            if (file_exists($matcher_file)) {
                unlink($matcher_file);
            }

            if (file_exists($generator_file)) {
                unlink($generator_file);
            }
        }
    }
}