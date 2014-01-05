<?php

namespace Isometriks\Bundle\SymEditBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Isometriks\Bundle\SymEditBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Gedmo\Sluggable\Util as Sluggable;

/**
 * Image controller.
 *
 * @PreAuthorize("hasRole('ROLE_ADMIN_IMAGE')")
 */
class ImageController extends Controller
{
    /**
     * Deletes a Image entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mediaManager = $this->getMediaManager();
            $entity = $mediaManager->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Image entity.');
            }

            try {
                $mediaManager->deleteMedia($entity);
            } catch(\Exception $e) {
                $this->addFlash('error', 'There was an error removing the image. Make sure it is not used in a Post or a Slider.');
            }
        }

        return $this->redirect($this->generateUrl('admin_image'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->setAction($this->generateUrl('admin_image_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

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

        $mediaManager = $this->getMediaManager();

        $media = $mediaManager->createMedia();
        $media->setFile($file);
        $media->setName($nameSlug);

        try {
            $mediaManager->updateMedia($media);

            return new JsonResponse(array(
                'filelink' => $media->getWebPath(),
            ));

        } catch (\Exception $ex) {

            return new JsonResponse(array(
                'error' => 'Error uploading, try renaming your image file.',
            ));
        }
    }
}
