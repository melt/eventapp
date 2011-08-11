<?php namespace melt; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head profile="http://gmpg.org/xfn/11">
        <title><?php echo APP_NAME; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet"  type="text/css" media="screen, projection" href="<?php echo url('static/css/reset.css'); ?>">
        <link rel="stylesheet/less" type="text/css" href="<?php echo url('static/css/style.less'); ?>">
        <?php echo $this->head; ?>
        <?php if($this->fb_user != null): ?>
            <script>
            $(document).ready(function(){
                $('a[href$="#logout"]').attr("href", "<?php echo $this->logout_url; ?>")
            });
            </script>
        <?php endif; ?>
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="social-media"><?php $this->display('social-media'); ?></div>
                <img class="logo" src="<?php echo url('static/images/sandbox-logo.png'); ?>" alt="Sandbox Logo">
            </div>
            <div id="menu">
            <?php echo $this->menu; ?>
            </div>
            <div id="content">
                <div id="main">
                    <?php echo $this->content; ?>
                </div>
                <div id="sidebar">
                   <?php $this->display('sidebar',array("user"=>$this->user)); ?>
                </div>
                <br class="clear" />
            </div>
            
            
        </div>
        

    </body>
</html>