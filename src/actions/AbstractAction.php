<?php

namespace taskforce\actions;

abstract class AbstractAction
{

    abstract public static function getName(): string;

    abstract public static function getInternalName(): string;

    abstract public static function checkRights(?int $customerID, ?int $executionerID, int $userID): bool;

} 