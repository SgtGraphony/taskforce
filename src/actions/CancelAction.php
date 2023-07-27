<?php

namespace taskforce\actions;

class CancelAction extends AbstractAction
{

    public static function getName(): string
    {
        return "Отменить";
    }

    public static function getInternalName(): string
    {
        return "action_cancel";
    }

    public static function checkRights(?int $customerID, ?int $executionerID, int $userID): bool
    {
        return $customerID == $userID;
    }
}