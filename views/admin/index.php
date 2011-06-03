<?php namespace nmvc; ?>



<?php if ($this->fb_user && $this->user): ?>
<div id="stylized" class="myform">
<h1><?php echo _("Main Menu"); ?></h1>
<p><?php echo _("Select the action you wish to perform in %s.",APP_NAME); ?></p>

<a class="navigation_button" href="<?php echo $this->logout_url; ?>"><?php echo _("Logout"); ?></a>

<a class="navigation_button" href="<?php echo url("/admin/my_profile"); ?>"><?php echo _("Edit my profile"); ?></a>

<a class="navigation_button" href="<?php echo url("/admin/new_hub"); ?>"><?php echo _("Add new hub"); ?></a>

<a class="navigation_button" href="<?php echo url("/admin/new_event"); ?>"><?php echo _("Add new event"); ?></a>
<br/><br/>
</div>
<br/><br/>
    <script>
        $(function() {
            $( "#tabs" ).tabs({cookie: {path: '/', domain: <?php echo string\quote(APP_ROOT_HOST); ?>}});
        });
    </script>



    <div class="demo">

        <div id="tabs">
            <ul>
                <?php if($this->unmoderated_users->count() > 0): ?>
                <li><a href="#tabs-1"><?php echo _("Users to Moderate (%s)",$this->unmoderated_users->count()); ?></a></li>
                <?php endif; ?>
                
                <li><a href="#tabs-2"><?php echo _("Events"); ?></a></li>
                <li><a href="#tabs-3"><?php echo _("Hubs"); ?></a></li>
                
                <li><a href="#tabs-4"><?php echo _("Members"); ?></a></li>
                <li><a href="#tabs-5"><?php echo _("Non-Members"); ?></a></li>


            </ul>
            <div id="tabs-1">

<?php if($this->unmoderated_users->count() > 0): ?>
 <?php
            AjaxController::invoke("_print_instances_list", array(
                        $this->unmoderated_users,
                        _("Users to Moderate (%s)",$this->unmoderated_users->count())." <i>" . _("Select the role that each of the below users shall have in %s",APP_NAME) . "</i>",
                        "/static/img/user.png",
                        "moderation_list"), true);
            ?>
<?php endif; ?>


        </div>
        <div id="tabs-2">
          
 <?php
            AjaxController::invoke("_print_instances_list", array(
                        HubModel::select()->orderBy("city", "asc"),
                        _("Hubs"),
                        "/static/img/home.png",
                            ), true);
            ?>
           



        </div>
        <div id="tabs-3">

            <?php
            AjaxController::invoke("_print_instances_list", array(
                        EventModel::select()->orderBy("event_date", "asc"),
                        _("Events"),
                        "/static/img/calendar-blue.png",
                            ), true);
            ?>



        </div>

        <div id="tabs-4">

<?php
            AjaxController::invoke("_print_instances_list", array(
                        userx\UserModel::select()->where("group->context")->isnt(\nmvc\userx\GroupModel::CONTEXT_GUEST),
                        _("Members"),
                        "/static/img/user.png",
                        "user_list"), true);
?>

        </div>


                    <div id="tabs-5">

<?php
            AjaxController::invoke("_print_instances_list", array(
                        userx\UserModel::select()->where("group->context")->is(\nmvc\userx\GroupModel::CONTEXT_GUEST),
                        _("Non-Members"),
                        "/static/img/user.png",
                        "guest_list"), true);
?>

        </div>
    </div>

</div><!-- End demo -->






<?php else: ?>

                <div class="center_content">
                    <a id="fb_button" href="<?php echo $this->login_url; ?>">
                        <img id="fb_login_image" src="http://static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_large_long.gif" alt="Connect to Facebook"/>
                    </a>

                    <h3><a href="<?php echo url("/admin/spec"); ?>">High Level Specification</a></h3>
                    <h3><a href="<?php echo url("/reports/r20110507"); ?>">Status Check 2011-05-07</a></h3>
                </div>

<?php endif; ?>