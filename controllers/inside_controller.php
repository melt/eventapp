<?php namespace melt;

 class InsideController extends userx\RestrictedController {

    public $menu = array();
    
    

    public function beforeRender($action_name, $arguments) {
        
        
        $this->menu[_("My Profile")] = "/,^/$|/$|/$";
        $this->menu[_("About")] = "/about,^/about$";
        $this->menu[_("Contact")] = "/contact,^/contact$";
        $this->menu[_("Logout")] = "/#logout,^/logout$";
        
        
        $this->menu = core\generate_ul_navigation($this->menu, "current");
    }
    
    function index() {}

    function about() {}
    
    function contact() {
        $this->contact_form = new ContactFormModel();
    }
    
    
    public static function getDefaultPermission(userx\GroupModel $group = null) {
        if ($group === null)
            return "Deny";
        else if ($group->context == userx\GroupModel::CONTEXT_GUEST)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_MEMBER)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_AMBASSADOR)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_SUPERADMIN)
            return "Allow";
        else
            return false;
    }
    


}