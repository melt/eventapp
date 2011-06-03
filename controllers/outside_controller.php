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
}