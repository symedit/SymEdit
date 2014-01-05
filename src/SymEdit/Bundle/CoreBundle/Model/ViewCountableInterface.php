<?php

namespace SymEdit\Bundle\CoreBundle\Model;

interface ViewCountableInterface
{
    public function getViews();
    public function setViews($views);
    public function addView();
}
