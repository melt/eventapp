<?php namespace nmvc;

class EventController extends userx\RestrictedController {

    public function add_edit($event_id = false) {
        if($event_id == false)
            $this->event = new \nmvc\EventModel();
        else
            $this->event = EventModel::select()->where("id")->is($event_id)->first();
    }

    public function add_invitees($event_id) {
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
        $this->new_event_invitee = new \nmvc\EventInviteeModel();
        // Attach to current event
        $this->new_event_invitee->event_id = (int) $event_id;
        $this->event = $this->new_event_invitee->event;
        // Get existing invitees if any
        $this->existing_invitees = EventInviteeModel::select()->where("event")->is($event_id);
    }

    public function search_invitee() {
        $q = strtolower($_GET["q"]);
        if (!$q) return;
        $users = \nmvc\userx\UserModel::select()->where("first_name")->isLike("%".$q."%")->or("last_name")->isLike("%".$q."%")->or("username")->isLike("%".$q."%");
        if($users->count() == 0) return;
        foreach($users as $user){
            $items = array(
                $user->first_name." ".$user->last_name => $user->username
            );
        }
        foreach ($items as $key=>$value) {
	if (strpos(strtolower($key), $q) !== false) {
		echo "$key|$value\n";
	}
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
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_SUPERADMIN)
            return "Allow";
        else
            return false;
    }
}