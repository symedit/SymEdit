<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\CacheBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;

class HttpCacheController extends Controller
{
    /**
     * @Template("@SymEdit/Admin/Cache/index.html.twig")
     */
    public function indexAction()
    {
        $cacheDir = $this->getHttpCacheDir();

        if (!$this->hasCache()) {
            return [
                'cache_exists' => false,
            ];
        }

        // Stat cache directory for some information
        $stat = stat($cacheDir);

        return [
            'cache_exists' => true,
            'stat' => $stat,
        ];
    }

    public function clearAction()
    {
        if ($this->hasCache()) {
            $this->doClear();

            $this->addFlash('success', 'symedit.cache.cleared');
        } else {
            $this->addFlash('error', 'symedit.cache.no_cache');
        }

        return $this->redirectToRoute('admin_cache');
    }

    private function doClear()
    {
        $cacheDir = $this->getHttpCacheDir();
        $filesystem = new Filesystem();
        $filesystem->remove($cacheDir);
    }

    private function hasCache()
    {
        $cacheDir = $this->getHttpCacheDir();

        if (!is_dir($cacheDir)) {
            return false;
        }

        $iterator = new \FilesystemIterator($this->getHttpCacheDir(), \FilesystemIterator::SKIP_DOTS);
        $fileCount = iterator_count($iterator);

        return $fileCount > 0;
    }

    private function getHttpCacheDir()
    {
        $kernelCache = $this->getParameter('kernel.cache_dir');

        return sprintf('%s/http_cache', $kernelCache);
    }
}
