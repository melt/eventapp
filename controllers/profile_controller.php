<?php namespace melt;

 class ProfileController extends userx\RestrictedController {

    public $menu = array();
    
    

    
    function index() {}
    

    
    
    
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