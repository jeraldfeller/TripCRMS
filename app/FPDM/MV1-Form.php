<?php

/***************************
  Sample using a PHP array
****************************/

require('fpdm.php');
require '../Model/Init.php';
require SERVER_ROOT . '/' . VERSION . '/includes/require.php';

$adminClass = new Admin();
$employeeClass = new Employee();

$id = $_GET['cid'];
$last_id = $_GET['lid'];
$customer = $employeeClass->getCustomerByIdTitlePawn($id, $last_id);
$info = $adminClass->getLienInfo();

foreach($customer as $row){

    $name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    $home_no = $row['home_no'];
    $cell_no = $row['cell_no'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip'];
    $fname = $row['first_name'];
    $dl = $row['drivers_license_no'];
    $issue_date = $row['dl_issue_date'];
    $expire_date = $row['dl_expire_date'];
    $dob = $row['birth_date'];
    $height = $row['height'];
    $weight = $row['weight'];
    $eye_color = $row['eye_color'];
    $vin = $row['vin_no'];
    $year = $row['year'];
    $model = $row['model'];
    $color = $row['color'];
    $make = $row['make'];
    $style = $row['style'];
    $mileage = $row['no_of_doors'];
    $condition = $row['vehicle_condition'];
    $title_no = $row['title_no'];
    $tag_no = $row['tag_no'];
    $exempt = $row['exempt'];

}

foreach($info as $row){

    $fname = $row['first_name'];
    $lname = $row['last_name'];
    $address = $row['address'];
    $elt = $row['elt'];
}

$lien_info = $fname . ' ' . $lname . ', ' . $address;

if($exempt == '1'){$mileage = 'x';}



$fields = array(
	'vin'   => $vin,
    'year'  => $year,
    'make'  => $make,
    'style' => $style,
    'model' => $model,
    'color' => $color,
    'current_title_no' => $title_no,
    'full_legal_owner' => $name,
    'over_lay_exempt' => $mileage,
    'security_interest_holders_id' => $elt,
    'name_address_of_1st_security_interest' => $lien_info
);

$pdf = new FPDM('MV-1.pdf');
$pdf->Flatten();
$pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output();

?>
