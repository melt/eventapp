<?php namespace nmvc; ?>

<h2><?php echo _("Editing %s",$this->event->title); ?></h2>

<?php $interface = new qmi\ModelInterface("event_edit", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->event); ?>
<?php echo $interface->finalizeForm(true); ?>