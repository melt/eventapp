<?php namespace melt; ?>
<?php /* This view is rendered by MailHelper. */ ?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->title; ?></title>
</head>


<body id="background">
        <table id="outside" border="0" cellspacing="0" cellpadding="0" width="600">
        <tr>
        <td>

        </td>
        </tr>
        </table>
    <table id="layout" border="0" cellspacing="0" cellpadding="0" width="600">
        <tr>
            <td id="header">
            <a href="" target="_blank"><img src="<?php echo url("/static/images/sandbox-logo.png"); ?>" alt="<?php echo _("Sandbox Network") ?>" style="max-width: 600px;"></a>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td id="content">
                <?php echo $this->content; ?>
            </td>
        </tr>
    </table>
    <table id="outside-bottom" width="580">
        <tr>
            <td class="footer">
                <p>&copy; <?php echo date("Y"); ?> Sandbox Network. <?php if(isset($this->unsubscribe_link) && $this->user->isGuest()): ?><a target="_blank" href="<?php echo $this->unsubscribe_link; ?>"><?php echo _("Click on this link"); ?></a> to unsubscribe from all future emails.<?php endif; ?>
                </p>
            </td>
            <td class="footer">
                &nbsp;
            </td>
        </tr>
    </table>
<span style="padding: 0px;"></span>
 </body>
</html>