<?php namespace melt;

class EventsController extends userx\RestrictedController {
    

    public function beforeRender($action_name, $arguments) {
        parent::beforeRender($action_name, $arguments);
        $this->events_breadcrumb[_("Events")] = "/events,^/events$";
        $this->events_breadcrumb[_("Event Details")] = "/#event_details,^/events_details";
        $this->events_breadcrumb[_("Invitees")] = "/#event_invitees,^/events_invitees";
        $this->events_breadcrumb[_("Email Invitations")] = "/#event_invitations,^/events_invitations";
        $this->events_breadcrumb = core\generate_ul_navigation($this->events_breadcrumb, "current");

    }
    
    
    function index(){}

    
    function details( $hub_id = null, $event_id = null  ){
        if($event_id === null)
            $this->event = new EventModel();
        else
            $this->event = EventModel::select()->where('id')->is($event_id)->first();
        $this->event->hub_id = (integer)$hub_id;
    }
    
    function invitees( $event_id ){
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
    
        $this->new_event_invitee = new \melt\EventInviteeModel();
        // Attach to current event
        $this->new_event_invitee->event_id = (int) $event_id;
        $this->event = $this->new_event_invitee->event;
        // Get existing invitees if any
        $this->existing_invitees = EventInviteeModel::select()->where("event")->is($event_id);
    }
    
    function invitees_remove( $invitee_id ) {
        $this->invitee = EventInviteeModel::select()->where("id")->is($invitee_id)->first();
        $event_id = $this->invitee->event_id;
        $this->invitee->unlink();
        request\redirect("/events/invitees/$event_id");
    }
    
    function invitations( $event_id ){
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
    }
    
    
   function invitations_send( $event_id, $what = "invitation" ){
       $this->event = EventModel::select()->where("id")->is($event_id)->first();
       switch($what){
           case "invitation":
               $this->event->sendInvitations();
               break;
           case "invitation_reminder":
               $this->event->sendInvitations($is_reminder = true);
               break;
           case "reminder":
               $this->event->forceSendReminders();
               break;
           case "thankyou":
               $this->event->forceSendThankyous();
               break;
               
       }
       messenger\redirect_message("/events/invitations/$event_id", "Emails were successfully sent!", "good");
   }

    function attendees( $event_id ) {
        $this->event = EventModel::select()->where("id")->is( $event_id )->first();
    }
    
    function rsvp_list_toggle( $event_id ) {
        $this->event = EventModel::select()->where("id")->is( $event_id )->first();
        if( $this->event->rsvp_closed === true )
            $this->event->rsvp_closed = false;
        else
            $this->event->rsvp_closed = true;
        $this->event->store();
        request\redirect("/events/attendees/$event_id");
    }
    
    
    
    public function search_invitee() {
        $q = strtolower($_GET["q"]);
        if (!$q) return;
        $users = \melt\userx\UserModel::select()->where("first_name")->isLike("%".$q."%")->or("last_name")->isLike("%".$q."%")->or("username")->isLike("%".$q."%");
        if($users->count() === 0) return;
        foreach($users as $user){
            $items = array(
               $user->getName()." - ".$user->view('user_type'). " - " .$user->view('username') => $user->view('username')
            );
        }
        
        /*foreach($users as $user){
            $attended_events = \melt\EventInviteeModel::select()->where("invitee")->is($user)->and("rvsp")->is( EventInviteeModel::ATTENDING )->count();
            $name = ($user->first_name!="")? $user->getName(): $user->view('username');

            $items = array(
               "$name (".$user->getGroupName()." - $attended_events attended events)" => $user->view('username')
            );
        }
        $items = array(
               $user->view('username') => $user->view('username')
            );*/
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
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_MEMBER)
            return "Allow";
        else if ($group->context == userx\GroupModel::CONTEXT_ADMIN)
            return "Allow";
        else
            return false;
    }
    
}