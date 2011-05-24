<?php namespace nmvc;


/** Application specific controller. */
abstract class AppController extends Controller {
    // The layout your controllers use by default.
    public $layout = "/layout";
    public $user = null;

    public function getTitle() {
        return APP_NAME;
    }
    
    public static function rewriteRequest($path_tokens) {
            if($path_tokens[0] == ""){
                \array_unshift($path_tokens, "admin");
                return $path_tokens;
            }
    }

    /**
     * This function is executed before any action in the controller.
     * It's a handy place to check for an active session or
     * inspect user permissions.
     * @param string $action_name Action name about to be called.
     * @param array $arguments Arguments that will be passed to action.
     * @return void
     */
    public function beforeFilter($action_name, $arguments) {
        $this->facebook = new \Facebook(array(
          'appId'  => FACEBOOK_APP_ID,
          'secret' => FACEBOOK_APP_SECRET,
          'cookie' => true,
        ));
        $this->fb_user = $this->facebook->getUser();
        $this->user = \nmvc\userx\UserModel::select()->where("facebook_user")->is($this->fb_user);
        if ($this->fb_user) {
            $this->logout_url = $this->facebook->getLogoutUrl(array('next' => url("/admin/logout")));
        } else {
            $this->login_url = $this->facebook->getLoginUrl(array('redirect_uri' => url("/admin/login"), 'canvas' => 1, 'display' =>'page', 'fbconnect' => 0, 'req_perms' => 'user_about_me,user_birthday,user_location,user_work_history,email,user_website,user_checkins,user_status'));
        }

      /*  // Create application instance
        $facebook = new \Facebook(array(
            'appId'  => FACEBOOK_APP_ID,
            'secret' => FACEBOOK_APP_SECRET,
            'cookie' => true
        ));
        // Check if Facebook user object connected via OATH
        $this->fb_loggedin = $facebook->getUser();
        

        if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}


        if ( $this->fb_loggedin ) {
            $this->logout_url = $facebook->getLogoutUrl(array('next' => url("/admin/logout")));
            if($facebook->getUser())
                    $this->fb_user_data = $facebook->api('/me');
        } else {
            $this->fb_loggedin = null;
            $this->login_url = $facebook->getLoginUrl(array('redirect_uri' => url("/admin/login"), 'canvas' => 1, 'display' =>'page', 'fbconnect' => 0, 'req_perms' => 'user_about_me,user_birthday,user_location,user_work_history,email,user_website,user_checkins'));
        }
*/

    }

    /**
     * Called after controller action logic, but before the view is rendered.
     * @param string $action_name Action name that was called.
     * @param array $arguments Arguments that was passed to action.
     * @return void
     */
    public function beforeRender($action_name, $arguments) {
        $this->locale = core\current_locale();
    }


    /**
     * Called after every controller action, and after rendering is complete.
     * This is the last controller method to run.
     * @param string $action_name Action name that was called.
     * @param array $arguments Arguments that was passed to action.
     * @return void
     */
    public function afterRender($action_name, $arguments) {}

}
