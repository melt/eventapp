<?php namespace melt;

/** Application specific controller. */
abstract class AppController extends Controller {
    // The layout your controllers use by default. Set to /html/html5 for the standard layout.
    public $layout = "/layout";
    public $user = null;

    /**
     * This function is executed before any action in the controller.
     * It's a handy place to check for an active session or
     * inspect user permissions.
     * @param string $action_name Action name about to be called.
     * @param array $arguments Arguments that will be passed to action.
     * @return void
     */
    public function beforeFilter($action_name, $arguments) {
        include_once '../vendors/facebook-php-sdk/src/facebook.php';
        $this->facebook = new \Facebook(array(
          'appId'  => FACEBOOK_APP_ID,
          'secret' => FACEBOOK_APP_SECRET,
          'cookie' => true,
        ));
        /* Check if Facebook user exists in database */
        $this->fb_user = $this->facebook->getUser();
        $this->user = \melt\userx\UserModel::select()->where("facebook_user")->is($this->fb_user)->first();
        $this->login_url = $this->facebook->getLoginUrl(array('redirect_uri' => url("/outside/login"), 'canvas' => 1, 'display' =>'page', 'fbconnect' => 0, 'scope' => 'user_about_me,user_birthday,user_location,user_work_history,email,user_website,user_checkins,user_status'));
        $this->logout_url = $this->facebook->getLogoutUrl(array('next' => url("/outside/logout")));        
    }

    /**
     * Called after controller action logic, but before the view is rendered.
     * @param string $action_name Action name that was called.
     * @param array $arguments Arguments that was passed to action.
     * @return void
     */
    public function beforeRender($action_name, $arguments) {}

    /**
     * Called after every controller action, and after rendering is complete.
     * This is the last controller method to run.
     * @param string $action_name Action name that was called.
     * @param array $arguments Arguments that was passed to action.
     * @return void
     */
    public function afterRender($action_name, $arguments) {}
    
    /**
     * Handles URL rewriting and routes to desired controllers.
     * @param array $path_tokens Path entered in the URL.
     * @return array $path_tokens Path to rewrite to.
     */
    public static function rewriteRequest($path_tokens) {
        if($path_tokens[0] == "" && userx\get_user() == null){
                \melt\request\redirect("/outside");
        }
        else if ($path_tokens[0] == "") {
            return array("inside", "");
        } else if (method_exists("melt\InsideController", $path_tokens[0])) {
            array_unshift($path_tokens, "inside");
            return $path_tokens;
        } else if ($path_tokens[0] === "inside") {
            return false;
        }
    }
}