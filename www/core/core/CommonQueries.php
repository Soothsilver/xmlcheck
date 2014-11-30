<?php
namespace asm\core;


class CommonQueries {
    // TODO None of this works, I think.

    /**
     * Returns an array of all attachments that can be viewed and deleted by the logged-in user.
     *
     * @return \Attachment[] attachments that can be edited by the active user
     */
    public static function GetAttachmentsVisibleToActiveUser()
    {
        $repository = Repositories::getRepository(Repositories::Attachment);
        if (User::instance()->hasPrivileges(User::lecturesManageAll))
        {
            return $repository->findAll();
        }
        else
        {
            return  Repositories::getEntityManager()->createQuery("SELECT a FROM \Attachment a WHERE a.lecture.owner = :ownerId")
                ->setParameter('ownerId', User::instance()->getId())
                ->getResult();
        }
    }
    /**
     * Returns an array of all questions that can be viewed, edited and deleted by the logged-in user.
     *
     * @return \Question[] questions that can be edited by the active user
     */
    public static function GetQuestionsVisibleToActiveUser()
    {
        $repository = Repositories::getRepository(Repositories::Question);
        if (User::instance()->hasPrivileges(User::lecturesManageAll))
        {
            return $repository->findAll();
        }
        else
        {
            return  Repositories::getEntityManager()->createQuery("SELECT q FROM \Question q WHERE q.lecture.owner = :ownerId")
                ->setParameter('ownerId', User::instance()->getId())
                ->getResult();
        }
    }

    /**
     * Returns an array of all tests that can be viewed, edited and deleted by the logged-in user.
     *
     * @return \Xtest[] tests that can be edited by the active user
     */
    public static function GetTestsVisibleToUser()
    {
        $repository = Repositories::getRepository(Repositories::Xtest);
        if (User::instance()->hasPrivileges(User::lecturesManageAll))
        {
            return $repository->findAll();
        }
        else
        {
            return  Repositories::getEntityManager()->createQuery("SELECT x FROM \Xtest x WHERE x.lecture.owner = :ownerId")
                ->setParameter('ownerId', User::instance()->getId())
                ->getResult();
        }
    }
} 