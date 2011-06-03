<?php namespace nmvc;

class UserController extends userx\RestrictedController {


    public static function getDefaultPermission(userx\GroupModel $group = null) {
        if ($group === null)
            return "Deny";
        else if ($group->context == userx\GroupModel::CONTEXT_GUEST)
            return "Deny";
        else if ($group->context == userx\GroupModel::CONTEXT_MEMBER)
            return "Deny";
        else if ($group->context == userx\GroupModel::CONTEXT_AMBASSADOR)
            return "Deny";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_SUPERADMIN)
            return "Allow";
        else
            return false;
    }
}