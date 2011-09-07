<?php namespace melt\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {
	
    /* Custom interface callback for contact form - instead of saving instance to database */
    public function ic_event_details() {
        // Validate the form
        $this->doValidate();
        // Store the results
        $this->doStore();
        $instances = $this->getInstances();
        $event = $instances['melt\EventModel'][0];
        
        if( $event->closed_event == \melt\EventModel::CLOSED_FOR_MEMBERS || $event->closed_event == \melt\EventModel::CLOSED_FOR_EVERYONE ){
        // Add hub members to list as of default
        $members = $event->hub->getMembers();
            foreach($members as $member){
                $invitee = new \melt\EventInviteeModel;
                $invitee->invitee = $member;
                $invitee->event = $event;
                $invitee->store();
            }
        }
        
        \melt\request\redirect( url("/events/invitees/". $event->id ) );  
    }
    
    public function ic_invitees() {
        $instances = $this->getInstances();
        $invitees = $instances['melt\EventInviteeModel'][0];
        $emails = explode(",", $invitees->email_addresses);
        foreach($emails as $email){
                $email = trim($email);
                $user = \melt\userx\UserModel::select()->where("username")->isLike("%".$email."%")->first();
                // Only save to invitees if we have a correct email address
                if(\melt\string\email_validate($email)){
                    if($user == null){
                        $user = new \melt\userx\UserModel();
                        $user->username = $email;
                        $user->country = $invitees->event->hub->country;
                        $user->store();
                    }
                    $invitee = new \melt\EventInviteeModel();
                    $invitee->invitee = $user;
                    $invitee->event = $invitees->event;
                    $invitee->store();
                }
        }
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
