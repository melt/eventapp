<?php namespace nmvc; ?>

<div id="stylized" class="myform">
    <h1><?php echo _("Main Menu"); ?></h1>
    <p><?php echo _("Select the action you wish to perform in %s.", APP_NAME); ?></p>

    <a class="navigation_button" href="<?php echo $this->logout_url; ?>"><?php echo _("Logout"); ?></a>
    
    <a class="navigation_button" href="<?php echo url("/inside/my_profile"); ?>"><?php echo _("Edit my profile"); ?></a>

    <?php if($this->user->isAdmin()): ?>
    <a class="navigation_button" href="<?php echo url("/hub/add"); ?>"><?php echo _("Add new hub"); ?></a>
    <?php endif; ?>

    <?php if($this->user->isAmbassador()): ?>
    <a class="navigation_button" href="<?php echo url("/event/new_event"); ?>"><?php echo _("Add new event"); ?></a>
    <?php endif; ?>
    
</div>
