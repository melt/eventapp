<?php namespace melt;

class PeopleController extends userx\RestrictedController {

    function index() {}
    
    function queue() {}
    
    function details($id) {
        $this->user = userx\UserModel::select()->where('id')->is($id)->first();
    }
    
    public static function getDefaultPermission(userx\GroupModel $group = null) {
        if ($group === null)
            return "Deny";
        else if ($group->context == userx\GroupModel::CONTEXT_GUEST)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_MEMBER)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "Allow";
        else
            return false;
    }

}