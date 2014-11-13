<?php

namespace asm\core;

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
        $driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(new \Doctrine\Common\Annotations\AnnotationReader(), $paths);
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
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

    public static function remove($entity)
    {
        self::getEntityManager()->remove($entity);
        self::getEntityManager()->flush($entity);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
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