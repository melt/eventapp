<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_add_invitees_by_email() {
        $this->doValidate();
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Break up list of emails into an array
        $email_array = explode(",",$instance->list_of_emails);

        foreach($email_array as $email){

            $email = trim($email);
            if (!\nmvc\string\email_validate($email))
                break;
            // Create a new invitee to the event
            $invitee = new \nmvc\EventInviteeModel();
            $invitee->event = $instance->event;
            // Create a user to get the id
            $user = new \nmvc\userx\UserModel();
            $user->username = $email;
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
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Redirect to thankyou page if save succeeds
        \nmvc\messenger\redirect_message(url("/outside/rvsp_thanks",array("rvsp"=>$instance->rvsp,"email"=>$instance->invitee->username)), _("Thank you for your RVSP!"), "good");
    }

    public function ic_user_profile() {
        $this->doValidate();
        $this->doStore();
        \nmvc\messenger\redirect_message(url("/"), _("Your profile was updated!"), "good");
    }

}
