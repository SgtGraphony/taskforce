<?php

namespace taskforce\actions;

class DenyAction extends AbstractAction
{

    public static function getName(): string
    {
        return "Отказаться";
    }

    public static function getInternalName(): string
    {
        return "action_deny";
    }

    public static function checkRights(?int $customerID, ?int $executionerID, int $userID): bool
    {
        return $executionerID == $userID;
    }
}