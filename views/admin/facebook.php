
<?php if($this->fb_user): ?>
    <a href="<?php echo $this->logout_url; ?>">Logout</a>
<?php else: ?>
<a id="fb_button" href="<?php echo $this->login_url; ?>">
    <img id="fb_login_image" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_large_long.gif" alt="Connect to Facebook"/>
</a>
<?php endif; ?>



