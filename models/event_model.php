<?php namespace nmvc;

class EventModel extends AppModel {
    /* Fields */
    public $title = array('core\TextType', 128);
    public $address = array('core\TextType', 128);
    public $zip_code = array('core\TextType', 16);
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    /* Object Relations */
    public $hub_id = array('core\PointerType', 'HubModel', 'CASCADE');

}