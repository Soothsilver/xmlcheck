<?php

namespace asm\core;

final class GetSimilarities extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::otherAdministration, User::groupsManageAll, User::lecturesManageAll)) {
            return false;
        }

        $newId = $this->getParams('newId');
        if (!$newId)
        {
            return true;
        }
        $canViewAuthors = User::instance()->hasPrivileges(User::submissionsViewAuthors);

        /** @var \Similarity[] $similarities */
        $similarities = Repositories::getRepository(Repositories::Similarity)->findBy(['newSubmission' => $newId]);
        foreach ($similarities as $similarity) {
            $row = [
                $similarity->getId(),
                $similarity->getOldSubmission()->getId(),
                $similarity->getSuspicious() ? "yes" : false,
                $similarity->getScore(),
                $similarity->getDetails(),
                ($canViewAuthors ? $similarity->getOldSubmission()->getUser()->getRealName(): Language::get(StringID::NotAuthorizedForName)),
                $similarity->getOldSubmission()->getDate()->format("Y-m-d H:i:s")
            ];
            $this->addRowToOutput($row);
        }
        return true;
	}
}

