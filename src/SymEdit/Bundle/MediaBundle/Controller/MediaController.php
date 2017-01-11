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

use SymEdit\Bundle\MediaBundle\Model\MediaInterface;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class MediaController extends ResourceController
{
    abstract public function jsonAction();

    public function quickUploadAction(Request $request)
    {
        $file = $request->files->get('file');

        /* @var $media MediaInterface */
        $media = $this->factory->createNew();
        $media->setFile($file);

        // Validate the new image
        $errors = $this->get('validator')->validate($media, ['file_only']);

        if (count($errors) > 0) {
            return new JsonResponse([
                'error' => 'Invalid media: '.$errors[0]->getMessage(),
            ]);
        }

        try {
            $this->getManager()->persist($media);
            $this->getManager()->flush($media);

            return $this->getQuickUploadResponse($media);
        } catch (\Exception $ex) {
            return new JsonResponse([
                'error' => 'Error uploading, try renaming your media file.',
            ]);
        }
    }

    protected function getMediaLink(MediaInterface $media)
    {
        return sprintf('[link media-id=%d]', $media->getId());
    }

    protected function getQuickUploadResponse(MediaInterface $media)
    {
        return new JsonResponse([
            'id' => $media->getId(),
            'filelink' => $media->getWebPath(),
            'weblink' => $media->getWebPath(),
        ]);
    }
}
