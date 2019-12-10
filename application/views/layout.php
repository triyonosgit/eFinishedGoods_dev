<!DOCTYPE html>
<html>
<head>
    <!--<META HTTP-EQUIV="refresh" CONTENT="3600;URL=<?php echo base_url() ?>index.php/login/logout">-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>eFinishedGoods</title>
    <link rel="shortcut icon" href="<?php echo base_url('asset/img/ssm.jpg');?>" />
    <link href="<?php echo base_url('asset/bootstrap_3_2_0/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/bootstrap_3_2_0/css/bootstrap-theme.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/hovernav/hovernav.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/bootstrap_datepicker/css/datepicker.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('asset/bootstrap_table/src/bootstrap-table.css'); ?>" rel="stylesheet">

    <script src="<?php echo base_url('asset/js/jquery-3.3.1.js'); ?>"></script>
</head>
<body>
  <?php
      //session_start();

      $inactive = 600;

      if ((time() - $_SESSION['timestamp']) > $inactive) {
          redirect('login/logout');
      } else {
          $_SESSION['timestamp'] = time();
      }
  ?>
<div id="wrapper">
    <div id="navigasi">
        <?php
            //$this->load->view('admin/navbar');
            $this->load->view('navbar');
        ?>
    </div> <!-- end navigasi -->


    <div class="main-content">
        <?php $this->load->view($main_view); ?>
    </div>


    <div id="footer">
        <div class="container">
            <p class="text-muted">
                Copyright &copy; 2015 Departemen IT - PT. Sinar Sakti Metalindo.
            </p>
        </div>
    </div>


    <!--<script src="php// echo base_url('asset/js/jquery-1.11.1.min.js'); "></script>-->
    <script src="<?php echo base_url('asset/bootstrap_3_2_0/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/hovernav/hovernav.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_datepicker/js/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo base_url('asset/tinymce_4_1_6/js/tinymce/tinymce.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/psb.js'); ?>"></script>
    <script src="<?php echo base_url('asset/js/MY_javascript.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_table/src/bootstrap-table.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_table/src/locale/bootstrap-table-en-US.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_table/src/extensions/export/bootstrap-table-export.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_table/src/extensions/toolbar/bootstrap-table-toolbar.js'); ?>"></script>
    <script src="<?php echo base_url('asset/bootstrap_table/src/extensions/resizable/bootstrap-table-resizable.js'); ?>"></script>
    <script src="<?php echo base_url('asset/jquery/tableExport.js'); ?>"></script>
    <script src="<?php echo base_url('asset/jquery/colResizable-1.5.source.js'); ?>"></script>
    <script src="<?php echo base_url('asset/numeral/min/numeral.min.js'); ?>"></script>
    <script src="<?php echo base_url('asset/jquery-validate/jquery.validate.js'); ?>"></script>
    <script src="<?php echo base_url('asset/EasyAutocomplete_1_3_5/jquery.easy-autocomplete.min.js'); ?>"></script>



</div><!-- wrapper-->

<!-- Noscript -->
<noscript>
    <p class="noscript">Javascript pada browser Anda tidak diaktifkan. Silakan mengaktifkan Javascript.</p>
    <style type="text/css">
        #wrapper { display:none; }
        .noscript {
            text-align: center;
            color: #ff0000;
            font-size: 1.5em;
            vertical-align: 50%;
            margin: 250px;
            border: 1px solid;
        }
    </style>
</noscript>
</body>
</html>
