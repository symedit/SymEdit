<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\AnalyticsBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;

interface VisitInterface extends ResourceInterface
{
    public function getModel();
    public function setModel($model);
    public function getIdentifier();
    public function setIdentifier($identifier);
    public function getVisitDate();
    public function setVisitDate($visitDate);
}
