<?php namespace nmvc; ?>


<div id="stylized" class="myform">
<div id="profile_picture">
    <img src="https://graph.facebook.com/<?php echo $this->fb_user; ?>/picture?type=large">
</div>
<h1><?php echo _("Edit my profile"); ?></h1>
<p><?php echo _("Use this form to edit your profile details for %s.",APP_NAME); ?></p>
<div class="fc_name">
    <label><?php echo _("Name"); ?></label>
    <div class="form_text">
        <?php echo $this->user->getName(); ?>
    </div>
</div>
<?php $interface = new qmi\ModelInterface("user_profile", "cell"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->user); ?>
<button type="submit"><?php echo _("Submit"); ?></button> or <a href="<?php echo url("/"); ?>">Cancel</a>
<div class="spacer"></div>
<?php echo $interface->finalizeForm(false); ?>
</div>