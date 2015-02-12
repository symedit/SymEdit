<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
