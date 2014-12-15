<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\MediaBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class FileController extends MediaController
{
    public function jsonAction()
    {
        $files = $this->getRepository()->findAll();
        $out = array();

        foreach ($files as $file) {
            $size = $this->getFilesystem()->get($file->getPath())->getSize();

            $out[] = array(
                'title' => $file->getName(),
                'name' => $file->getPath(),
                'link' => sprintf('[link media-id=%d]', $file->getId()),
                'size' => sprintf('%dB', $size),
            );
        }

        return new JsonResponse($out);
    }

    /**
     * @return \Gaufrette\Filesystem
     */
    protected function getFilesystem()
    {
        return $this->container->get('symedit_media.filesystem.file');
    }
}
