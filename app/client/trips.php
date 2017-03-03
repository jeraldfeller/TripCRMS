<?php
require '../Model/Init.php';
require '../includes/require.php';
$title = 'Trips';
$_SESSION['currentPage'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$trips = $schoolClass->getAllTripsActive();

if(isset($_POST['registerButton'])){
    $schoolClass->registerTrip($uid, $userEmail);
}

require SERVER_ROOT . '/app/includes/header.php';
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
										<div class="modal fade" id="modal_view_trip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header info">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Trip Details</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
																			<div class="row">
																				<div class="col-lg-12">
																				<h5 class="box-heading">Trip Title</h5>
																				<div class="input-group col-lg-12">
																					<input id="eTitle" type="text" placeholder="" class="form-control" name="title" readonly/>
																				</div>
																				<div class="mbl"></div>
																				</div>

																				<div class="col-lg-6">
                                                                                    <h5 class="box-heading">From</h5>
                                                                                    <div class="col-lg-12 input-group">

                                                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="eDatepicker_from" name="from" readonly>
                                                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-6">
                                                                                     <h5 class="box-heading">To</h5>
                                                                                    <div class="col-lg-12 input-group">

                                                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="eDatepicker_to" name="to" readonly>
                                                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
																				<div class="mbl"></div>


																				<div class="col-lg-12">
                                                                                    <h5 class="box-heading">Description</h5>
                                                                                    <div class="input-group col-lg-12">
                                                                                        <textarea rows="6" class="form-control" name="description" id="eDescription" readonly/></textarea>
                                                                                    </div>
																				</div>
																				<div class="mbl"></div>


																				<div class="col-lg-2">
                                                                                     <h5 class="box-heading">Fee</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                                            <input type="text" class="form-control" placeholder="0.00" id="eFee" name="fee" onchange="formatCurrency(this)" readonly>

                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-2">
                                                                                     <h5 class="box-heading"># of Payments</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <input type="number" min="0" max="20" step="1" class="form-control" placeholder="0" id="eNoPayments" name="noPayments" readonly>

                                                                                    </div>
                                                                                </div>

                                                                                 <div class="col-lg-3">
                                                                                     <h5 class="box-heading"># of days for due date</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <input type="number" min="0" max="20" step="1" class="form-control" placeholder="0" id="eNoDaysDue" name="noDaysDue" readonly>

                                                                                    </div>
                                                                                 </div>
																			</div>

                                                                        </div>
                                                                        <div class="modal-footer">

                                                                            <input type="hidden" id="tid" name="tid">
                                                                            <?php if($isLogin == 1){ ?>
                                                                            <button type="submit" id="registerButton" name="registerButton" class="btn btn-primary">Register</button>
                                                                            <?php }else { ?>
                                                                                <span>Please <a href="../login">login</a> or <a href="register">create account</a> to register on this trip</span>
                                                                            <?php } ?>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->
															</form>


                                <div class="table-responsive">

                                        <table class="table table-primary mb30 align-center table-striped">
											<thead>
											<tr>
												<th>Trip Name</th>
                                                <th>Date</th>
                                                <th>Fee</th>
												<th>Date Added</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
											</thead>
											<tbody>
											    <?php echo $view->displayTrips($trips, 'client', $uid); ?>
											</tbody>
										</table>






                                </div><!-- table-responsive -->
                            </div>
        </div>

    </div><!-- contentpanel -->

</div>
</div><!-- mainwrapper -->
<script>
		function pushData(elem){
		        var type = elem.getAttribute('data-type');

		        if(type == 'view'){

                    var id = elem.getAttribute('data-id');
                    var isRegistered = elem.getAttribute('data-isRegistered');
                    var title = elem.getAttribute('data-title');
                    var from = elem.getAttribute('data-from');
                    var to = elem.getAttribute('data-to');
                    var desc = elem.getAttribute('data-desc');
                    var fee = elem.getAttribute('data-fee');
                    var noPayments = elem.getAttribute('data-noPayments');
                    var noDaysDue = elem.getAttribute('data-noDaysDue');
                    var status = elem.getAttribute('data-status');

                    document.getElementById('eTitle').value = title;
                    document.getElementById('eDatepicker_from').value = from
                    document.getElementById('eDatepicker_to').value = to;
                    document.getElementById('eDescription').value = desc;
                    document.getElementById('eFee').value = fee;
                    document.getElementById('eNoPayments').value = noPayments;
                    document.getElementById('eNoDaysDue').value = noDaysDue;
                    document.getElementById('tid').value = id;


                    $('#registerButton').click(function(){
                        $(this).css('display', 'none');
                    })

                    if(isRegistered == 1){
                        $('#registerButton').css('display', 'none');
                    }else{
                        $('#registerButton').css('display', 'inline');
                    }


                }


		}
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
                $('.tooltip-registered').tooltip({title: "Registered", placement: "top", trigger: "hover"});



            });
    </script>

<script src="../../assets/js/jquery.gritter.min.js"></script>
<script src="../../assets/js/notify.js"></script>
<?php require SERVER_ROOT . '/app/includes/footer.php'; ?>