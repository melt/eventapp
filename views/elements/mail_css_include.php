<?php namespace melt; ?>
<style type="text_css">
    body, #background {
        background-color: #e4e4e4;
        text-align:center;
        background-image:url('<?php echo url("/static/img/mail/bg.gif"); ?>');
    }

    #layout {
        -webkit-box-shadow: 0px 0px 20px rgb(160,160,160);
        -moz-box-shadow: 0px 0px 20px rgba(160,160,160);
        border: 0px solid #999999;
        background:#ffffff;
        margin: 10px auto;
        text-align:left;
    }

    #outside {
        margin: 10px auto;
        text-align:left;
    }

    #outside-bottom {
        margin: 10px auto;
        text-align:left;
    }

    #header {
        background-color:#ffffff;
        padding: 0px;
        text-align: center;
        padding-top:15px;
    }

    #content, #partners, #speakers, #partner {
        font-size: 13px;
        color: #333333;
        font-style: normal;
        font-weight: normal;
        font-family: Helvetica;
        line-height: 1.35em;
        vertical-align:top;
    }

    #content {padding: 10px 30px 25px 30px;}

    #partners {
        background:rgb(250,250,250);
        background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgb(250,250,250)), to(rgb(240,240,240)));
        padding: 12px 30px 10px 30px;
        border-top: 1px solid rgb(234,234,234);}

    #partners p {text-align:center}

    #partners td {padding:0; margin:0}
    #partners .partners-title {
        text-align:center;
        color: rgb(160,160,160);
        font-size:11px;
        text-shadow: rgba(255,255,255,0.8) 0px 1px 0px;
        text-transform: uppercase;
    }

    #speakers .col-1 {
        padding-right:5px;
        padding-bottom:12px;
    }

    #speakers {
        padding-top:5px;
    }

    #speakers .col-2 {
        text-align: left;
        vertical-align:top;
    }

    #partner .col-1 {
        padding-right:5px;
        padding-bottom:12px;
        }

    #partner {
        padding-top:5px;
    }

    #partner .col-2 {
        text-align: left;
        vertical-align:top;
    }

    .primary-heading {
        font-size: 25px;
        font-weight: bold;
        color: #000000;
        font-family: Helvetica;
        line-height: 125%;
        margin: 6px 0 0 0;
        letter-spacing:-1px;
    }

    .secondary-heading {
        font-size: 20px;
        font-weight: bold;
        color: #000000;
        font-style: normal;
        font-family: Helvetica;
        margin: 20px 0 5px 0;
        padding-top:18px;
        border-top: 1px solid rgb(230,230,230);
        line-height: 100%;
        letter-spacing:-1px;
    }

    .no-margin-top {margin-top:0}
    .no-padding-bottom {padding-bottom:0 !important}

    p {margin: 8px 0px;}
    .footer p {margin:0px}

    .footer {
        border-top: 0px none #ffffff;
        padding: 0 0 10px 0;
        font-size: 10px;
        line-height: 15px;
        font-family:Verdana, sans-serif;
        text-align: left;
        color:#999999;
    }

    a, a:link, a:visited {
        color: #00BAF2;
        text-decoration: none;
        font-weight: normal;
        outline: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .signature {
        display:none;
        font-size: 13px;
        color: rgb(70,70,70);
        font-family: Georgia;
        font-style:italic;
    }

    b {color:black}
    .red {color:red}
</style>