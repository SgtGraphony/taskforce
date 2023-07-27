<?php

namespace taskforce\actions;

class RespondAction extends AbstractAction
{

    public static function getName(): string
    {
        return "Откликнуться";
    }

    public static function getInternalName(): string
    {
        return "action_respond";
    }

    public static function checkRights(?int $customerID, ?int  $executionerID, int $userID): bool
    {
        return $executionerID == $userID;
    }
}