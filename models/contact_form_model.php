<?php namespace melt;

class ContactFormModel extends AppModel implements qmi\UserInterfaceProvider {

    public $name = array(VOLATILE,'core\TextType', 128);
    public $email = array(VOLATILE,'core\TextType', 128);
    public $message = array(VOLATILE,'core\TextAreaType');
    
    public static function uiGetInterface($interface_name, $field_set) {
        switch ($interface_name) {
            case "contact_form":
                return array(
                    "name" => _("Name"),
                    "email" => _("Email Address"),
                    "message" => _("Message")
                );
        }
    }
    
    public function uiValidate($interface_name) {
        $err = array();
        foreach (array(
        "name", "message"
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
}