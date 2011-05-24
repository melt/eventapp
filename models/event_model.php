<?php namespace nmvc;

class EventModel extends AppModel {
    /* Fields */
    public $title = array('core\TextType', 128);
    public $venue = array('core\TextType', 128);
    public $date = array('core\DateType');
    public $time = array('core\TimestampType');
    public $address = array('core\TextType', 128);
    public $zip_code = array('core\TextType', 16);
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    /* Object Relations */
    public $hub_id = array('core\PointerType', 'HubModel', 'CASCADE');

    public $invite_email_sent = array('core\BooleanType');
    public $reminder_email_sent = array('core\BooleanType');
    public $thankyou_email_sent = array('core\BooleanType');

}