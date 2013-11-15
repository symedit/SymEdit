<?php

namespace Isometriks\Bundle\SymEditBundle\Model;

interface ViewCountableInterface
{
    public function getViews();
    public function setViews($views);
    public function addView();
}