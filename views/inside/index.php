<?php namespace melt; ?>
<h2>My Profile</h2>
<p>
   These are your details in the Sandbox database.
</p>




<?php $interface = new qmi\ModelInterface("my_profile"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->user); ?>
<?php echo $interface->finalizeForm(true); ?>


