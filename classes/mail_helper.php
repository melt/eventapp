<?php namespace melt;

class MailHelper {

    /**
     * Renders an email according to the standard layout.
     * @param string $mail_template One of the templates in /mail/.
     * @param array $view_variables
     * @param string $subject Subject of mail, not including any prefixes.
     * @param mixed $email_to Email address or User to email to.
     */
    static function sendMail($mail_template, $view_variables, $subject, $email_to, $plaintext_mail = false, $email_bcc = array()) {
        $mailer = new mail\Mailer();
        $mailer->from->set(APP_EMAIL, APP_NAME);
        if (\is_string($email_to)) {
            $email_name = "";
        } else if ($email_to instanceof userx\UserModel) {
            $email_name = $email_to->getName();
            $email_to = $email_to->username;
        } else
            trigger_error("\$email_to to unknown.", \E_USER_ERROR);
        // Render the mail.
        if (!is_array($view_variables))
            $view_variables = array();
        $view_variables['email_to'] = $email_to;
        $view_variables['email_name'] = $email_name;
        $view_variables['title'] = $subject;
        $view_variables['layout'] = $plaintext_mail? "/mail/layout_plaintext": "/mail/layout";
        $content = View::render("/mail/$mail_template", $view_variables);
        // Configure the mailer.
        if (isset($view_variables["attachments"])) {
            foreach ($view_variables["attachments"] as $attachment)
                $mailer->attachFile($attachment[0], $attachment[1]);
        }
        $mailer->to->add($email_to, $email_name);
        // Always bcc the user that is sending the email
        foreach($email_bcc as $bcc){
            $mailer->bcc->add($bcc->username,$bcc->getName());
        }

        $mailer->subject = $subject;
        // Send mail.
        if ($plaintext_mail) {
            $mailer->mailPlain($content);
        } else {
            // Convert css tags to inline to work in mail clients
            $content = MailHelper::convertCSSToInline($content, View::render("/elements/mail_css_include"));
            $mailer->mailHTML($content);
        }
    }
    
    private static function convertCSSToInline($content,$stylesheet) {
        /* Input should be HTML */
        $css_to_inline = new \melt\InlineCssHelper($content, $stylesheet);
        $processedHTML = $css_to_inline->convert();
        return $processedHTML;
    }


}