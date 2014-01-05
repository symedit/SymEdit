<?php

namespace Isometriks\Bundle\SymEditBundle\Doctrine\ORM;

use Doctrine\ORM\Mapping\ClassMetadata;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Isometriks\Bundle\SymEditBundle\Widget\WidgetRegistry;

class WidgetRepository extends EntityRepository
{
    protected $registry;

    public function __construct($em, ClassMetadata $class, WidgetRegistry $registry)
    {
        $this->registry = $registry;

        parent::__construct($em, $class);
    }

    /**
     * @return WidgetInterface
     */
    public function createNew($strategyName = null)
    {
        $class = $this->getClassName();
        $widget = new $class();

        if($strategyName !== null){
            $widget->setStrategyName($strategyName);
            $this->registry->init($widget);
        }

        return $widget;
    }
}