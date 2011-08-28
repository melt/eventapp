<?php namespace melt;

class SendEmailModel extends AppModel implements qmi\UserInterfaceProvider {
    
    public $name = array(VOLATILE,'core\TextType', 128);
    public $email = array(VOLATILE,'core\TextType', 128);
    public $subject = array(VOLATILE,'core\TextType', 128);
    public $message = array(VOLATILE,'core\TextAreaType');
    /* Hub to send email to*/
    public $hub_id = array(VOLATILE,'core\PointerType', 'HubModel');
    public $members_only = array(VOLATILE,'core\BooleanType');
    
    public static function uiGetInterface($interface_name, $field_set) {
        switch ($interface_name) {
            case "send_email":
                return array(
                    "name" => _("Your Name"),
                    "email" => _("Email Address"),
                    "subject" => _("Subject"),
                    "message" => _("Message")
                );
        }
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "name", "subject", "message"
        ) as $field) {
            $this->$field = trim($this->$field);
            if ($this->$field == "")
                $err[$field] = _("Field must be entered!");
        }
        if (!\melt\string\email_validate($this->email)){
            $err["email"] = "Incorrect email address!";
        }
        return $err;
    }
    
    public static function sendEmailToHub($email){
        if($email->members_only == true){
            $recipients = $email->hub->getMembers();
        } else {
            $recipients = $email->hub->getCommunity();
        }
            
        foreach($recipients as $recipient){
            \melt\MailHelper::sendMail("send_email",
                    array(
                        "message"=>$email->message,
                        "name"=>$email->name,
                        "email"=>$email->email
                    ),
                    $email->subject,
                    $recipient,
                    true,
                    array(),
                    $email->email,
                    $email->name
                    );
        }
    }
    
    

}