<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
   
  <!-- Page level plugin CSS-->
     <link href="<?= site_url('assets/vendor/css/sb-admin.css');?>" rel="stylesheet">
    <link href="<?= site_url('assets/vendor/datatables/dataTables.bootstrap4.css');?>" rel="stylesheet">
      <link href="<?= site_url('assets/vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">
    <link href="<?= site_url('assets/css/style.css');?>" rel="stylesheet">     
    <link href="<?= site_url('assets/vendor/datatables/responsive.dataTables.min.css');?>" rel="stylesheet">
    <link href="<?= site_url('assets/vendor/datatables/rowGroup.dataTables.min.css');?>" rel="stylesheet">
    <!-- plugin  -->

    <link href="<?= site_url('assets/plugins/bootstrap-select.min.css');?>" rel="stylesheet">
    <link href="<?= site_url('assets/plugins/lc_switch.css');?>" rel="stylesheet">
    <link href="<?= site_url('assets/plugins/datepicker/css/datepicker.css');?>" rel="stylesheet">
    <link href="<?= site_url('assets/plugins/inputflag/build/css/intlTelInput.css');?>" rel="stylesheet">
    <!-- plugin  -->
  <!-- Custom styles for this template-->
   
     <!-- Bootstrap core JavaScript-->
    <script src="<?= site_url('assets/vendor/jquery/jquery.min.js');?>"></script>    
    <script src="<?= site_url('assets/vendor/bootstrap/js/popper.min.js');?>"></script> 
    <script src="<?= site_url('assets/vendor/bootstrap/js/bootstrap.min.js');?>"></script> 
     <script src="<?= site_url('assets/plugins/inputflag/build/js/intlTelInput-jquery.js');?>"></script>   
    <script src="<?= site_url('assets/plugins/inputflag/build/js/intlTelInput.js');?>"></script> 
    <script src="<?= site_url('assets/vendor/datatables/jquery.dataTables.js');?>"></script>
  
   
      <!-- Core plugin JavaScript--> 
    <script src="<?= site_url('assets/vendor/jquery-easing/jquery.easing.min.js');?>"></script>

      <!-- Page level plugin JavaScript--> 
    <script src="<?= site_url('assets/vendor/chart.js/Chart.min.js');?>"></script>
    <script src="<?= site_url('assets/vendor/datatables/dataTables.responsive.min.js');?>"></script>
    <!-- <script src="<?= site_url('assets/vendor/datatables/dataTables.rowGroup.min.js');?>"></script> -->
    <script src="<?= site_url('assets/vendor/datatables/dataTables.bootstrap4.js');?>"></script>
    <!-- plugin  -->
    <script src="<?= site_url('assets/plugins/bootstrap-select.min.js');?>"></script>
    <script src="<?= site_url('assets/plugins/lc_switch.js');?>"></script>
    <script src="<?= site_url('assets/plugins/jquery.validate.min.js');?>"></script>
    <script src="<?= site_url('assets/plugins/bootbox.min.js');?>"></script>
    <script src="<?= site_url('assets/plugins/bootbox.locales.min.js');?>"></script>
    <script src="<?= site_url('assets/plugins/datepicker/js/datepicker.js'); ?>"></script>
    <script src="<?= site_url('assets/plugins/easy-number-separator.js'); ?>"></script>
    
        
  <!-- plugin  -->
  <style>
 
  </style>
</head>

<body id="page-top">
<?php $this->view('nav'); ?>    
  
<div class="loader" style="display: none" ><img src="<?= site_url('assets/img/PageLoader.gif') ?>"></div>