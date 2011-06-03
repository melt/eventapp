<?php namespace nmvc;

class OutsideController extends AppController {

    public function index(){}

    public function login() {
        $this->fb_user_data = $this->facebook->api('/me');
        if($this->user){
        // User exists in database, update login details
            $this->user->updateUser($this->fb_user_data);
        } else {
        // Add user to database
            $this->user = \nmvc\userx\UserModel::addNewUser($this->fb_user_data);
        }
        \nmvc\userx\login($this->user);
        \nmvc\messenger\redirect_message(url("/inside/"), _("Successfully logged in!"), "good");
    }

    public function logout() {
        $this->facebook = null;
        $this->user = null;
        \session_destroy();
        \nmvc\messenger\redirect_message(url("/"), _("Successfully logged out!"), "good");
    }

    /*
     * The page where user RVSPs to event using a uniquely hashed link
     */
    public function rvsp($rvsp_page_hash){
        $this->rvsp = EventInviteeModel::select()->where("rvsp_page_hash")->is($rvsp_page_hash)->and("rvsp")->is(0)->first();
    }

    public function rvsp_thanks(){
        $this->rvsp = trim(@$_GET["rvsp"]);
        $this->email = trim(@$_GET["email"]);
    }

    public function unsubscribe($user_id){
        $this->user == userx\UserModel::select()->where("id")->is($user_id)->first();
        $this->user->is_unsubscribed = true;
        $this->user->store();
        \nmvc\messenger\redirect_message(url("/"), _("Successfully unsubscribed to emails!"), "good");   
    }

    public function api($city) {
        $results = \nmvc\EventModel::select()->where("city")->is($city);
        if($results->count() > 0)
            \nmvc\request\send_json_data($results);
        else
            \nmvc\request\send_json_data(false);
    }

    function r20110507() {
       $this->layout = "/layout_report";
    }
    
    function spec(){}

    function forbidden_403(){}
}