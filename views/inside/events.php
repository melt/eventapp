<?php namespace melt; ?>
<h2>Events</h2>
<p>This is a list of all events in the Sandbox community. <a href="<?php echo url("/events_details"); ?>">Add a new event</a></p>
<?php echo data_tables\render_table("overview", 'melt\EventModel', array(),array("bPaginate"=>false,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>false));