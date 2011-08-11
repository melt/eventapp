<?php namespace melt;

 class OutsideController extends AppController {

    public $menu = array();
    
    
    public function beforeRender($action_name, $arguments) {
        
        
        $this->menu[_("Login")] = "/outside,^/outside$";
        $this->menu[_("About")] = "/outside/about,^/outside/about$";        
        
        $this->menu = core\generate_ul_navigation($this->menu, "current");
    }
    
    function index() {}

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