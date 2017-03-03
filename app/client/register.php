<?php
require '../Model/Init.php';
require '../includes/require.php';

$title = 'Account Registration';



if(isset($_POST['createAccount'])){
    $userClass->createAccount();
}

require SERVER_ROOT . '/app/includes/header.php';
?>
<div class="mainpanel" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <div class="pageheader">
        <div class="media">
            <div class="pageicon pull-left">
                <i class="glyphicon glyphicon-user" style="padding-top: 5px;"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href=""><i class="glyphicon glyphicon-home"></i></a></li>
                    <li><a href="">Account Registration</a></li>

                </ul>
                <h4>Account Registration</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->

    <div class="contentpanel">

        <!-- CONTENT GOES HERE -->
        <div class="row">
            <div class="col-md-12">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="basicForm">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
                            <a href="" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                        </div><!-- panel-btns -->
                        <h4 class="panel-title">Login Credentials</h4>
                    </div>
                    <div class="panel-body">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email<span class="asterisk">*</span></label>
                                            <div class="col-sm-9">
                                               <input type="email" name="email" id="email1" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Re-enter Email<span class="asterisk">*</span></label>
                                            <div class="col-sm-9">
                                               <input type="email" id="email2" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password<span class="asterisk">*</span></label>
                                            <div class="col-sm-9">
                                               <input type="password" name="password" id="password1" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Re-enter Password<span class="asterisk">*</span></label>
                                            <div class="col-sm-9">
                                               <input type="password" id="password2" class="form-control" placeholder="" required=""/>
                                            </div>
                                    </div><!-- form-group -->
                                </div>
                            </div>

                    </div>
                </div> <!-- panel -->

                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="panel-btns">
                            <a href="" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
                            <a href="" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
                        </div><!-- panel-btns -->
                        <h4 class="panel-title">Personal Info</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-5">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">First name<span class="asterisk">*</span></label>
                                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-2">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">Middle Initial</label>
                                                <input type="text" name="middleName" id="middleName" class="form-control" placeholder=""/>
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-5">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">Last name<span class="asterisk">*</span></label>
                                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-12">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">Address<span class="asterisk">*</span></label>
                                                <textarea name="address" id="address" class="form-control" placeholder="" required /></textarea>
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-4">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">City<span class="asterisk">*</span></label>
                                                <input type="text" name="city" id="city" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-4">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">State<span class="asterisk">*</span></label>
                                                <input type="text" name="state" id="state" class="form-control" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-4">
                                    <div class="form-group">
                                            <div class="col-sm-12 input-group">
                                                <label class="control-label">Zip code<span class="asterisk">*</span></label>
                                                <input type="text" name="zip" id="zip" class="form-control" onkeypress="return isNumberKey(event)" placeholder="" required />
                                            </div>
                                    </div><!-- form-group -->
                            </div>

                            <div class="col-lg-4">
                                    <div class="form-group">
                                    <label class="control-label">Contact number<span class="asterisk">*</span></label>
                                            <div class="col-sm-12 input-group">
                                                <input type="text" class="form-control" placeholder="" id="contact" name="contact">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                                            </div>
                                    </div><!-- form-group -->
                            </div>


                            <div class="col-lg-4">
                                    <div class="form-group">
                                    <label class="control-label">Date of birth<span class="asterisk">*</span></label>
                                            <div class="col-sm-12 input-group">
                                                <input style="height: 40px;" type="date" class="form-control" placeholder="mm/dd/yyyy" name="dob">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            </div>
                                    </div><!-- form-group -->
                            </div>



                        </div>
                    </div> <!-- panel-body -->
                    <div class="panel-footer">
                        <button class="btn btn-primary pull-right" id="createButton" name="createAccount" type="submit">Create Account</button>
                    </div>
                </div> <!-- panel -->

            </form>
            </div>
        </div>

    </div><!-- contentpanel -->

</div>
</div><!-- mainwrapper -->

<script src="../../assets/js/jquery.gritter.min.js"></script>
<script src="../../assets/js/notify.js"></script>
<script src="../../assets/js/jquery.validate.min.js"></script>
<script>
            $(document).ready(function(){
                // Date Picker
                $('#datepicker_dob').datepicker();

                // Basic Form
                $("#basicForm").validate({
                    highlight: function(element) {
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    success: function(element) {
                        $(element).closest('.form-group').removeClass('has-error');
                    }
                });

                $('#email2').keyup(function(){
                    $email1 = $('#email1').val();
                    $email2 = $('#email2').val();

                    if($email1 != $email2){
                       $('#email2').closest('.form-group').removeClass('has-success').addClass('has-error');
                       $('#email2').tooltip({title: "email address does not match", html: true, placement: "top", trigger: "hover"});
                       $('#email2').tooltip('show');
                       document.getElementById('createButton').disabled = true;
                    }else{
                       $('#email2').closest('.form-group').removeClass('has-error').addClass('has-success');
                       $('#email2').tooltip('destroy');
                       document.getElementById('createButton').disabled = false;
                    }

                });

                 $('#password2').keyup(function(){
                    $password1 = $('#password1').val();
                    $password2 = $('#password2').val();

                    if($password1 != $password2){
                       $('#password2').closest('.form-group').removeClass('has-success').addClass('has-error');
                       $('#password2').tooltip({title: "password does not match", html: true, placement: "top", trigger: "hover"});
                       $('#password2').tooltip('show');
                       document.getElementById('createButton').disabled = true;
                    }else{
                       $('#password2').closest('.form-group').removeClass('has-error').addClass('has-success');
                       $('#password2').tooltip('destroy');
                       document.getElementById('createButton').disabled = false;
                    }

                });
            });
</script>




<?php require SERVER_ROOT . '/app/includes/footer.php'; ?>