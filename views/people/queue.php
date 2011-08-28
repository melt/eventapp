<?php namespace melt; ?>
<?php echo data_tables\render_table("queue", 'melt\userx\UserModel', array(),array("bPaginate"=>false,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>false));