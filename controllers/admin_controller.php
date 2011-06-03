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
        // Get unmoderated users to display if neccessary
        $this->unmoderated_users = \nmvc\userx\UserModel::select()->where("is_moderated")->is(0);
    }

    public function new_hub() {
        $this->new_hub = new \nmvc\HubModel();
        $this->new_hub_ambassador = new \nmvc\HubAmbassadorModel();
    }

    public function new_event() {
        $this->new_event = new \nmvc\EventModel();
    }

    public function new_event_invitees($event_id) {
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
        // If invite already sent, do not allow to add more invitees
        if($this->event->invite_email_sent == true)
            \nmvc\messenger\redirect_message(url("/"), _("Invite email already sent!"), "bad");

        $this->new_event_invitee = new \nmvc\EventInviteeModel();
        // Attach to current event
        $this->new_event_invitee->event_id = (int) $event_id;
        $this->event = $this->new_event_invitee->event;
        // Get existing invitees if any
        $this->existing_invitees = EventInviteeModel::select()->where("event")->is($event_id);
    }

    public function my_profile() {}


    
    public function spec() {}

    public function thanks() {}
    
    public function user_edit($user_id) {
        $this->user = userx\UserModel::select()->where("id")->is($user_id)->first();
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