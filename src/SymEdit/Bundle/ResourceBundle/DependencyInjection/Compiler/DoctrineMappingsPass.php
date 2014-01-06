<?php

namespace SymEdit\Bundle\ResourceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass;

class DoctrineMappingsPass
{
    public static function addMappings(ContainerBuilder $container, $mappings)
    {
        // ORM
        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createYamlMappingDriver(
                    $mappings,
                    array('symedit.model_manager_name'),
                    'symedit.driver.doctrine/orm'
            ));
        }

        // MongoDB
        $mongoCompilerClass = 'Doctrine\Bundle\MongoDBBundle\DependencyInjection\Compiler\DoctrineMongoDBMappingsPass';
        if (class_exists($mongoCompilerClass)) {
            $container->addCompilerPass(
                DoctrineMongoDBMappingsPass::createYamlMappingDriver(
                    $mappings,
                    array('symedit.model_manager_name'),
                    'symedit.driver.doctrine/mongodb'
            ));
        }
    }
}