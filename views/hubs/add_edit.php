<?php namespace melt; ?>
<h2><?php echo ($this->hub->id==0)? "Add New": "Edit"; ?> Hub</h2>
<?php $interface = new qmi\ModelInterface("hub_details"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->hub); ?>
<?php echo $interface->finalizeForm(true); ?>
