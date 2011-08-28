<?php namespace melt\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {
	
    /* Custom interface callback for contact form - instead of saving instance to database */
    public function ic_events_details() {
        // Validate the form
        $this->doValidate();
        // Store the results
        $this->doStore();
        $instances = $this->getInstances();
        $event = $instances['melt\EventModel'][0];
        \melt\request\redirect( url("/events_invitees/". $event->id ) );  
    }
    
    public function ic_user_details() {
        // Validate the form
        $this->doValidate();
        // Store the results
        $this->doStore();
        \melt\request\redirect( url("/people") );  
    }
    
    public function ic_hub_details() {
        // Validate the form
        $this->doValidate();
        // Store the results
        $this->doStore();
        \melt\request\redirect( url("/hubs") );  
    }
    
    public function ic_user_type() {
        // Validate the form
        $this->doValidate();
        // Store the results
        $this->doStore();
        $queue_count = \melt\userx\UserModel::select()->where("user_type")->is(0)->count();
        if($queue_count != 0){
        // Still got users to moderate
            \melt\request\redirect( url("/people/queue") ); 
        } else {
        // Moderation complete
            \melt\request\redirect( url("/people") ); 
        }
    }
    
    public function ic_send_email() {
        // Validate the form
        $this->doValidate();
        $instances = $this->getInstances();
        $email = $instances['melt\SendEmailModel'][0];
        \melt\SendEmailModel::sendEmailToHub($email);
        \melt\messenger\redirect_message("/hubs","Message was successfully sent!","good");
    }
}
