<?php namespace melt; ?>
<h2>Queue</h2>
<p>This is a queue of all people that have been invited to events but not yet identified by type of person. This list is only visible for administrators.</p>
<?php echo data_tables\render_table(
        "queue", 
        'melt\userx\UserModel', 
        array(),
        array("bPaginate"=>false,"bSearch"=>true,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>true),
        expr("user_type")->is(0)
        ); ?>