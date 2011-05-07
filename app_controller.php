<?php namespace nmvc;

/** Application specific controller. */
abstract class AppController extends Controller {
    // The layout your controllers use by default.
    public $layout = "/layout";

    public function getTitle() {
        return APP_NAME;
    }
    
    public static function rewriteRequest($path_tokens) {
            if($path_tokens[0] == "" || $path_tokens[0]=="admin"){
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
    public function beforeFilter($action_name, $arguments) {}

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

}
