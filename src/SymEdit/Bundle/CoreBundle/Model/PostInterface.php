<?php

namespace SymEdit\Bundle\CoreBundle\Model;

use SymEdit\Bundle\BlogBundle\Model\PostInterface as BasePostInterface;
use SymEdit\Bundle\SeoBundle\Model\SeoAbleInterface;

interface PostInterface extends BasePostInterface, SeoAbleInterface
{

}