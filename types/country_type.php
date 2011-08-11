<?php namespace melt;

/**
 * CountryType stores countries using the ISO 3166-1 encoding.
 */
class CountryType extends core\CountryType {
   
    public static function getAlpha2FromName($country_name){
        $countries = core\CountryType::getCountryList();
        foreach($countries as $key => $value){
            if( $value[2] == trim( $country_name ) )
                return $key;
        }
        return null;
    }
}

?>