<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_add_invitees_by_email() {
        $this->doValidate();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Break up list of emails into an array
        $email_array = explode(",",$instance->list_of_emails);
        $include_members = $instance->include_members_in_hub;

        // If true, add hub members as invitees
        if($include_members == true){
            $members = \nmvc\userx\UserModel::select()->where("hub")->is($instance->event->hub);
            foreach($members as $member){
                 $invitee = new \nmvc\EventInviteeModel();
                 $invitee->event = $instance->event;
                 $invitee->invitee = $member;
                 $invitee->store();
            }
        }

        foreach($email_array as $email){
            $email = trim($email);
            if (!\nmvc\string\email_validate($email))
                break;
            // Create a new invitee to the event
            $invitee = new \nmvc\EventInviteeModel();
            $invitee->event = $instance->event;

            // Connect to existing user if he/she already exists
            $user = \nmvc\userx\UserModel::select()->where("username")->is($email)->first();
            // User does not exist
            if($user->count() == 0){
                // Create a user to get the id
                $user = new \nmvc\userx\UserModel();
                $user->username = $email;
            }
            // Attach that id to the invitee before store
            $invitee->invitee = $user;
            // Store both
            $invitee->store();
            $user->store();
            
        }
    }
    
    public function ic_rvsp_page() {
        $this->doValidate();
        $this->doStore();
        $instances = $this->getInstances();
        $invitee = $instances['nmvc\EventInviteeModel'][0];
        // Redirect to thankyou page if save succeeds
        \nmvc\messenger\redirect_message(url("/outside/rvsp_thanks/", array( "rvsp" => $invitee->rvsp, "email" => $invitee->invitee->username) ), _("Thank you for your RVSP!"), "good");
    }

    public function ic_user_profile() {
        $this->doValidate();
        $this->doStore();
        \nmvc\messenger\redirect_message(url("/"), _("Your profile was updated!"), "good");
    }

}
