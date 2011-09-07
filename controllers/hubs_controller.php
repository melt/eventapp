<?php namespace melt;

class HubsController extends userx\RestrictedController {

     
    function index(){}
    
    function add_edit($id = null){
        if($id === null){
            $this->hub = new HubModel;
        } else {
            $this->hub = HubModel::select()->where("id")->is($id)->first();
        }
        
    }
    
    
    function email($id,$members_only = true){
        $this->hub = HubModel::select()->where("id")->is($id)->first();
        $this->email = new SendEmailModel;
        $this->email->name = $this->user->getName();
        $this->email->email = $this->user->username;
        $this->email->hub = $this->hub;
        $this->email->members_only = $members_only;
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