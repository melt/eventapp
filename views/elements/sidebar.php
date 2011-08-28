<?php namespace melt; ?>
<?php /* For Visitors */ ?>
<?php if( $this->user == null ): ?>

<h3>What is <?php echo APP_NAME; ?>?</h3>
<p>
    <?php echo APP_NAME; ?> is the web based app to manage Sandbox events.
    If you came here a good chance is you have been invited to an event in our of our hubs.
</p>
<p>
    Should you have questions about this application, please contact the <a href="http://www.sandbox-network.com/about/our-team/" target="_blank">Chief Community Manager</a>.
</p>

<?php else: ?>
<?php /* For Logged In Users */ ?>


<h2>Magic Sidebar</h2>
<p> PUT USEFUL INFO HERE, LATEST EVENTS IN THE USER'S COUNTRY PERHAPS ? </p>

<?php endif;?>