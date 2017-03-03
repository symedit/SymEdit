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

use Gaufrette\Filesystem;
use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class FileController extends MediaController
{
    public function jsonAction()
    {
        $files = $this->repository->findAll();
        $out = [];

        foreach ($files as $file) {
            $size = $this->getFilesystem()->get($file->getPath())->getSize();

            $out[] = [
                'title' => $file->getName(),
                'name' => $file->getPath(),
                'link' => $this->getMediaLink($file),
                'size' => $this->getReadableSize($size),
            ];
        }

        return new JsonResponse($out);
    }

    protected function getReadableSize($bytes)
    {
        $size = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        $units = isset($size[$factor]) ? $size[$factor] : '';

        return sprintf('%.2f', $bytes / pow(1024, $factor)).$units;
    }

    protected function getQuickUploadResponse(MediaInterface $media)
    {
        return new JsonResponse([
            'id' => $media->getId(),
            'filename' => $media->getName(),
            'filelink' => $this->getMediaLink($media),
            'weblink' => $media->getWebPath(),
        ]);
    }

    /**
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->container->get('symedit_media.filesystem.file');
    }
}
