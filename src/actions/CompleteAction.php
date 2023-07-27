<?php

namespace taskforce\actions;

class CompleteAction extends AbstractAction
{
    public static function getName(): string
    {
        return "Завершить";
    }

    public static function getInternalName(): string
    {
        return "action_complete";
    }

    public static function checkRights(?int $customerID, ?int $executionerID, int $userID): bool
    {
        return $customerID == $userID;
    }
}