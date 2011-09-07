<?php namespace melt;

 class OutsideController extends AppController {


    

    
    function index() {}
    
    public function rsvp($rsvp_page_hash){
        $this->invitee = EventInviteeModel::select()->where("rsvp_page_hash")->is($rsvp_page_hash)->first();
        if($this->invitee === null)
            show_404();
    }

    function about() {}
    
    function login() {
        $this->fb_user_data = $this->facebook->api('/me');
        //debug($this->fb_user_data);        
        if($this->user){
        // User already exists in database, update login time and IP
            $this->user->updateUserLastLogin();
        } else {
        // User does not exist in database, add new user
            $this->user = userx\UserModel::addNewUser($this->fb_user_data);
        }
        \melt\userx\login($this->user);
        \melt\request\redirect( url("/") );
    }
    
    function logout() {
        $this->facebook = null;
        $this->user = null;
        \session_destroy();
        \melt\request\redirect( url("/outside") );
    }

}