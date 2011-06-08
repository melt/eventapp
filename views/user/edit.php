<?php namespace nmvc; ?>


<div id="stylized" class="myform">
<h1><?php echo _("Edit %s",$this->edit_user->getName()); ?></h1>
<p><?php echo _("Use this form to edit the user details."); ?></p>
<?php $interface = new qmi\ModelInterface("user_edit", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->edit_user); ?>
<button type="submit"><?php echo _("Submit"); ?></button> or <a href="<?php echo url("/"); ?>">Cancel</a>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>