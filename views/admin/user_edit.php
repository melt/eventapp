<?php namespace nmvc; ?>

<h2><?php echo _("Editing %s",$this->user->getName()); ?></h2>

<?php $interface = new qmi\ModelInterface("user_edit", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->user); ?>
<?php echo $interface->finalizeForm(true); ?>