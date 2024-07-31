<?php

namespace Element\Locator;

class Lookup {


    public function __construct() {

    }

    /**
     * @return array|false|string
     */
    public static function ipAddress() {

        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');

        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');

        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');

        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');

        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');

        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');

        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /**
     * @param $apiKey
     * @param $ip
     * @param $lang
     * @param $fields
     * @param $excludes
     *
     * @return mixed
     */
    public static function geoLocation($apiKey, $ip, $lang = "en", $fields = "*", $excludes = "") {

        $url = "https://api.ipgeolocation.io/ipgeo?apiKey=".$apiKey."&ip=".$ip."&lang=".$lang."&fields=".$fields."&excludes=".$excludes;
        $cURL = curl_init();

        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: '.$_SERVER['HTTP_USER_AGENT']
        ));

        $location = curl_exec($cURL);

        return json_decode($location, true);
    }
}