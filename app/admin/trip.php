<?php
require '../Model/Init.php';
require '../includes/require.php';

$refId = (isset($_GET['ref']) ? $_GET['ref'] : 0);
$view = new View();
$trip = $schoolClass->getTripsById($refId);

$clients = $schoolClass->getRegisteredClients($refId, 'all');
$clientsPending = $schoolClass->getRegisteredClients($refId, 'pending');
$clientsApproved = $schoolClass->getRegisteredClients($refId, 'approved');
$clientsDeclined = $schoolClass->getRegisteredClients($refId, 'declined');
$clientsNoContract = $schoolClass->getRegisteredClients($refId, 'no contract');

$totalCountOfRegistered = $schoolClass->getRegisteredCount($refId);
$totalRegisteredSumFees = $schoolClass->getRegisteredTotalSumFees($refId);
$totalRegisteredPaidSumFees = $schoolClass->getRegisteredTotalPaidSumFees($refId);
$balance = $totalRegisteredSumFees - $totalRegisteredPaidSumFees;
$title = $trip[0]['tripTitle'];
$queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
if(isset($_POST['approveContract']) || isset($_POST['declineContract'])){

    $schoolClass->approveDeclineRegistration($queryString);

}
if(isset($_POST['submitPayment'])){
    $schoolClass->takePayment($queryString);
}
require    SERVER_ROOT . '/app/includes/header.php';
?>
<div class="mainpanel" xmlns="http://www.w3.org/1999/html">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="glyphicon glyphicon-road" style="padding-top: 5px;"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="">Trips</a></li>

                </ul>
                <h4>Trips</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        <!-- CONTENT GOES HERE -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
                            <a href="" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                        </div><!-- panel-btns -->
                        <h4 class="panel-title"><?php echo $title; ?></h4>
                        <small><?php echo date('l, F d Y', strtotime($trip[0]['fromDate'])) . ' to ' . date('l, F d Y', strtotime($trip[0]['toDate'])); ?></small>

                    </div>
                    <div class="panel-body">
                        <p> <?php echo $trip[0]['description']; ?> </p>
                        <p>Fee: $<?php echo number_format($trip[0]['fee'], 2); ?></p>

                    </div>

                    <div class="panel-footer">
                         <div class="tinystat pull-left col-lg-2">

                                <div class="datainfo">
                                    <span class="text-muted"># of approved students</span>
                                    <h4><?php echo $totalCountOfRegistered; ?></h4>
                                </div>
                        </div><!-- tinystat -->

                        <div class="tinystat pull-left col-lg-2">
                                <div class="datainfo">
                                    <span class="text-muted">Total Fees</span>
                                    <h4>$<?php echo number_format($totalRegisteredSumFees, 2); ?></h4>
                                </div>
                        </div><!-- tinystat -->

                         <div class="tinystat pull-left col-lg-2">
                                <div class="datainfo">
                                    <span class="text-muted">Total Amount Paid</span>
                                    <h4>$<?php echo number_format($totalRegisteredPaidSumFees, 2); ?></h4>
                                </div>
                        </div><!-- tinystat -->

                        <div class="tinystat pull-left col-lg-2">
                                <div class="datainfo">
                                    <span class="text-muted">Balance</span>
                                    <h4>$<?php echo number_format($balance, 2); ?></h4>
                                </div>
                        </div><!-- tinystat -->
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-tabs nav-line">
                                    <li class="active"><a href="#all" data-toggle="tab"><strong>All</strong></a></li>
                                    <li><a href="#pending" data-toggle="tab"><strong>Pending</strong></a></li>
                                    <li><a href="#approved" data-toggle="tab"><strong>Approved</strong></a></li>
                                    <li><a href="#declined" data-toggle="tab"><strong>Declined</strong></a></li>
                                    <li><a href="#noContract" data-toggle="tab"><strong>No Contract</strong></a></li>
                </ul>
                <div class="tab-content nopadding border">
                    <div class="tab-pane active" id="all">
                        <div class="table-responsive">
                            <table class="table table-primary mb30 align-center table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Registered</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php echo $view->displayRegisteredClients($clients); ?>
                                    </tbody>
                                </table>
                        </div><!-- table-responsive -->
                    </div>


                    <div class="tab-pane" id="pending">
                        <div class="table-responsive">
                            <table class="table table-primary mb30 align-center table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Registered</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php echo $view->displayRegisteredClients($clientsPending); ?>
                                    </tbody>
                                </table>
                        </div><!-- table-responsive -->
                    </div>

                      <div class="tab-pane" id="approved">
                        <div class="table-responsive">
                            <table class="table table-primary mb30 align-center table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Registered</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php echo $view->displayRegisteredClients($clientsApproved); ?>
                                    </tbody>
                                </table>
                        </div><!-- table-responsive -->
                    </div>


                      <div class="tab-pane" id="declined">
                        <div class="table-responsive">
                            <table class="table table-primary mb30 align-center table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Registered</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php echo $view->displayRegisteredClients($clientsDeclined); ?>
                                    </tbody>
                                </table>
                        </div><!-- table-responsive -->
                    </div>


                      <div class="tab-pane" id="noContract">
                        <div class="table-responsive">
                            <table class="table table-primary mb30 align-center table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date Registered</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php echo $view->displayRegisteredClients($clientsNoContract); ?>
                                    </tbody>
                                </table>
                        </div><!-- table-responsive -->
                    </div>


                </div>
             </div>
        </div>


        <!-- modals -->

        <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $queryString; ?>" method="post" enctype="multipart/form-data">
		    <div class="modal fade" id="modal_view_contract_trip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header info">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="displayNameView"></h4>
                        </div>
                        <div class="modal-body">
                           <div class="row">
                                <div class="align-center" id="contractImage">
                                </div>
                           </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="rtid" id="vrtid">

                            <button type="submit" name="approveContract" class="btn btn-success">Approve</button>
                            <button type="submit" name="declineContract" class="btn btn-warning">Decline</button>
                        </div>
                    </div>
            <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
    </form>


    <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . $queryString; ?>" method="post">
		    <div class="modal fade" id="modal_take_payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header info">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="displayNamePayment"></h4>
                        </div>
                        <div class="modal-body">
                           <div class="row">

                            <div class="col-lg-12">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">$</span>
                                    <input type="text" id="amount" name="amount" class="form-control" placeholder="enter amount" onchange="formatCurrency(this)" />
                                </div><!-- input-group -->
                            </div>
                           </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="rtid" id="prtid">
                            <input type="hidden" name="uid" id="puid">
                            <input type="hidden" name="tid" id="ptid">
                            <button type="submit" name="submitPayment" class="btn btn-success">Submit</button>
                            <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                        </div>
                    </div>
            <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
    </form>



    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<div class="modal fade" id="modal_view_payment_history" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-md">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header info">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="displayNamePaymentHistory"></h4>
                                                                        </div>
                                                                        <div class="modal-body">

																			<div class="row">
																				<div class="col-lg-12">
																					<div class="table-responsive">
																						   <table class="table table-bordered table-primary">
																							<thead>
																							 <tr>
																								<th>Amount</th>
																								<th>Date Paid</th>
																							</tr>
																							</thead>
																							<tbody  id="appendPayments">

																							</tbody>
																						</table>
																					</div>

																					 <table class="table table-total">
																						<tbody id="appendTotal">

																						</tbody>
																					</table>
																				</div>
																			</div>

                                                                        </div>

                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->
									</form>


    </div><!-- contentpanel -->

