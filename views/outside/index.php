<?php namespace nmvc; ?>



<div id="stylized" class="myform">
<h1><?php echo _("Welcome to %s",APP_NAME); ?></h1>
<p><?php echo _("Use the button below to login. You will then be able to perform further actions. If you have questions about %s or feedback please contact %s",APP_NAME,APP_EMAIL); ?></p>

<div class="center_content">

<a id="fb_button" href="<?php echo $this->login_url; ?>"><img id="fb_login_image" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_large_long.gif" alt="Connect to Facebook"/></a>
  

   <!-- <h3><a href="<?php echo url("/outside/spec"); ?>">High Level Specification</a></h3> -->
</div>

</div>


