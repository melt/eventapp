<?php namespace nmvc; ?>
<?php $this->layout->enterSection("direct_content"); ?>
    <div class="ajax_list_container">
        <div class="ajax_list" id="<?php echo $this->uuid("al"); ?>">
            <div class="ajax_list_title">
                <?php if ($this->icon != ""): ?>
                    <img src="<?php echo $this->icon; ?>" alt="" />
                <?php endif; ?>
                <?php echo $this->title; ?>
                <img alt="" src="<?php echo url("/static/img/ajax-loader-00.gif"); ?>" class="ajax_list_refresh_pending" style="display: none;" />
                <a class="ajax_list_refresh" href="<?php echo $this->refresh_url; ?>">
                    <?php echo _("Refresh"); ?>
                </a>
            </div>
            <?php if ($this->table_data != ""): ?>
                <table class="ajax_list_table">
                    <?php echo $this->table_data; ?>
                </table>
            <?php else: ?>
                <i><?php echo _("No items to display."); ?></i>
            <?php endif; ?>
            <script type="text/javascript">
                $(function() {
                    var ajax_list = $("#" + "<?php echo $this->uuid("al"); ?>");
                    ajax_list.find(".ajax_list_refresh").click(function() {
                        if (!$(this).is(":visible"))
                            return false;
                        var refresh_btn = this;
                        $(refresh_btn).hide();
                        ajax_list.find(".ajax_list_refresh_pending").show();
                        setTimeout(function() {
                            $.ajax({
                                async: true,
                                dataType: "html",
                                success: function(data) {
                                    var container = ajax_list.parent();
                                    ajax_list.replaceWith(data);
                                    ajax_list = $(container).find(".ajax_list");
                                    // Remove container.
                                    $(container).find(".ajax_list_container").replaceWith(ajax_list);
                                    $(container).trigger("refresh");
                                },
                                url: $(refresh_btn).attr("href")
                            });
                        });
                        return false;
                    });
                    <?php /*
                    ajax_list.find(".list_action a.button[href^=http]").click(function() {
                        $("#please-wait-dialog").dialog("open");
                        $.ajax({
                            async: true,
                            error: function() {
                                $("#please-wait-dialog").dialog("close");
                            },
                            success: function(data) {
                                $("#please-wait-dialog").dialog("close");
                                ajax_list.find(".ajax_list_refresh").click();
                            },
                            url: $(this).attr("href")
                        });
                        return false;
                    });*/ ?>
                });
            </script> 
        </div>
    </div>
<?php $this->layout->exitSection(); ?>