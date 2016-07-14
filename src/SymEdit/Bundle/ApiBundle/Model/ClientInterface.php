<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\ApiBundle\Model;

use FOS\OAuthServerBundle\Model\ClientInterface as BaseClientInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ClientInterface extends BaseClientInterface, ResourceInterface
{
}
