<?php namespace melt; ?>
<h2>Hubs</h2>
<p>This is a list of all the hub cities in the Sandbox Network. <a href="<?php echo url("/hubs/add_edit/"); ?>">Add a new hub</a></p>
<?php echo data_tables\render_table("hubs", 'melt\HubModel', array(),array("bPaginate"=>false,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>true));