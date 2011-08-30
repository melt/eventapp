<?php namespace melt; ?>
<h2>People</h2>
<p>This is a list of every person that has attended a Sandbox event.
<?php echo data_tables\render_table(
        "people", 
        'melt\userx\UserModel', 
        array(),
        array("bPaginate"=>true,"bSearch"=>true,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>true),
        expr("user_type")->isnt(0)
        ); ?>