<?php
/**
 * Created by PhpStorm.
 * User: Petrik
 * Date: 4.11.2014
 * Time: 8:27
 */

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