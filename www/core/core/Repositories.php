<?php

namespace asm\core;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Repositories
{
    const StudentUserType = 1;

    // Entity names
    const Assignment = "Assignment";
    const Group = "Group";
    const Lecture = "Lecture";
    const Plugin = "Plugin";
    const Problem = "Problem";
    const Submission = "Submission";
    const Subscription = "Subscription";
    const User = "User";
    const UserType = "UserType";
    const PluginTest = "PluginTest";
    const Question = "Question";
    const Xtest = "Xtest";
    const Similarity = "Similarity";
    const Attachment = "Attachment";
    /**
     * @var EntityManager
     */
    private static $entityManager = null;

    private static function connectToDatabase()
    {
        $isDevMode = true;
        $connection = array(
            'driver'   => 'pdo_mysql',
            'user'     => Config::get('database', 'user'),
            'password' => Config::get('database', 'pass'),
            'dbname'   => Config::get('database', 'db'),
            'host'     => Config::get('database', 'host'),
            'charset'  => 'utf8'
        );
        $paths = array(__DIR__ . "/../doctrine");
        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);
        $entityManager = EntityManager::create($connection, $config);
        $platform = $entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');
        self::$entityManager = $entityManager;
    }

    /**
     * @param $query
     * @return \Doctrine\ORM\Query
     */
    public static function makeDqlQuery($query)
    {
        return self::getEntityManager()->createQuery($query);
    }

    public static function findEntity($entityName, $id)
    {
        return self::getEntityManager()->find($entityName, $id);
    }

    /**
     * Removes the entity from the database and flushes this removal.
     * @param object $entity the entity to remove from the database
     */
    public static function remove($entity)
    {
        self::getEntityManager()->remove($entity);
        self::getEntityManager()->flush($entity);
    }

    /**
     * Gets the Doctrine repository for the specified entity name.
     *
     * @param $entityName string name of the entity
     * @return \Doctrine\ORM\EntityRepository the repository
     */
    public static function getRepository($entityName)
    {
        return self::getEntityManager()->getRepository($entityName);
    }

    public static function persist($entity)
    {
        self::getEntityManager()->persist($entity);
    }
    public static function persistAndFlush($entity)
    {
        self::getEntityManager()->persist($entity);
        self::getEntityManager()->flush($entity);
    }

    public static function flushAll()
    {
        self::getEntityManager()->flush();
    }
    /**
     * @return EntityManager
     */
    public static function getEntityManager()
    {
        if (self::$entityManager === null)
        {
            self::connectToDatabase();
        }
        return self::$entityManager;
    }
} 