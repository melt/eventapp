<?php namespace nmvc; ?>

<div id="stylized" class="fullwidth">
    <h1><?php echo _("Welcome to %s!",APP_NAME); ?></h1>
    <p><?php echo _("Select the action you wish to perform."); ?></p>

    <a class="navigation_button" href="<?php echo $this->logout_url; ?>"><?php echo _("Logout"); ?></a>
    
    <a class="navigation_button" href="<?php echo url("/inside/my_profile"); ?>"><?php echo _("Edit my profile"); ?></a>

    <?php if( $this->user->isAmbassador() || $this->user->isAdmin() || $this->user->isSuperAdmin() ): ?>
    <a class="navigation_button" href="<?php echo url("/event/add_edit"); ?>"><?php echo _("Add new event"); ?></a>

    <a class="navigation_button" href="<?php echo url("/hub/add_edit"); ?>"><?php echo _("Add new hub"); ?></a>
    <?php endif; ?>
    <br/><br/>
</div>

<br/><br/>
<?php if( $this->user->isAmbassador() || $this->user->isAdmin() || $this->user->isSuperAdmin() ): ?>
 <script>
        $(function() {
            $( "#tabs" ).tabs({cookie: {path: '/', domain: <?php echo string\quote(APP_ROOT_HOST); ?>}});
        });
    </script>

    <div class="demo">
        <?php $users_to_moderate = userx\UserModel::select()->where("is_moderated")->is(false)->count(); ?>
        <div id="tabs">
            <ul>
                <?php if( ($this->user->isAdmin() || $this->user->isSuperAdmin()) && $users_to_moderate > 0): ?>
                    <li><a href="#tabs-1"><?php echo _("New Users to Moderate (%s)",$users_to_moderate); ?></a></li>
                <?php endif; ?>
                <li><a href="#tabs-2"><?php echo _("Events"); ?></a></li>
                <li><a href="#tabs-3"><?php echo _("Hubs"); ?></a></li>
                <li><a href="#tabs-4"><?php echo _("Sandbox Members"); ?></a></li>
                <li><a href="#tabs-5"><?php echo _("Event Guests"); ?></a></li>
            </ul>

        <?php if( ($this->user->isAdmin() || $this->user->isSuperAdmin()) && $users_to_moderate > 0): ?>
        <div id="tabs-1">

        <?php data_tables\list_model_lite("nmvc\userx\UserModel", null, null, null, db\expr("is_moderated")->is( false ), array(
            "first_name" => "First Name",
            "last_name" => "Last Name",
            "username" => "Email",
            "set_permissions" => "Who is this person?"
        ) ); ?>


        </div>
        <?php endif; ?>


        <div id="tabs-2">


        <?php data_tables\list_model("nmvc\EventModel", "/event/add_invitees", "event/add_edit", "", null, null, true, array()); ?>


        </div>
        <div id="tabs-3">

        <?php data_tables\list_model("nmvc\HubModel", null, "hub/add_edit", null, null, null, true); ?>




        </div>

        <div id="tabs-4">

        <?php data_tables\list_model("nmvc\userx\UserModel", null, "user/edit", null, db\expr("group->context")->isnt( userx\GroupModel::CONTEXT_GUEST )->and("is_moderated")->is( true ), null, true ); ?>


        </div>


        <div id="tabs-5">

        <?php data_tables\list_model("nmvc\userx\UserModel", null, "user/edit", null, db\expr("group->context")->is( userx\GroupModel::CONTEXT_GUEST )->and("is_moderated")->is( true ), null, true ); ?>


        </div>
    </div>

</div><!-- End demo -->


<?php endif; ?>
<br/>