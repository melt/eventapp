<?php namespace melt; ?>
<h2>Events</h2>
<p>This is a list of all events in the Sandbox Network. <a href="<?php echo url("/events/details"); ?>">Add a new event</a></p>
<?php echo data_tables\render_table("overview", 'melt\EventModel', array(),array("bPaginate"=>false,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>false));