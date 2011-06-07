<?php namespace nmvc;

class HubController extends userx\RestrictedController {

    public function add_edit($hub_id = false) {
        if($hub_id == false){
            $this->hub = new \nmvc\HubModel();
            $this->hub_ambassador = new \nmvc\HubAmbassadorModel();
            $this->hub_ambassador->hub = $this->hub;
        } else {
            $this->hub = HubModel::select()->where("id")->is($hub_id)->first();
            //$this->hub_ambassador = HubAmbassadorModel::select()->where("hub")->is($this->hub)->first();
        }
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