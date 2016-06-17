<?php

/*
 * This file is part of the SymEdit package.
 *
 * (c) Craig Blanchette <craig.blanchette@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SymEdit\Bundle\UserBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class MetadataSubscriber implements EventSubscriber
{
    protected $profile;
    protected $adminProfile;

    public function __construct($profile, $adminProfile)
    {
        $this->profile = $profile;
        $this->adminProfile = $adminProfile;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $metadata = $eventArgs->getClassMetadata();

        if ($metadata->getName() === $this->profile) {
            $this->setupProfileDiscriminator($metadata);
        }
    }

    protected function setupProfileDiscriminator(ClassMetadata $metadata)
    {
        // Set inheritence type
        $metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_JOINED);

        // Set not mapped superclass
        $metadata->isMappedSuperclass = false;

        // Set discriminator column
        $metadata->setDiscriminatorColumn([
            'name' => 'discr',
            'type' => 'string',
            'length' => 20,
        ]);

        // Set map
        $metadata->setDiscriminatorMap([
            'user' => $this->profile,
            'admin' => $this->adminProfile,
        ]);
    }

    public function getSubscribedEvents()
    {
        return [
            'loadClassMetadata',
        ];
    }
}
