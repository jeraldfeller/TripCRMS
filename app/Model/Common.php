<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 9/7/2016
 * Time: 8:06 AM
 */

class Common {

    public function sendMail($contacts, $titleSubject, $msg, $from){

        $to = implode(',' , $contacts);
        $subject = $titleSubject;
        $txt = $msg;
        $headers = 'From: ' . $from . '';
        mail($to,$subject,$txt,$headers);
    }

}