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

use Gedmo\Sluggable\Util as Sluggable;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Image controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_IMAGE')")
 */
class ImageController extends ResourceController
{
    public function jsonAction()
    {
        $mediaManager = $this->getMediaManager();
        $images = $mediaManager->findAll();
        $manip = $this->get('isometriks_media.util.image_manipulator');
        $out = array();

        foreach($images as $image){
            $out[] = array(
                'thumb' => $manip->constrain($image->getWebPath(), array('w' => 234)),
                'image' => $image->getWebPath(),
            );
        }

        return new JsonResponse($out);
    }

    public function quickUploadAction(Request $request)
    {
        $file = $request->files->get('file');
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $nameSlug = Sluggable\Urlizer::urlize($name, '-');

        $image = $this->getRepository()->createNew();
        $image->setFile($file);
        $image->setName($nameSlug);

        try {
            $this->persistAndFlush($image);

            return new JsonResponse(array(
                'filelink' => $image->getWebPath(),
            ));

        } catch (\Exception $ex) {

            return new JsonResponse(array(
                'error' => 'Error uploading, try renaming your image file.',
            ));
        }
    }
}
