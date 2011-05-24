<?php namespace nmvc; ?>


<?php if($this->fb_user && $this->user): ?>
    <a href="<?php echo $this->logout_url; ?>">Logout</a>
    <img src="https://graph.facebook.com/<?php echo $this->fb_user; ?>/picture">

    <?php $interface = new qmi\ModelInterface("user_profile", "cell"); ?>
    <?php echo $interface->startForm(); ?>
    <?php echo $interface->getInterface($this->user); ?>
    <?php echo $interface->finalizeForm(true); ?>

<?php else: ?>
<a id="fb_button" href="<?php echo $this->login_url; ?>">
    <img id="fb_login_image" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_large_long.gif" alt="Connect to Facebook"/>
</a>

<h3><a href="<?php echo url("/admin/spec"); ?>">High Level Specification</a></h3>
<h3><a href="<?php echo url("/reports/r20110507"); ?>">Status Check 2011-05-07</a></h3>


<?php endif; ?>