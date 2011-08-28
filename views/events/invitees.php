<?php namespace melt; ?>
<script type="text/javascript">
    $(document).ready(function() {


        /*
         * Gives hints if user can be found in database and completes names and emails
         **/
        $('.c_search_invitee textarea').autocomplete("<?php echo url("/search_invitee"); ?>", {
                width: 300,
                delay: 50,
                multiple: true,
		autoFill: true,
                matchContains: true,
                selectFirst: true,
                minChars: 0,
		formatItem: formatItem,
		formatResult: formatResult

	});
	function formatItem(row) {
		return row[0] + "\n";
	}
	function formatResult(row) {
                return row[1];
		//return row[0].replace(/(<.+?>)/gi, '');
	}
	$('.c_search_invitee textarea').result(function(event, data, formatted) {
		var hidden = $(this).parent().next().find(">:textarea");
		hidden.val( (hidden.val() ? hidden.val() + ";" : hidden.val()) + data[1]);
	});
	$('#previous_step').click(function() {
                window.location.href = $("#previous_step").attr("href");
	});

  });
</script>

<h2>Add Invitees to <?php echo $this->event->title; ?></h2>

<?php echo $this->display("events_breadcrumb",array("events_breadcrumb"=>$this->events_breadcrumb)); ?>

<p>Add some people to the list of invitees.</p>
<?php $interface = new qmi\ModelInterface("invitees"); ?>
<?php echo $interface->startForm(); ?>
<?php echo $interface->getInterface($this->new_event_invitee,"list"); ?>
<input type="submit" value="Add to List of Invitees" />
<?php echo $interface->finalizeForm(false); ?>


<h2>List of Invitees</h2>
<p>The following people will receive invitations to this event.</p>
<?php echo data_tables\render_table("invitees", 'melt\EventInviteeModel', array(),array("bPaginate"=>false,"bSearch"=>false,"bFilter"=>false,"bJQueryUI"=>false,"bInfo"=>true)); ?>

<input id="previous_step" href="/events/details/<?php echo $this->event->hub->id; ?>/<?php echo $this->event->id; ?>" type="submit" value="Previous Step" /> or <input type="submit" value="Next Step" /> 