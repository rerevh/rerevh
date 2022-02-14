<?php
/* Smarty version 3.1.33, created on 2019-10-11 16:54:37
  from '/www/kemsos_psks/application/views/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5da0b3cdb78860_53546205',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0c546142e70ae9035e3dc50bc76a8849ac00e5de' => 
    array (
      0 => '/www/kemsos_psks/application/views/index.tpl',
      1 => 1570812126,
      2 => 'file',
    ),
    '40efb2358250bb55c3b46f61c07c88f7c46447de' => 
    array (
      0 => '/www/kemsos_psks/application/views/navigation.tpl',
      1 => 1570811895,
      2 => 'file',
    ),
    'e6e20a3f25a83a6c4485a9df7b316044d464c614' => 
    array (
      0 => '/www/kemsos_psks/application/views/header_bar.tpl',
      1 => 1570810985,
      2 => 'file',
    ),
    '8ee9ae1d20cb7368a1048825e0bcc7bb5ecdb430' => 
    array (
      0 => '/www/kemsos_psks/application/views/identitas/main.tpl',
      1 => 1570811201,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 3600,
),true)) {
function content_5da0b3cdb78860_53546205 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>PSKS KEMENSOS</title>
	<link rel="shortcut icon" type="image/x-icon" href="assets/images/kemensos.png">

	<!-- Main Styles -->
	<link rel="stylesheet" href="assets/spaceX/assets/styles/style.min.css">
	
	<!-- Themify Icon -->
	<link rel="stylesheet" href="assets/spaceX/assets/fonts/themify-icons/themify-icons.css">

	<!-- mCustomScrollbar -->
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.min.css">

	<!-- Waves Effect -->
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/waves/waves.min.css">

	<!-- Sweet Alert -->
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/sweet-alert/sweetalert.css">
	
	<!-- Percent Circle -->
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/percircle/css/percircle.css">

	<!-- Chartist Chart -->
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/chart/chartist/chartist.min.css">

	<!-- FullCalendar -->
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/fullcalendar/fullcalendar.min.css">
	<link rel="stylesheet" href="assets/spaceX/assets/plugin/fullcalendar/fullcalendar.print.css" media='print'>

	<script type="text/javascript">
        var API_host = "http://localhost/kemsos_API/";
        var host = "http://localhost/kemsos_psks/";
        var modul = "identitas";
    </script>
</head>

<body>
<div class="main-menu">
	<header class="header">
		<a href="https://kemsos.go.id/" target="_blank" class="logo">
			<img src="assets/images/logo_kemsos_white.png">
		</a>
		<button type="button" class="button-close fa fa-times js__menu_close"></button>
	</header>
	<!-- /.header -->
	<div class="content">
		<div class="navigation">
	<h5 class="title" style="text-align: center !important;">Potensi Sumber Kesejahteraan Sosial</h5>
	<!-- /.title -->
	<ul class="menu js__accordion">
		<li id="nav-dashboard" class="cust-nav current">
			<a class="waves-effect" href="http://localhost/kemsos_psks/">
				<i class="menu-icon ti-bar-chart"></i><span>Dashboard</span>
			</a>
		</li>
		<li id="nav-identitas" class="cust-nav">
			<a class="waves-effect" href="http://localhost/kemsos_psks/identitas">
				<i class="menu-icon ti-user"></i><span>Identitas Diri</span>
			</a>
		</li>
		<li id="nav-keluarga" class="cust-nav">
			<a class="waves-effect" href="http://localhost/kemsos_psks/keluarga">
				<i class="menu-icon ti-link"></i><span>Keluarga Terdamping</span>
			</a>
		</li>
		<li id="nav-diklat" class="cust-nav">
			<a class="waves-effect" href="http://localhost/kemsos_psks/diklat">
				<i class="menu-icon ti-agenda"></i><span>Pendidikan dan Latihan</span>
			</a>
		</li>
		<li class="cust-nav">
			<a class="waves-effect" href="javascript:;" onclick="logout();">
				<i class="menu-icon ti-power-off"></i><span>Logout</span>
			</a>
		</li>
	</ul>
	<!-- /.menu js__accordion -->
</div>	</div>
	<!-- /.content -->
</div>
<!-- /.main-menu -->

<div class="fixed-navbar">
	<div class="pull-left">
		<button type="button" class="menu-mobile-button glyphicon glyphicon-menu-hamburger js__menu_mobile"></button>
		<h1 class="page-title">Identitas Diri</h1>
		<!-- /.page-title -->
	</div>
	<!-- /.pull-left -->
	<div class="pull-right">
	<div class="ico-item" id="waktu"></div>
	<!-- /.ico-item -->
	<div class="ico-item">
		<i class="ti-user"></i>
		<ul class="sub-ico-item">
			<li><a class="js__logout" href="javascript:;" onclick="logout();">Log Out</a></li>
		</ul>
		<!-- /.sub-ico-item -->
	</div>
</div>	<!-- /.pull-right -->
</div>
<!-- /.fixed-navbar -->

<!-- /#message-popup -->
<div id="wrapper">
	<div class="main-content">
		Identitas Diri	
		<footer class="footer">
			<ul class="list-inline">
				<li>2019 © <a href="https://kemsos.go.id" target="_blank">Kementerian Sosial Republik Indonesia</a> - All Rights Reserved</li>
			</ul>
		</footer>
	</div>
	<!-- /.main-content -->
</div><!--/#wrapper -->
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="assets/script/html5shiv.min.js"></script>
		<script src="assets/script/respond.min.js"></script>
	<![endif]-->
	<!-- 
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="assets/spaceX/scripts/jquery.min.js"></script>
	<script src="assets/spaceX/scripts/modernizr.min.js"></script>
	<script src="assets/spaceX/assets/plugin/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/spaceX/assets/plugin/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="assets/spaceX/assets/plugin/nprogress/nprogress.js"></script>
	<script src="assets/spaceX/assets/plugin/sweet-alert/sweetalert.min.js"></script>
	<script src="assets/spaceX/assets/plugin/waves/waves.min.js"></script>
	<!-- Sparkline Chart -->
	<script src="assets/spaceX/assets/plugin/chart/sparkline/jquery.sparkline.min.js"></script>
	<script src="assets/spaceX/scripts/chart.sparkline.init.min.js"></script>

	<!-- Percent Circle -->
	<script src="assets/spaceX/assets/plugin/percircle/js/percircle.js"></script>

	<!-- Google Chart -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<!-- Chartist Chart -->
	<script src="assets/spaceX/assets/plugin/chart/chartist/chartist.min.js"></script>
	<script src="assets/spaceX/scripts/jquery.chartist.init.min.js"></script>

	<!-- FullCalendar -->
	<script src="assets/spaceX/assets/plugin/moment/moment.js"></script>
	<script src="assets/spaceX/assets/plugin/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/spaceX/assets/scripts/fullcalendar.init.js"></script>

	<script src="assets/spaceX/scripts/main.min.js"></script>
	<script src="assets/js/main.js"></script>
</body>
</html><?php }
}
