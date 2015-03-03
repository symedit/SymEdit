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
        $media = $this->getRepository()->createNew();
        $media->setFile($file);

        // Validate the new image
        $errors = $this->get('validator')->validate($media, array('file_only'));

        if (count($errors) > 0) {
            return new JsonResponse(array(
                'error' => 'Invalid media: '.$errors[0]->getMessage(),
            ));
        }

        try {
            $this->getManager()->persist($media);
            $this->getManager()->flush($media);

            return new JsonResponse(array(
                'id' => $media->getId(),
                'filelink' => $media->getWebPath(),
            ));
        } catch (\Exception $ex) {
            return new JsonResponse(array(
                'error' => 'Error uploading, try renaming your media file.',
            ));
        }
    }
}
