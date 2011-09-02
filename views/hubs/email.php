<?php namespace melt; ?>
<?php if($this->email->members_only == true): ?>
<h2>Members of <?php echo $this->hub->view('city'); ?></h2>
<p>This is a list of all the <strong><?php echo $this->hub->getMemberCount(); ?></strong> members of the <strong><?php echo $this->hub->view('city'); ?></strong> hub.</p>
<?php echo data_tables\render_table(
        "queue", 
        'melt\userx\UserModel', 
        array(),
        array("bPaginate"=>true,"bSearch"=>true,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>true),
        expr('country')->is($this->hub->country)->and("user_type")->isntLessThan(7)
        ); ?>
<?php else: ?>
<h2>Community of <?php echo $this->hub->view('city'); ?></h2>
<p>This is a list of the entire community of <strong><?php echo $this->hub->getCommunityCount(); ?></strong> people in the <strong><?php echo $this->hub->view('city'); ?></strong> hub.</p>
<?php echo data_tables\render_table(
        "queue", 
        'melt\userx\UserModel', 
        array(),
        array("bPaginate"=>true,"bSearch"=>true,"bFilter"=>true,"bJQueryUI"=>false,"bInfo"=>true),
        expr('country')->is($this->country)
        ); ?>
<?php endif; ?>


<?php if($this->email->members_only == true): ?>
<h2>Email Members</h2>
Use this form to email all the <strong><?php echo $this->hub->getMemberCount(); ?></strong> members of the <strong><?php echo $this->hub->view('city'); ?></strong> hub.
<?php else: ?>
<h2>Email Community</h2>
Use this form to email the entire community of <strong><?php echo $this->hub->getCommunityCount(); ?></strong> people in the <strong><?php echo $this->hub->view('city'); ?></strong> hub.
<?php endif; ?>
<?php $interface = new qmi\ModelInterface("send_email"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->email); ?>
<input type="submit" value="Send Email" />
<?php echo $interface->finalizeForm(false); ?>