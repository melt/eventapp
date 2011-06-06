<?php namespace nmvc; ?>


<Add a teaser (one sentence of the overall topic of the evening, for example “April’s
Fools”, “Summer dinner”; exciting special guests; etc.)>

Please confirm your participation as soon as possible. You will receive a confirmation
email with the name of the location a couple of days beforehand.




<div id="stylized" class="myform">
<h1><?php echo _("Add new event"); ?></h1>
<p><?php echo _("Use this form to add a new event to %s.",APP_NAME); ?></p>
<?php $interface = new qmi\ModelInterface("new_event", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_event); ?>
<button href="<?php echo qmi\get_action_link($this->new_event, "addEventAndContinue"); ?>" role="button" aria-disabled="false"><?php echo _("Next Step"); ?></button> or <a href="<?php echo url("/"); ?>">Cancel</a>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>