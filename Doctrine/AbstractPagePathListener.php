<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Isometriks\Bundle\SymEditBundle\Model\PageInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

abstract class AbstractPagePathListener implements EventSubscriber
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

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