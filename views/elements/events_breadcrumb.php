<?php namespace melt; ?>
<?php $this->layout->enterSection('head'); ?>
<script type="text/javascript">
$(document).ready(function() {
        $('a[href$="#event_details"],a[href$="#event_invitees"],a[href$="#event_invitations"]').click(function(e) {
            e.preventDefault();
            //do other stuff when a click happens
        });
 
  
});
</script>
<?php $this->layout->exitSection(); ?>

            <div class="breadCrumbHolder module">
                <div id="breadCrumb0" class="breadCrumb module">
                    <?php echo $this->events_breadcrumb; ?>
                </div>
            </div>