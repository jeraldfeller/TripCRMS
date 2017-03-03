<?php
/**
 * Created by PhpStorm.
 * User: Grabe Grabe
 * Date: 9/7/2016
 * Time: 10:45 AM
 */

class View extends School{

    public function displayTrips($trips, $account, $uid)
    {

        $output = ' ';
        $label = '';
        $registered = 0;
        foreach ($trips as $row)
        {
            $isRegistered = $this->getRegisteredTripsById($row['tid'], $uid);
            if(count($isRegistered) > 0){
                $registered = 1;
                $label = '<a href="#" class="tooltip-registered"><span class="label label-success"><i class="fa fa-check"></i></span></a>';
            }
            $output .= '<tr>' . PHP_EOL;
            $output .= '<td>' . $row['tripTitle'] . ' ' . $label . '</td>' . PHP_EOL;
            $output .= '<td>' . date('m/d/Y', strtotime($row['fromDate'])) . ' - ' . date('d/m/Y', strtotime($row['toDate']))  . '</td>' . PHP_EOL;
            $output .= '<td>$' . number_format($row['fee'], 2) . '</td>' . PHP_EOL;
            $output .= '<td>' . date("m/d/Y", strtotime($row['dateAdded'])) . '</td>' . PHP_EOL;
            $output .= '<td>' . $row['status'] . '</td>' . PHP_EOL;
            if($account == 'admin'){
                $output .= '<td>
                        <a href="trip?ref=' . $row['tid'] . '" class="btn btn-info btn-xs tooltip-view"
                        data-type="view"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-from="' . $row['fromDate'] . '"
                        data-to="' . $row['toDate'] . '"
                        data-desc="' . $row['description'] . '"
                        data-status="' . $row['status'] . '"><i class="fa fa-eye"></i></a>

                        <button class="btn btn-success btn-xs tooltip-edit"
                        data-type="edit"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-from="' . date('m/d/Y', strtotime($row['fromDate'])) . '"
                        data-to="' .date('m/d/Y', strtotime( $row['toDate'])) . '"
                        data-desc="' . $row['description'] . '"
                        data-fee="' . $row['fee'] . '"
                        data-noPayments="' . $row['noPayments'] . '"
                        data-noDaysDue="' . $row['noDaysDue'] . '"
                        data-status="' . $row['status'] . '"
                        data-toggle="modal"
                        data-target="#modal_edit_trip" onclick="pushData(this)"><i class="fa fa-edit"></i></button>

                        <button class="btn btn-danger btn-xs tooltip-delete"
                        data-type="delete"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-toggle="modal"
                        data-target="#modal_delete_trip" onclick="pushData(this)"><i class="fa fa-trash-o"></i></button>
                        </td>' . PHP_EOL;
            }else{
                $output .= '<td>
                       <button class="btn btn-info btn-xs tooltip-view"
                        data-type="view"
                        data-isRegistered="' . $registered . '"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-from="' . date('m/d/Y', strtotime($row['fromDate'])) . '"
                        data-to="' .date('m/d/Y', strtotime( $row['toDate'])) . '"
                        data-desc="' . $row['description'] . '"
                        data-fee="' . $row['fee'] . '"
                        data-noPayments="' . $row['noPayments'] . '"
                        data-noDaysDue="' . $row['noDaysDue'] . '"
                        data-status="' . $row['status'] . '"
                        data-toggle="modal"
                        data-target="#modal_view_trip" onclick="pushData(this)"><i class="fa fa-eye"></i></button>
                        </td>' . PHP_EOL;
            }

            $output .= '</tr>' . PHP_EOL;



        }
        return $output;
    }

