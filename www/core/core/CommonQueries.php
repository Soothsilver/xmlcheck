<?php
namespace asm\core;


class CommonQueries {
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
            return $repository->findBy(['owner' => User::instance()->getId()]);
        }
    }
} 