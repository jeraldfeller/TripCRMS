<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

    <link href="../../assets/css/style.default.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link href="../../assets/css/morris.css" rel="stylesheet">
    <link href="../../assets/css/select2.css" rel="stylesheet" />
    <link href="../../assets/css/simple-line-icons.css" rel="stylesheet" />
    <link href="../../assets/css/jquery.gritter.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="../../assets/css/bootstrap-switch.min.css" rel="stylesheet" />
    <script src="../../assets/js/jquery-1.11.1.min.js"></script>
    <script src="../../assets/js/jquery-ui-1.10.3.min.js"></script>
    <link href="../../assets/css/style.datatables.css" rel="stylesheet">
    <link href="//cdn.datatables.net/responsive/1.0.1/css/dataTables.responsive.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="../../js/html5shiv.js"></script>
    <script src="../../js/respond.min.js"></script>

    <![endif]-->
	

</head>

<body>
<header>
    <div class="headerwrapper">
        <div class="header-left">
            <a href="index" class="logo">
                <img src="../../assets/images/logo.png" alt="" />
            </a>
            <div class="pull-right">
                <a href="" class="menu-collapse">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div><!-- header-left -->
        <div class="header-right">

            <div class="pull-right">
                <?php if($isLogin != 1){ ?>
                    <div class="btn-group btn-group-option">
                        <a href="register" class="btn btn-default">
                            <i class="glyphicon glyphicon-user"></i>
                            Register
                        </a>
                    </div><!-- btn-group -->
                <?php } ?>
                <div class="btn-group btn-group-option">
                    <a href="<?php echo $loginLink; ?>" class="btn btn-default">
                        <i class="glyphicon glyphicon-off"></i>
                        <?php echo $loginText; ?>
                    </a>
                </div><!-- btn-group -->

            </div><!-- pull-right -->

        </div><!-- header-right -->

    </div><!-- headerwrapper -->
</header>

<section>
    <div class="mainwrapper">
        <div class="leftpanel">
            <div class="media profile-left">
                <a class="pull-left profile-thumb" href="profile.html">
                    <img class="img-circle" src="../../assets/images/photos/profile.png" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $user_full_name; ?></h4>
                </div>
            </div><!-- media -->

            <h5 class="leftpanel-title">Navigation</h5>
            <ul class="nav nav-pills nav-stacked">
                <?php
                if($_SERVER['PHP_SELF'] == '/app/admin/manage-trip.php' || $_SERVER['PHP_SELF'] == '/app/admin/trip.php'){$manage_class = 'class="active"';}else{$manage_class = '';}
                if($_SERVER['PHP_SELF'] == '/app/client/trips.php' || $_SERVER['PHP_SELF'] == '/app/client/my-trips.php'){$trip_class = 'class="parent active"';}else{$trip_class = 'class="parent"';}
                ?>

                <?php
                if($userType == 'Admin'){
                ?>
                <li <?php echo $manage_class; ?>><a href="manage-trip"><i class="glyphicon glyphicon-road"></i> <span>Manage Trips</span></a></li>
                <?php }else { ?>
                <li <?php echo $trip_class; ?>><a href="#"><i class="glyphicon glyphicon-road"></i> <span>Trips</span></a>
                    <ul class="children">
                        <li><a href="trips">View Trips</a></li>

                        <?php if($isLogin == 1){ ?>
                        <li><a href="my-trips">Registered Trips</a></li>
                        <?php } ?>
                    </ul>
                </li>

                <?php } ?>

            </ul>

        </div><!-- leftpanel -->