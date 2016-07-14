<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ThemeBundle\Theme;

use Doctrine\Common\Cache\Cache;
use SymEdit\Bundle\ThemeBundle\Model\ThemeInterface;
use SymEdit\Bundle\ThemeBundle\Theme\Exception\ThemeLoadingException;

class ThemeManager
{
    protected $factory;
    protected $finder;
    protected $cache;
    protected $debug;
    protected $themes = [];

    public function __construct(ThemeFactoryInterface $factory, ThemeFinder $finder, Cache $cache, $debug = false)
    {
        $this->factory = $factory;
        $this->finder = $finder;
        $this->cache = $cache;
        $this->debug = $debug;
    }

    /**
     * Get a theme by its name.
     *
     * @param string $name
     *
     * @return ThemeInterface
     */
    public function getTheme($name)
    {
        $cacheKey = $this->getCacheKey($name);
        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }

        if (!array_key_exists($name, $this->themes)) {
            $this->themes[$name] = $this->factory->getTheme($name);
        }

        $theme = $this->themes[$name];

        // Save into cache if not in debug
        if (!$this->debug) {
            $this->cache->save($cacheKey, $theme);
        }

        return $theme;
    }

    protected function getCacheKey($name)
    {
        return sprintf('theme_%s', $name);
    }

    /**
     * Gets all themes.
     *
     * @return ThemeInterface[]
     */
    public function getThemes()
    {
        $names = $this->finder->findThemeNames();

        foreach ($names as $name) {
            try {
                $this->getTheme($name);
            } catch (ThemeLoadingException $e) {
            }
        }

        return $this->themes;
    }
}
