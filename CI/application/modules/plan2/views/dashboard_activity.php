<script src="<?=base_url();?>assets/adporto/vendor/jquery/jquery.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap/js/bootstrap.js"></script>


<section role="main" class="content-body">
<header class="page-header">
	<h2>Monthly Activity</h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<a href="">
					<i class="fa fa-home"></i>
				</a>
			</li>
			<li><span>Intake</span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
</header>



<div class="row">
	<div class="col-md-12 col-lg-12 col-xl-12">
		<section class="panel">
			<div class="panel-body" style="border: 0px solid #232;">
				<div class="col-md-2" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
				<a href="<?php echo base_url('Plan/Monthly_activity');?>" class="col-sm-12 mb-xs mt-xs mr-xs btn btn-lg btn-primary"><i class=" fa-2x fa fa-registered"></i><br/><h6><br/>Activity</h6></a>
				</div>
				<div class="col-md-2" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
				<a href="<?php echo base_url('Plan/Monthly_activity/detail_budget') ?>" class="col-sm-12 mb-xs mt-xs mr-xs btn btn-lg btn-primary"><i class=" fa-2x fa fa-registered"></i><br/><h6><br/>Budget</h6></a>
				</div>

			</div>
		</section>
<!--
		<div id="modalRequest" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Request Form</h2>
				</header>
				<div class="panel-body">
					<div class="modal-wrapper">
						<div class="row">
							<div class="col-md-4" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
								<a href="<?php echo base_url('Request/DirectFund') ?>" class="col-sm-12 mb-xs mr-xs btn btn-lg btn-default">
									<i class=" fa-2x fa fa-circle"></i><br/><h6><br/>Direct<br>Fund</h6>
								</a>
							</div>
							<div class="col-md-4" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
								<a href="<?php echo base_url('Request/Services') ?>" class="col-sm-12 mb-xs mr-xs btn btn-lg btn-default">
									<i class=" fa-2x fa fa-circle"></i><br/><h6><br/><br>Services</h6>
								</a>
							</div>
							<div class="col-md-4" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
								<a href="<?php echo base_url('Request/ConsumableStuff') ?>" class="col-sm-12 mb-xs mr-xs btn btn-lg btn-default">
									<i class=" fa-2x fa fa-circle"></i><br/><h6><br/>Consumable<br>Stuff</h6>
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
								<a href="#modalFind" class="col-sm-12 mb-xs mr-xs btn btn-lg btn-default modal-with-zoom-anim on-default">
									<i class=" fa-2x fa fa-circle"></i><br/><h6><br/>Equipment/Electronic<br>Request</h6>
								</a>
							</div>
							<div class="col-md-4" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
								<a href="#" class="col-sm-12 mb-xs mr-xs btn btn-lg btn-default">
									<i class=" fa-2x fa fa-circle"></i><br/><h6><br/><br>Consultant</h6>
								</a>
							</div>
							<div class="col-md-4" style="border: 0px solid #232; padding-left: 5px; padding-right: 5px;">
								<a href="#" class="col-sm-12 mb-xs mr-xs btn btn-lg btn-default">
									<i class=" fa-2x fa fa-circle"></i><br/><h6><br/><br>Sub Award</h6>
								</a>
							</div>
						</div>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary modal-dismiss">Close</button>
						</div>
					</div>
					<br/>
				</footer>
			</section>
		</div>

		<div id="modalFind" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Find Your Request</h2>
				</header>
				<div class="panel-body">
					<div class="modal-wrapper">
						<section class="row">
							<div class="panel col-md-12">
								<div class="panel-body">

									<form action="<?php echo base_url('Request/lists') ?>" id="" method="post" class="">
										<div id="input-group-location" class="input-group" style="">
											<input type="text" name="txt_search" id="txt_search" class="form-control input" value="" placeholder='Type keyword (ex. "Laptop")' />
											<span class="input-group-btn">
												<button type="submit" id="btn_search" class="btn btn-default" ><i class="fa fa-search"></i></button>
											</span>
										</div>
										<p class="help">Type your key word and click "find"</p>
									</form>

								</div>	
							</div>
						</section>
					</div>
				</div>
				<footer class="panel-footer">
					<div class="row">
						<div class="col-md-12 text-right">
							<button class="btn btn-primary modal-dismiss">Close</button>
						</div>
					</div>
					<br/>
				</footer>
			</section>
		</div>-->

	</div>

</div>
</section>



<script src="<?=base_url();?>assets/adporto/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-appear/jquery-appear.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/flot/jquery.flot.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/flot.tooltip/flot.tooltip.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/flot/jquery.flot.pie.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/flot/jquery.flot.categories.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/flot/jquery.flot.resize.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-sparkline/jquery-sparkline.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/raphael/raphael.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/morris.js/morris.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/gauge/gauge.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/snap.svg/snap.svg.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/liquid-meter/liquid.meter.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/jquery.vmap.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>


<script src="<?=base_url();?>assets/adporto/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-placeholder/jquery-placeholder.js"></script>






<!-- Theme Base, Components and Settings -->
<script src="<?=base_url();?>assets/adporto/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="<?=base_url();?>assets/adporto/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?=base_url();?>assets/adporto/javascripts/theme.init.js"></script>

<!-- Examples -->
<script src="<?=base_url();?>assets/adporto/javascripts/ui-elements/examples.modals.js"></script>



</body>
</html>
