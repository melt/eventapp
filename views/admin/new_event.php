<?php namespace nmvc; ?>

<div id="stylized" class="myform">
<h1><?php echo _("Add new event"); ?></h1>
<p><?php echo _("Use this form to add a new event to %s.",APP_NAME); ?></p>
<?php $interface = new qmi\ModelInterface("new_event", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_event); ?>
<?php echo $interface->getInterface($this->new_event_invitee); ?>
<button type="submit"><?php echo _("Submit"); ?></button>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>