<?php namespace nmvc;

class AdminController extends userx\RestrictedController {
    public $limbo = false;

    private static function inLimbo($action_name) {
        return \array_key_exists($action_name, array(
            "logout" => true,
            "login" => true,
            "index" => true,
            "spec" => true,
            "new_hub" => true //temporary before we set permissions
        ));
    }


    public function index() {
        $this->new_hub = new \nmvc\HubModel();

    }

    public function logout() {
        $this->facebook = null;
        $this->user = null;
        \session_destroy();
        \nmvc\request\redirect("/");
    }
    
    public function spec() {}

    

    public function login() {
        $this->fb_user_data = $this->facebook->api('/me');
        $this->user = \nmvc\userx\UserModel::updateOrCreateNewUser($this->fb_user_data);
        \nmvc\userx\login($this->user);
        \nmvc\request\redirect("/");
    }
/*$this->user = \nmvc\userx\UserModel::updateOrCreateNewUser($this->fb_user_data);
        $this->user->login(null, true);*/

    protected static function canAccessAsWhere($special_permission, $action, $arguments) {
        if (self::inLimbo($action))
            return true;
        $user_allowed =  array("outside","login","logout");
        $manager_allowed = array("");
        switch ($special_permission) {
        case "superadmin":
            return true;
        case "manager":
            return \in_array($action, \array_merge($user_allowed, $manager_allowed));
        case "user":
            return \in_array($action, $user_allowed);
        }
        return false;
    }

    public static function getDefaultPermission(userx\GroupModel $group = null) {
        if ($group === null)
            return "guest";
        else if ($group->context == userx\GroupModel::CONTEXT_USER)
            return "user";
        else if ($group->context == userx\GroupModel::CONTEXT_MANAGER)
            return "manager";
        else if ($group->context == userx\GroupModel::CONTEXT_SUPERADMIN)
            return "superadmin";
        else
            return false;
    }

}