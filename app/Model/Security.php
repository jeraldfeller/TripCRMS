<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 9/9/2016
 * Time: 10:25 AM
 */


class Security {

    public function makeHash($action, $string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = '6f36a4b004fd3198dd1490311e300c94';
        $secret_iv = '33651529664930d3';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}