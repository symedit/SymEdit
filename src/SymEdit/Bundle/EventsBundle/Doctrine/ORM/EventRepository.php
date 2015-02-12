<?php

namespace SymEdit\Bundle\EventsBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function getUpcoming()
    {
        $qb = $this->getQueryBuilder()
           ->where('o.eventEnd > :now')
           ->orWhere('o.eventStart > :now')
           ->setParameter('now', new \DateTime());

        return $this->getPaginator($qb);
    }

    public function getQueryBuilder()
    {
        return parent::getQueryBuilder()
                ->orderBy(sprintf('%s.eventStart', $this->getAlias()), 'DESC');
    }
}
