<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo base_url('asset/img/ssm.jpg') ?>">

    <title>eFinishedGoods</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('asset/bootstrap_3_2_0/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('asset/css/signin.css'); ?>" rel="stylesheet">

    <!-- Custom styles for sticky footer -->
    <link href="<?php echo base_url('asset/css/sticky-footer.css'); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('asset/html5shiv/html5shiv.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/respond/respond.min.js'); ?>"></script>
    <![endif]-->
</head>

<body>
    <div class="bg"></div>

    <div id="wrap">
        <div id="header">
            <div class="container">

            </div>
        </div>

        <div id="content">
            <div class="container">
                <?php
                $error = !empty($validation_errors) ? $validation_errors : $this->session->flashdata('pesan_error');
                ?>
                <?php if ($error) : ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <span class="sr-only">Error:</span>
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <?php if (is_array($error)) : ?>
                                    <?php foreach ($error as $err) : ?>
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                        <?php echo $err; ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <?php echo $error; ?>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <form class="form-signin" role="form" action="<?php echo site_url('login') ?>" method="post">
                    <h1 align="center" class="form-signin-heading">eFinishedGoods</h1>
                    <h2 align="center" class="form-signin-heading">Silakan login</h2>
                    <input type="text" name="username" class="form-control" placeholder="Username" autofocus="autofocus" value="<?php echo set_value('username') ?>">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo set_value('password') ?>">
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                </form>
            </div> <!-- /container -->
        </div> <!-- content -->
    </div> <!-- wrap -->

    <!--
<div id="footer">
        <div class="container">
            <p class="text-muted">
                Copyright &copy; 2015 Teddy Djohan - PT. Sinar Sakti Metalindo.
            </p>
        </div>
</div>
-->



    <script src="<?php echo base_url('asset/js/jquery-1.11.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_3_2_0/js/bootstrap.min.js'); ?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url('asset/js/ie10-viewport-bug-workaround.js'); ?>"></script>
</body>

</html>