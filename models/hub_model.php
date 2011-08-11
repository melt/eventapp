<?php namespace melt;

class HubModel extends AppModel {
    /* Hub Information */
    public $city = array('core\TextType', 128);
    public $country = array('core\CountryType');
    
    public function __toString() {
        return $this->view('city') . " (" . $this->country . ")";
    }
    
}