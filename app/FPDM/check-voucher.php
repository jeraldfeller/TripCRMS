<?php

/***************************
Sample using a PHP array
 ****************************/

require('fpdm.php');
require ('../Model/Init.php');
require SERVER_ROOT . '/' . VERSION . '/includes/require.php';

$employeeClass = new Employee();
$adminClass = new Admin();

$tid = $_GET['transaction_id'];
$transaction = $employeeClass->getCheckTransactionByTID($tid);
$check_info = $adminClass->getCheckInfo();

foreach($check_info as $info){
    $institution = $info['check_name'];
    $address = $info['address'];
    $city = $info['city'];
    $state = $info['state'];
    $zip = $info['zip'];
	$fraction = $info['fraction_no'];
    $code = $info['routing_no'] . ' ' . $info['account_no'];
}


foreach($transaction as $row){

    $name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    $amount = $row['amount'];
    $memo = $row['memo'];
    $date = $row['date_added'];
    $check_no = $row['check_id'];

}
if($check_no > 10){
	$zeros = '0';
}
else if($check_no > 99){
	$zeros = '';
}
else{
	$zeros = '00';
}

$date = date('m/d/Y', strtotime($date));

define("MAJOR", 'dollars');
define("MINOR", '$');
class toWords  {
    var $pounds;
    var $pence;
    var $major;
    var $minor;
    var $words = '';
    var $number;
    var $magind;
    var $units = array('','One','Two','Three','Four','Five','Six','Seven','Eight','Nine');
    var $teens = array('Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen');
    var $tens = array('','Ten','Twenty','Thirty','Forty','Fifty','Sixty','Seventy','Eighty','Ninety');
    var $mag = array('','Thousand','Million','Billion','Trillion');
    function toWords($amount, $major=MAJOR, $minor=MINOR) {
        $this->major = $major;
        $this->minor = $minor;
        $this->number = number_format($amount,2);
        list($this->pounds,$this->pence) = explode('.',$this->number);
        $this->words = " $this->major $this->pence$this->minor";
        if ($this->pounds==0)
            $this->words = "Zero $this->words";
        else {
            $groups = explode(',',$this->pounds);
            $groups = array_reverse($groups);
            for ($this->magind=0; $this->magind<count($groups); $this->magind++) {
                if (($this->magind==1)&&(strpos($this->words,'hundred') === false)&&($groups[0]!='000'))
                    $this->words = ' and ' . $this->words;
                $this->words = $this->_build($groups[$this->magind]).$this->words;
            }
        }
    }
    function _build($n) {
        $res = '';
        $na = str_pad("$n",3,"0",STR_PAD_LEFT);
        if ($na == '000') return '';
        if ($na{0} != 0)
            $res = ' '.$this->units[$na{0}] . ' hundred';
        if (($na{1}=='0')&&($na{2}=='0'))
            return $res . ' ' . $this->mag[$this->magind];
        $res .= $res==''? '' : ' and';
        $t = (int)$na{1}; $u = (int)$na{2};
        switch ($t) {
            case 0: $res .= ' ' . $this->units[$u]; break;
            case 1: $res .= ' ' . $this->teens[$u]; break;
            default:$res .= ' ' . $this->tens[$t] . ' ' . $this->units[$u] ; break;
        }
        $res .= ' ' . $this->mag[$this->magind];
        return $res;
    }
}

$obj = new toWords($amount, 'Dollars', 'c');
$amount_words =  $obj->words;


$fields = array(

    'check_no' => $zeros . $check_no,
	'check_no_1' => $zeros . $check_no,
	'check_no_2' => $zeros . $check_no,
    'company_name' => $institution,
    'address_line1' => $address,
    'address_line12' => $city . ' ' . $state . ' ' . $zip,
    'payee_name' => $name,
	'payee_name_1' => $name,
	'payee_name_2' => $name,
	'fraction_no' => $fraction,
    'date' => $date,
	'date_1' => $date,
	'date_2' => $date,
    'amount_words' => $amount_words,
    'amount' => '$' . number_format($amount,2 ) . '*',
	'amount_1' => '$' . number_format($amount,2 ) . '*',
	'amount_2' => '$' . number_format($amount,2 ) . '*',
    'memo' => $memo,
	'memo_1' => $memo,
	'memo_2' => $memo,
    'code' => $code . ' ' . $check_no

);


$pdf = new FPDM('check_voucher.pdf');
//$pdf->Flatten();
$pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
$pdf->Merge();
$pdf->Output();


?>
