<?php namespace nmvc; ?>

<?php echo _("#### You are receiving this email as you have administrator privileges to the %s application ###",\nmvc\APP_NAME); ?>


<?php echo _("%s with email %s has just logged into %s using Facebook and needs permissions to be able to proceed.",$this->name,$this->email,\nmvc\APP_NAME); ?>


<?php echo _("Login to %s to grant the user permissions.",\APP_ROOT_URL); ?>