    public function displayRegisteredTrips($registeredTrips){

        $output = '';
        foreach($registeredTrips as $row){
            $output .= '<tr>' . PHP_EOL;
            $output .= '<td>' . $row['tripTitle'] . '</td>' . PHP_EOL;
            $output .= '<td>' . date('m/d/Y', strtotime($row['fromDate'])) . ' - ' . date('d/m/Y', strtotime($row['toDate']))  . '</td>' . PHP_EOL;
            $output .= '<td>$' . number_format($row['fee'], 2) . '</td>' . PHP_EOL;
            $output .= '<td>' . date("m/d/Y", strtotime($row['dateRegistered'])) . '</td>' . PHP_EOL;
            $output .= '<td>' . strtoupper($row['registrationStatus']) . '</td>' . PHP_EOL;
            $output .= '<td>
                        <button class="btn btn-info btn-xs tooltip-view"
                        data-type="view"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-from="' . date('m/d/Y', strtotime($row['fromDate'])) . '"
                        data-to="' .date('m/d/Y', strtotime( $row['toDate'])) . '"
                        data-desc="' . $row['description'] . '"
                        data-fee="' . $row['fee'] . '"
                        data-toggle="modal"
                        data-target="#modal_view_trip" onclick="pushData(this)"><i class="fa fa-eye"></i></button>

                        <button class="btn btn-success btn-xs tooltip-upload"
                        data-type="upload"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-toggle="modal"
                        data-target="#modal_upload_trip" onclick="pushData(this)"><i class="fa fa-upload"></i></button>

                        <button class="btn btn-warning btn-xs tooltip-cancel"
                        data-type="cancel"
                        data-id="' . $row['tid'] . '"
                        data-title="' . $row['tripTitle'] . '"
                        data-toggle="modal"
                        data-target="#modal_cancel_trip" onclick="pushData(this)"><i class="fa fa-times"></i></button>
                         </td>' . PHP_EOL;
            $output .= '</tr>' . PHP_EOL;
        }

        return $output;

    }

    public function displayRegisteredClients($clients){

        $output = '';
        foreach($clients as $row){

            $paymentHistory = $this->getPaymentHistory($row['uid'], $row['rtid']);
            $payments = htmlspecialchars(json_encode($paymentHistory));
            $output .= '<tr>' . PHP_EOL;
            $output .= '<td>' . $row['firstName'] . ' ' . $row['lastName'] . '</td>' . PHP_EOL;
            $output .= '<td>' . date('m/d/Y', strtotime($row['dateAdded'])) . '</td>' . PHP_EOL;
            $output .= '<td>$' . number_format($row['remaining'], 2) . '</td>' . PHP_EOL;
            $output .= '<td>' . strtoupper($row['status']) . '</td>' . PHP_EOL;

            if($row['status'] == 'pending'){
                $output .= '<td>
                        <button class="btn btn-info btn-xs tooltip-view-contract"
                        data-type="viewContract"
                        data-id="' . $row['rtid'] . '"
                        data-uid="' . $row['uid'] . '"
                        data-name="' . $row['firstName'] . ' ' . $row['lastName'] . '"
                        data-image="' . base64_encode($row['contractImage']) . '"
                        data-toggle="modal"
                        data-target="#modal_view_contract_trip" onclick="pushData(this)"><i class="fa fa-file-text"></i></button>

                        </td>' . PHP_EOL;
            }else if($row['status'] == 'approved'){



                if($row['remaining'] == 0 || $row['remaining'] == '0.00'){
                    $output .= '<td>
                        <button class="btn btn-info btn-xs tooltip-view-payment-history"
                        data-type="viewPayments"
                        data-id="' . $row['rtid'] . '"
                        data-name="' . $row['firstName'] . ' ' . $row['lastName'] . '"
                        data-payment-history="' . $payments . '"
                        data-toggle="modal"
                        data-target="#modal_view_payment_history" onclick="pushData(this)"><i class="fa fa-eye"></i></button>
                    <button class="btn btn-success btn-xs tooltip-paid">
                        <i class="fa fa-thumbs-up"></i></button>

                        </td>' . PHP_EOL;
                }else{


                $output .= '<td>
                        <button class="btn btn-info btn-xs tooltip-view-payment-history"
                        data-type="viewPayments"
                        data-id="' . $row['rtid'] . '"
                        data-name="' . $row['firstName'] . ' ' . $row['lastName'] . '"
                        data-payment-history="' . $payments . '"
                        data-toggle="modal"
                        data-target="#modal_view_payment_history" onclick="pushData(this)"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-success btn-xs tooltip-payment"
                        data-type="takePayment"
                        data-id="' . $row['rtid'] . '"
                        data-uid="' . $row['uid'] . '"
                        data-tid="' . $row['tid'] . '"
                        data-name="' . $row['firstName'] . ' ' . $row['lastName'] . '"
                        data-toggle="modal"
                        data-target="#modal_take_payment" onclick="pushData(this)"><i class="fa fa-money"></i></button>

                        </td>' . PHP_EOL;
                }
            }else{
                $output .= '<td></td>' . PHP_EOL;
            }

            $output .= '</tr>' . PHP_EOL;
        }

        return $output;

    }

}