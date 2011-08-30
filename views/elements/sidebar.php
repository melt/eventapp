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


<h3>Next Events</h3>

<?php foreach($this->sidebar_events as $event):  ?>
    <p><?php echo $event->view('title'); ?> on <?php echo $event->view('event_date'); ?><br/>
    <em><?php echo $event->hub; ?> Hub</em></p><br/>
<?php endforeach; ?>

<?php endif;?>