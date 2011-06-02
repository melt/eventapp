<?php namespace nmvc; ?>


<div id="stylized" class="myform">
<img style="max-width:150px;margin-bottom:10px;" src="https://graph.facebook.com/<?php echo $this->fb_user; ?>/picture?type=large">
<h1><?php echo _("Edit my profile"); ?></h1>
<p><?php echo _("Use edit your profile details for %s.",APP_NAME); ?></p>
<?php $interface = new qmi\ModelInterface("user_profile", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->user); ?>
<button type="submit"><?php echo _("Submit"); ?></button>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>