<?php

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
