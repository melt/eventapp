<?php namespace nmvc;

class AdminController extends userx\RestrictedController {
    public $limbo = false;

    private static function inLimbo($action_name) {
        return \array_key_exists($action_name, array(
            "logout" => true,
            "login" => true,
            "index" => true,
            "spec" => true,
            "api" => true,
            "rvsp" => true,
            "user_edit" => true,
            "event_edit" => true,
            "add_invitees" => true,
            "doAddInvitee" => true
        ));
    }


    public function api($city) {
        $results = \nmvc\EventModel::select()->where("city")->is($city);
        if($results->count() > 0)
            \nmvc\request\send_json_data($results);
        else
            \nmvc\request\send_json_data(false);
    }

    public function rvsp($rvsp_page_hash){
        $this->rvsp = EventInviteeModel::select()->where("rvsp_page_hash")->is($rvsp_page_hash)->first();
        if($this->rvsp)
           $this->user = $this->rvsp->invitee;
    }

    public function index() {
        $this->new_hub = new \nmvc\HubModel();
        $this->new_event = new \nmvc\EventModel();
    }

    public function logout() {
        $this->facebook = null;
        $this->user = null;
        \session_destroy();
        \nmvc\request\redirect("/");
    }
    
    public function spec() {}

    public function user_edit($user_id) {
        $this->user = userx\UserModel::select()->where("id")->is($user_id)->first();
    }

    public function event_edit($event_id) {
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
    }

    public function add_invitees($event_id) {
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
        // New invitee form
        $this->event_invitee = new EventInviteeModel();
        // Attach to current event
        $this->event_invitee->event_id = (int) $event_id;
        // Select existing invitees to show if they exist
        $this->existing_invitees = EventInviteeModel::select()->where("event")->is($event_id);


    }

    public function login() {
        $this->fb_user_data = $this->facebook->api('/me');
        $this->user = \nmvc\userx\UserModel::updateOrCreateNewUser($this->fb_user_data);
        \nmvc\userx\login($this->user);
        \nmvc\request\redirect("/");
    }


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