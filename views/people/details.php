<?php namespace melt; ?>
<h2>Details for <?php echo $this->user->getName(); ?></h2>
<?php $interface = new qmi\ModelInterface("user_details"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->user); ?>
<?php echo $interface->finalizeForm(true); ?>
