<?php namespace melt;

 class InsideController extends userx\RestrictedController {

    public $menu = array();
    
    

    public function beforeRender($action_name, $arguments) {
        
        
        $this->menu[_("My Profile")] = "/,^/$|/$|/$";
        $this->menu[_("Events")] = "/events,^/events";
        $this->menu[_("Hubs")] = "/hubs,^/hubs";
        $this->menu[_("Logout")] = "/#logout,^/logout$";
        $this->menu = core\generate_ul_navigation($this->menu, "current");
        
        $this->events_breadcrumb[_("Events")] = "/events,^/events$";
        $this->events_breadcrumb[_("Event Details")] = "/#event_details,^/events_details";
        $this->events_breadcrumb[_("Invitees")] = "/#event_invitees,^/events_invitees";
        $this->events_breadcrumb[_("Email Invitations")] = "/#event_invitations,^/events_invitations";
        $this->events_breadcrumb = core\generate_ul_navigation($this->events_breadcrumb, "current");
    }
    
    function index() {}

    function events() {}
    
    function hubs() {}
    
    function events_details( $hub_id = null, $event_id = null  ){
        if($event_id == null)
            $this->event = new EventModel();
        else
            $this->event = EventModel::select()->where('id')->is($event_id)->first();
        $this->event->hub_id = (integer)$hub_id;
    }
    
    function events_invitees( $event_id ){
        $this->event = EventModel::select()->where("id")->is($event_id)->first();
        $this->new_event_invitee = new \melt\EventInviteeModel();
        // Attach to current event
        $this->new_event_invitee->event_id = (int) $event_id;
        $this->event = $this->new_event_invitee->event;
        // Get existing invitees if any
        $this->existing_invitees = EventInviteeModel::select()->where("event")->is($event_id);
    }
    
    function events_invitations(){
        
    }
    
    
    public function search_invitee() {
        $q = strtolower($_GET["q"]);
        if (!$q) return;
        $users = \melt\userx\UserModel::select()->where("first_name")->isLike("%".$q."%")->or("last_name")->isLike("%".$q."%")->or("username")->isLike("%".$q."%");
        if($users->count() == 0) return;
        /*foreach($users as $user){
            $attended_events = \melt\EventInviteeModel::select()->where("invitee")->is($user)->and("rvsp")->is( EventInviteeModel::ATTENDING )->count();
            $name = ($user->first_name!="")? $user->getName(): $user->view('username');

            $items = array(
               "$name (".$user->getGroupName()." - $attended_events attended events)" => $user->view('username')
            );
        }*/
        $items = array(
               $user->view('username') => $user->view('username')
            );
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