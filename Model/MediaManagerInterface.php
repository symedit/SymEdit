<?php

namespace Isometriks\Bundle\MediaBundle\Model;

interface MediaManagerInterface
{
    public function getClass();

    public function createMedia();
}