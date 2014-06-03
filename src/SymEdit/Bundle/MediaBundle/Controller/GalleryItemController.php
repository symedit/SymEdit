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

use SymEdit\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Gallery item controller.
 */
class GalleryItemController extends ResourceController
{
    public function createNew()
    {
        // Get gallery item
        $galleryItem = parent::createNew();
        $galleryId = $this->getRequest()->get('gallery_id');

        $galleryRepository = $this->container->get('symedit.repository.image_gallery');
        $gallery = $galleryRepository->find($galleryId);

        if (!$gallery) {
            throw $this->createNotFoundException('Gallery not found');
        }

        $galleryItem->setGallery($gallery);

        return $galleryItem;
    }

    public function reorderAction(Request $request)
    {
        $pairs = $request->request->get('pairs', array());
        $repository = $this->getRepository();
        $manager = $this->getManager();

        foreach ($pairs as $id => $order) {
            if (!$entity = $repository->find($id)) {
                throw $this->createNotFoundException('Sorting entity not found');
            }

            $entity->setPosition($order);
        }

        $manager->flush();

        $view = $this->view()
            ->setFormat('json')
            ->setTemplateVar('status')
            ->setData(array(
                'status' => true,
            ));

        return $this->handleView($view);
    }
}
