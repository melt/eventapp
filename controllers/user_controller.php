<?php namespace nmvc;

class UserController extends userx\RestrictedController {


    public function edit($user_id) {
        $this->edit_user = userx\UserModel::select()->where("id")->is($user_id)->first();
        $this->user = userx\get_user();
        if( $this->edit_user->group->context == userx\GroupModel::CONTEXT_SUPERADMIN && $this->user->group->context != userx\GroupModel::CONTEXT_SUPERADMIN )
            \nmvc\messenger\redirect_message(url("/"), _("You do not have permissions to edit the details of superadmins!"), "bad");
    }

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