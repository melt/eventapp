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
            "doAddInvitee" => true,
            "thanks" => true,
            "new_hub" => true,
            "new_event" => true,
            "new_event_invitees" => true,
            "my_profile" =>true
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
    }

    public function new_hub() {
        $this->new_hub = new \nmvc\HubModel();
        $this->new_hub_ambassador = new \nmvc\HubAmbassadorModel();
    }

    public function new_event() {
        $this->new_event = new \nmvc\EventModel();
        // New invitee form        
    }

    public function new_event_invitees($event_id) {
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
        if($this->event->invite_email_sent == true)
            \nmvc\messenger\redirect_message(url("/"), _("Invite email already sent!"), "bad");

        $this->new_event_invitee = new \nmvc\EventInviteeModel();
        // Attach to current event
        $this->new_event_invitee->event_id = (int) $event_id;
        $this->event = $this->new_event_invitee->event;
        $this->existing_invitees = EventInviteeModel::select()->where("event")->is($event_id);
    }

    public function my_profile() {
        
    }

    public function logout() {
        $this->facebook = null;
        $this->user = null;
        \session_destroy();
        \nmvc\request\redirect("/");
    }
    
    public function spec() {}

    public function thanks() {}
    
    public function user_edit($user_id) {
        $this->user = userx\UserModel::select()->where("id")->is($user_id)->first();
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
        $guest_allowed = array("");
        $member_allowed =  array("outside","login","logout","profile");
        $ambassador_allowed = array("");
        switch ($special_permission) {
        case "superadmin":
        case "admin":
            return true;
        case "ambassador":
            return \in_array($action, \array_merge($guest_allowed, $member_allowed, $ambassador_allowed));
        case "member":
            return \in_array($action, \array_merge($guest_allowed, $member_allowed));
        case "guest":
            return \in_array($action, $guest_allowed);
        }
        return false;
    }

    public static function getDefaultPermission(userx\GroupModel $group = null) {
        if ($group === null)
            return "visitor";
        else if ($group->context == userx\GroupModel::CONTEXT_GUEST)
            return "guest";
        else if ($group->context == userx\GroupModel::CONTEXT_MEMBER)
            return "member";
        else if ($group->context == userx\GroupModel::CONTEXT_AMBASSADOR)
            return "ambassador";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "admin";
        else if ($group->context == userx\GroupModel::CONTEXT_SUPERADMIN)
            return "superadmin";
        else
            return false;
    }

}