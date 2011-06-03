<?php namespace nmvc;

class EventController extends userx\RestrictedController {

    public function add() {
        $this->new_event = new \nmvc\EventModel();
    }

    public function add_invitees($event_id) {
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