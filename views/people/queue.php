<?php namespace melt; ?>
<?php echo data_tables\render_table(
        "queue", 
        'melt\userx\UserModel', 
        array(),
        array("bPaginate"=>false,"bSearch"=>true,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>true),
        expr("user_type")->is(0)
        ); ?>