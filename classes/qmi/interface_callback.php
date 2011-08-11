<?php namespace melt\qmi;
/* Auto generated empty class override. */


class InterfaceCallback extends InterfaceCallback_app_overrideable {
	
    /* Custom interface callback for contact form - instead of saving instance to database */
    public function ic_contact_form() {
        // Validate the form
        $this->doValidate();
        // Get the form instance
        $instances = $this->getInstances();
        $instance = $instances['melt\ContactFormModel'][0];
        // Generate the email
        $mailer = new \melt\mail\Mailer();
        $mailer->to->add("team@meltframework.org", "The Melt Framework Team");
        $mailer->subject = "Melt Default Application Contact Form";        
        $mailer->from->set($instance->name,$instance->email);
        // Send the email in plaintext, mailHTML is also available
        $mailer->mailPlain($instance->message);        
    }
}