</div>
</div><!-- mainwrapper -->
<script>
		function pushData(elem){
		        var type = elem.getAttribute('data-type');

		        if(type == 'edit'){

                    var id = elem.getAttribute('data-id');
                    var title = elem.getAttribute('data-title');
                    var from = elem.getAttribute('data-from');
                    var to = elem.getAttribute('data-to');
                    var desc = elem.getAttribute('data-desc');
                    var status = elem.getAttribute('data-status');

                    if(status == 'Active'){
                        document.getElementById('radioSuccess').checked = true;
                    }else{
                        document.getElementById('radioWarning').checked = true;
                    }

                    document.getElementById('eTitle').value = title;
                    document.getElementById('eDatepicker_from').value = from
                    document.getElementById('eDatepicker_to').value = to;
                    document.getElementById('eDescription').value = desc;
                    document.getElementById('etid').value = id;

               }else if(type == 'delete'){
                    var id = elem.getAttribute('data-id');
                    var title = elem.getAttribute('data-title');

                    document.getElementById('display_title').innerHTML = title;
                    document.getElementById('dtid').value = id;
               }else if(type =='viewContract'){
                    var id = elem.getAttribute('data-id');
                    var name = elem.getAttribute('data-name');
                    var image = elem.getAttribute('data-image');
                    var contractImage = '<img style="width: 100%;" src="data:image/jpeg;base64,'+ image + '" alt="contract"/>';
                    document.getElementById('vrtid').value = id;
                    document.getElementById('displayNameView').innerHTML = name;
                    document.getElementById('contractImage').innerHTML = contractImage;

               }else if(type == 'takePayment'){
                    var id = elem.getAttribute('data-id');
                    var uid = elem.getAttribute('data-uid');
                    var tid = elem.getAttribute('data-tid');
                    var name = elem.getAttribute('data-name');
                    document.getElementById('prtid').value = id;
                    document.getElementById('puid').value = uid;
                    document.getElementById('ptid').value = tid;
                    document.getElementById('displayNamePayment').innerHTML = name;

               }else if(type == 'viewPayments'){

                    $('#appendPayments').empty();
                    $('#appendTotal').empty();

                    var id = elem.getAttribute('data-id');
                    var uid = elem.getAttribute('data-uid');
                    var name = elem.getAttribute('data-name');
                    var payments = elem.getAttribute('data-payment-history');


                    var parsedData = $.parseJSON(payments);

                    var contents = "";
                    var amountSum = [];
                    $.each(parsedData, function(index, value){
                        contents += '<tr>';
                        contents += '<td>$' + value['amount'] + '</td>';
                        contents += '<td>' + value['dateAdded'] + '</td>';
                        contents += '</tr>';
                        amountSum.push(value['amount']);
                    });


                    var total = 0;
                    for(var i in amountSum) { total += parseFloat(amountSum[i]); }
                    /*
                    for(var i = 0, len = chargeSum.lenght; i < len; i++){
                        total += chargeSum[i][1];
                    }
                    */

                    var summaryContents = '';
                        summaryContents += '<tr>';
                        summaryContents += '<td style="vertical-align: middle;">Total</td>';
                        summaryContents += '<td>$' + total + '</td>';
                        summaryContents += '</tr>';

                    $('#appendPayments').append(contents);
                    $('#appendTotal').append(summaryContents);

                    document.getElementById('displayNamePaymentHistory').innerHTML = name;

               }


		}
            $('#modal_take_payment').on('shown.bs.modal', function () {
                $('#amount').focus();
            });
	</script>

	<script>
            $(document).ready(function() {
                // Date Picker
                $('#datepicker_from').datepicker();
                $('#datepicker_from').css('z-index', 99999);
                $('#datepicker_to').datepicker();
                $('#datepicker_to').css('z-index', 99999);

                $('#eDatepicker_from').datepicker();
                $('#eDatepicker_from').css('z-index', 99999);
                $('#eDatepicker_to').datepicker();
                $('#eDatepicker_to').css('z-index', 99999);


                // Tooltip
                $('.tooltip-view').tooltip({title: "View", placement: "top", trigger: "hover"});
                $('.tooltip-edit').tooltip({title: "Edit", placement: "top", trigger: "hover"});
                $('.tooltip-delete').tooltip({title: "Remove", placement: "top", trigger: "hover"});



            });
    </script>

<script src="../../assets/js/jquery.gritter.min.js"></script>
<script src="../../assets/js/notify.js"></script>
<?php require SERVER_ROOT . '/app/includes/footer.php'; ?>