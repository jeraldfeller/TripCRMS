<?php
require '../Model/Init.php';
require '../includes/require.php';
$title = 'Manage Trips';

$schoolClass = new School();
$commonClass = new Common();
$view = new View();
$trips = $schoolClass->getAllTrips();

if(isset($_POST['add_new_trip'])){
    $schoolClass->addTrip();
}

if(isset($_POST['edit_trip'])){
    $schoolClass->editTrip();
}
if(isset($_POST['delete_trip'])){
    $schoolClass->deleteTrip();
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
                    <li><a href="">Manage Trips</a></li>

                </ul>
                <h4>Manage Trips</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        <!-- CONTENT GOES HERE -->
        <div class="row">

            <div class="col-md-12">
            <button class="btn btn-primary pull-right" onClick="$('#modal_add_trip').modal('show');"><i class="fa fa-plus"></i> Add New Trip</button>
            <br><br><br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<div class="modal fade" id="modal_add_trip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header info">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Add New Trip</h4>
                                                                        </div>
                                                                        <div class="modal-body">

																			<div class="row">
																				<div class="col-lg-12">
																				<h5 class="box-heading">Trip Title</h5>
																				<div class="input-group col-lg-12">
																					<input id="inputName" type="text" placeholder="" class="form-control" name="title" required/>
																				</div>
																				<div class="mbl"></div>
																				</div>

																				<div class="col-lg-6">
                                                                                    <h5 class="box-heading">From</h5>
                                                                                    <div class="col-lg-12 input-group">

                                                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker_from" name="from">
                                                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-6">
                                                                                     <h5 class="box-heading">To</h5>
                                                                                    <div class="col-lg-12 input-group">

                                                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker_to" name="to">
                                                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
																				<div class="mbl"></div>


																				<div class="col-lg-12">
                                                                                    <h5 class="box-heading">Description</h5>
                                                                                    <div class="input-group col-lg-12">
                                                                                        <textarea rows="6" class="form-control" name="description" required/></textarea>
                                                                                    </div>
																				</div>

																				<div class="col-lg-2">
                                                                                     <h5 class="box-heading">Fee</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                                            <input type="text" class="form-control" placeholder="0.00" id="fee" name="fee" onchange="formatCurrency(this)">

                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-2">
                                                                                     <h5 class="box-heading"># of Payments</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <input type="number" min="0" max="20" step="1" class="form-control" placeholder="0" id="noPayments" name="noPayments">

                                                                                    </div>
                                                                                </div>

                                                                                 <div class="col-lg-3">
                                                                                     <h5 class="box-heading"># of days for due date</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <input type="number" min="0" max="20" step="1" class="form-control" placeholder="0" id="noDaysDue" name="noDaysDue">

                                                                                    </div>
                                                                                 </div>
																			</div>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="submit" name="add_new_trip" class="btn btn-primary">Add</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->
															</form>



															<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<div class="modal fade" id="modal_edit_trip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header info">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel">Edit Trip</h4>
                                                                        </div>
                                                                        <div class="modal-body">

																			<div class="row">
																				<div class="col-lg-12">
																				<h5 class="box-heading">Trip Title</h5>
																				<div class="input-group col-lg-12">
																					<input id="eTitle" type="text" placeholder="" class="form-control" name="title" required/>
																				</div>
																				<div class="mbl"></div>
																				</div>

																				<div class="col-lg-6">
                                                                                    <h5 class="box-heading">From</h5>
                                                                                    <div class="col-lg-12 input-group">

                                                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="eDatepicker_from" name="from">
                                                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-6">
                                                                                     <h5 class="box-heading">To</h5>
                                                                                    <div class="col-lg-12 input-group">

                                                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="eDatepicker_to" name="to">
                                                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                                                    </div>
                                                                                </div>
																				<div class="mbl"></div>


																				<div class="col-lg-12">
                                                                                    <h5 class="box-heading">Description</h5>
                                                                                    <div class="input-group col-lg-12">
                                                                                        <textarea rows="6" class="form-control" name="description" id="eDescription" required/></textarea>
                                                                                    </div>
																				</div>
																				<div class="mbl"></div>


																				<div class="col-lg-2">
                                                                                     <h5 class="box-heading">Fee</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                                            <input type="text" class="form-control" placeholder="0.00" id="eFee" name="fee" onchange="formatCurrency(this)">

                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-2">
                                                                                     <h5 class="box-heading"># of Payments</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <input type="number" min="0" max="20" step="1" class="form-control" placeholder="0" id="eNoPayments" name="noPayments">

                                                                                    </div>
                                                                                </div>

                                                                                 <div class="col-lg-3">
                                                                                     <h5 class="box-heading"># of days for due date</h5>
                                                                                        <div class="col-lg-12 input-group">
                                                                                            <input type="number" min="0" max="20" step="1" class="form-control" placeholder="0" id="eNoDaysDue" name="noDaysDue">

                                                                                    </div>
                                                                                 </div>

																				<div class="col-lg-12">
																				    <h5 class="box-heading">Status</h5>
                                                                                        <div class="rdio rdio-success col-lg-2">
                                                                                            <input type="radio" name="status" value="4" id="radioSuccess" />
                                                                                            <label for="radioSuccess">Active</label>
                                                                                        </div>
                                                                                        <div class="rdio rdio-warning col-lg-2">
                                                                                            <input type="radio" name="status" value="5" id="radioWarning" />
                                                                                            <label for="radioWarning">Postponed</label>
                                                                                        </div>
																				</div>

																			</div>

                                                                        </div>
                                                                        <div class="modal-footer">

                                                                            <input type="hidden" id="etid" name="tid">
                                                                            <button type="submit" name="edit_trip" class="btn btn-primary">Update</button>
                                                                        </div>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                            <!-- /.modal -->
															</form>

                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
										<div class="modal fade" id="modal_delete_trip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header info">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> Warning</h4>
                                                                        </div>
                                                                        <div class="modal-body">

																			<p>Are you sure do want to remove <b><span id="display_title"></span></b>?</p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                        <input type="hidden" name="tid" id="dtid">
                                                                            <button type="submit" name="delete_trip" class="btn btn-danger">Delete</button>
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
											    <?php echo $view->displayTrips($trips, 'admin', $uid); ?>
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

		        if(type == 'edit'){

                    var id = elem.getAttribute('data-id');
                    var title = elem.getAttribute('data-title');
                    var from = elem.getAttribute('data-from');
                    var to = elem.getAttribute('data-to');
                    var desc = elem.getAttribute('data-desc');
                    var fee = elem.getAttribute('data-fee');
                    var noPayments = elem.getAttribute('data-noPayments');
                    var noDaysDue = elem.getAttribute('data-noDaysDue');
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
                    document.getElementById('eFee').value = fee;
                    document.getElementById('eNoPayments').value = noPayments;
                    document.getElementById('eNoDaysDue').value = noDaysDue;
                    document.getElementById('etid').value = id;

               }else if(type == 'delete'){
                    var id = elem.getAttribute('data-id');
                    var title = elem.getAttribute('data-title');

                    document.getElementById('display_title').innerHTML = title;
                    document.getElementById('dtid').value = id;
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



            });
    </script>

<script src="../assets/js/jquery.gritter.min.js"></script>
<script src="../assets/js/notify.js"></script>
<?php require SERVER_ROOT . '/app/includes/footer.php'; ?>