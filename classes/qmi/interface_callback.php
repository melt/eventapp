<?php namespace nmvc\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {

    public function ic_add_invitees_by_email() {
        $instances = $this->getInstances();
        $instance = $instances['nmvc\EventInviteeModel'][0];
        // Break up list of emails into an array
        $email_array = explode(",",$instance->list_of_emails);

        foreach($email_array as $email){
            $email = trim($email);
            if (!\nmvc\string\email_validate($email))
                break;
            $invitee = new \nmvc\EventInviteeModel();
            // Every invitee belongs to this event
            $invitee->event = $instance->event;
            // Take the current email address
            $invitee->email = $email;  
            $invitee->store();
        }
    }
    
    public function ic_rvsp_page() {
        $this->validate();
        $this->store();
        // Redirect to thankyou page if save succeeds
        \nmvc\messenger\redirect_message(url("/admin/thanks"), _("Thank you for your RVSP!"), "good");
    }

}
