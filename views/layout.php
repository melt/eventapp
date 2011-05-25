<?php namespace nmvc; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $this->getTitle(); ?></title>
        <link href="<?php echo url("/static/img/favicon.ico"); ?>" type="image/x-icon" rel="shortcut icon" />
        <link href="<?php echo url("/static/style.css"); ?>" media="screen" rel="stylesheet" type="text/css" />
        <?php echo $this->head; // head Layout Section  ?>
    </head>
    <body>
        <div id="logo">
            <a href="<?php echo url("/"); ?>"><img src="<?php echo url("/static/img/sandbox-logo.png"); ?>" alt="" /></a>
        </div>
        <div id="content">
            <?php echo $this->content; ?>
        </div>
    </body>
</html>