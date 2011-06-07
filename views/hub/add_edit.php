<?php namespace nmvc; ?>

<div id="stylized" class="myform">
<h1><?php echo ($this->hub->id != 0)? _("Edit"): _("Add new"); ?> <?php echo _("hub"); ?></h1>
<p><?php echo _("Use this form to"); ?> <?php echo ($this->hub->id != 0)? _("edit the hub <b>%s</b>.",$this->hub->city): _("add a new hub to %s.",APP_NAME); ?></p>
<?php $interface = new qmi\ModelInterface("new_hub", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->hub); ?>
<?php echo $interface->getInterface($this->hub_ambassador); ?>
<button type="submit"><?php echo _("Submit"); ?></button> or <a href="<?php echo url("/"); ?>">Cancel</a>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>