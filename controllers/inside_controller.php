<?php namespace nmvc;

class InsideController extends userx\RestrictedController {

    public function index() {}
    
    public function logout() {
        $this->facebook = null;
        $this->user = null;
        \session_destroy();
        \nmvc\messenger\redirect_message(url("/"), _("Successfully logged out!"), "good");
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