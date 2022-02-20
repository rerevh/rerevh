<section role="main" class="content-body">
    <header class="page-header">
        <h2>Activity</h2>

        <div class="right-wrapper pull-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="<?php echo base_url('Dashboard') ?>">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><a href="<?php echo base_url('Dashboard/settings') ?>"><span>Plan</span></a></li>
                <li><span>Detail Monthly Activity</span></li>
            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
        </div>
    </header>

    <section class="panel">
        <header class="panel-heading" style=" border: 1px solid #5B707B; padding: 10px 14px; background: #5B707B;">
            <h2 class="panel-title" style="font-size: medium; color: white;"><i class="fa fa-chevron-right"> </i> Detail Monthly Activity</h2>
        </header>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-3">
                    <!-- <div class="mb-md">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Upload Excel</a>
                        <a class="btn btn-primary download_excel_detail_budget">Download Format Excel</a>
                    </div> -->

                </div>
                <!--                                    <div class="col-sm-2">
						<div class="mb-md">
							<a class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add New</a>
						</div>
                                            
					</div>-->

                <!--					<div id="modalForm" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                                            <div class="message"></div>
						<form action="" id="addnew-form" method="post" class="form-horizontal mb-lg" >
							<section class="panel">
								<header class="panel-heading" style=" border: 1px solid #5B707B; padding: 10px 14px; background: #5B707B;">
									<h2 class="panel-title" style="font-size: medium; color: white;">Add New Stuff</h2>
								</header>
								<div class="panel-body">
									<div class="form-group mt-lg">
										<label class="col-sm-3 control-label">File</label>
										<div class="col-sm-6">
											<div id="edit-form"></div>
											<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
										</div>
									</div>

								</div>
								<footer class="panel-footer">
									<div class="row">
										<div class="col-md-12 text-right">
											<button type="button" class="btn btn-primary" id="btn_save" name="btn_save"><span class="glyphicon glyphicon-floppy-saved"></span> Save </button>
											<button type="button" class="btn btn-default modal-dismiss-form cancel"><span class="glyphicon glyphicon-off"></span> Close </button>
										</div>
									</div>

								</footer>
							</section>
						</form>
					</div>-->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Upload Excel</h4>
                            </div>
                            <div class="modal-body">
                                <p class="message"></p>
                                <input type="file" name="file" id="file">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" id="btn_save">Upload</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!--					<div id="modalConfirm" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
						<section class="panel">
							<header class="panel-heading">
								<h2 class="panel-title">Are you sure?</h2>
							</header>
							<div class="panel-body">
								<div class="modal-wrapper">
									<div class="modal-icon">
										<i class="fa fa-question-circle"></i>
									</div>
									<div class="modal-text">
										<p id="del-form"></p>
									</div>
								</div>
							</div>
							<footer class="panel-footer">
								<div class="row">
									<div class="col-md-12 text-right">
										<button  type="submit" id="btn_del" name="btn_del" class="btn btn-primary  modal-confirm">Confirm</button>
										<button class="btn btn-default modal-dismiss">Cancel</button>
									</div>
								</div>
								<br/>
									<div class="row">
										<div class="col-md-12">
											<div id="del-success" class="alert alert-success" style="display:none;">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
												<strong>Well done!</strong> The record has been successfully deleted.
											</div>

											<div id="del-failure" class="alert alert-danger" style="display:none;">
												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
												<strong>Oh snap!</strong> <span id="span-del-failure"></span>
											</div>
										</div>
									</div>
							</footer>
						</section>
					</div>-->

            </div>
            <div class="tabel"></div>
        </div>
    </section>
</section>




<!-- Vendor -->
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery/jquery.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<script src="<?= base_url(); ?>assets/adporto/vendor/select2/js/select2.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>


<!-- Specific Page Vendor -->
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-ui/jquery-ui.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/select2/js/select2.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-timepicker/bootstrap-timepicker.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/fuelux/js/spinner.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/dropzone/dropzone.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-markdown/js/markdown.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-markdown/js/to-markdown.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/lib/codemirror.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/addon/selection/active-line.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/addon/edit/matchbrackets.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/mode/javascript/javascript.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/mode/xml/xml.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/codemirror/mode/css/css.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/summernote/summernote.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/ios7-switch/ios7-switch.js"></script>
<!-- <script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap-confirmation/bootstrap-confirmation.js"></script> -->
<script src="<?= base_url(); ?>assets/adporto/vendor/magnific-popup/jquery.magnific-popup.js"></script>


<script src="<?= base_url(); ?>assets/adporto/vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="<?= base_url(); ?>assets/adporto/vendor/select2/js/select2.js"></script>
<script src="<?= base_url(); ?>assets/adporto/vendor/pnotify/pnotify.custom.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?= base_url(); ?>assets/adporto/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="<?= base_url(); ?>assets/adporto/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?= base_url(); ?>assets/adporto/javascripts/theme.init.js"></script>

<!-- Examples -->
<script src="<?= base_url(); ?>assets/adporto/javascripts/ui-elements/examples.modals.js"></script>
<!-- Examples -->
<script src="<?= base_url(); ?>assets/adporto/javascripts/forms/examples.advanced.form.js"></script>

<script src="<?= base_url(); ?>assets/adporto/javascripts/tables/examples.datatables.tabletools.js"></script>


<script>
    $(document).ready(function() {
        tabel();
        $(document).on('click', '.cancel', function(ee) {
            $('#modalForm').modal('hide');
            //    alert("tes");

        });
        $(document).on('click', '.download_excel_detail_budget', function(ee) {
            location.href = BASE_URL + "uploads/upload_detail_monthly.xlsx";
        })

        $(document).on('click', '#btn_save', function(ee) {
            var formData = new FormData("#modalForm");
            formData.append('file', $('#file').prop('files')[0]);
            $.ajax({
                url: BASE_URL + "index.php/Plan/Detail_monthly/simpan",
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                processData: false,
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $(".message").html("<div class=alert alert-warning>loading.......</div>");
                },
                success: function(databack) {
                    $(".message").html("");
                    if (databack.err == 's') {
                        $(".message").html("<div class=alert alert-success>Proses Upload Excel Success</div>");
                        tabel();
                        $('#modalForm').modal('hide');
                    } else {
                        $(".message").html("<div class=alert alert-warning>" + databack.err + "</div>");
                    }
                }
            });

        });
        $(document).on('change', '#status_update', function(ee) {
            $(".form_status_update").html("");
            var val = $(this).val();
            if (val == "2") {
                reason("");
            } else if (val == "3") {
                postponse("");
            }
        })

        $(document).on('click', '#update_status', function(ee) {
            var id = $(this).data("id");
            var status = $(this).data("status");
            $('.form_status_update').html("");
            //  $("#status_update option[value=]").attr("selected","selected");
            if (status == "2") {
                reason(id);
            } else if (status == "3") {
                postponse(id);
            }
            $("#status_update option[value=" + status + "]").attr("selected", "selected");
        })

        $(document).on('click', '.set_update_status', function(ee) {
            $(".form_status_update").html("");
            var id = $(this).data("id");
            $('#id_status_update').val(id);

        })
        $(document).on('click', '#btn_save_status_update', function(ee) {
            var id_status_update = $("#id_status_update").val();
            var status_update = $("#status_update").val();
            var reason = $("#reason").val();
            var month = $("#month").val();
            save_status_update(id_status_update, status_update, reason, month);

        })
    })

    function tabel() {
        $.ajax({
            type: "POST",
            url: BASE_URL + "index.php/Plan/Detail_monthly/tabel",
            beforeSend: function(jqXHR, setting) {
                $(".tabel").html("<div class='alert alert-warning'>loading.......</div>");
            },
            success: function(callback) {
                console.log(callback)
                $('.tabel').html("");
                $('.tabel').html(callback);
            }
        })
    }

    function reason(id) {
        $.ajax({
            type: "POST",
            url: BASE_URL + "index.php/Plan/Input_activity/alasan",
            data: {
                id: id
            },
            beforeSend: function(jqXHR, setting) {
                $(".form_status_update").html("<div class=alert alert-warning>loading.......</div>");
            },
            success: function(callback) {
                $('.form_status_update').html("");
                $('.form_status_update').html(callback);
            }
        })
    }

    function postponse(id) {
        $.ajax({
            type: "POST",
            url: BASE_URL + "index.php/Plan/Input_activity/postponse",
            data: {
                id: id
            },
            beforeSend: function(jqXHR, setting) {
                $(".form_status_update").html("<div class=alert alert-warning>loading.......</div>");
            },
            success: function(callback) {
                $('.form_status_update').html("");
                $('.form_status_update').html(callback);
            }
        })
    }

    function save_status_update(id_status_update, status_update, reason, month) {

        $.ajax({
            url: BASE_URL + "index.php/Plan/Input_activity/save_status_update",
            data: {
                id_status_update: id_status_update,
                status_update: status_update,
                reason: reason,
                month: month
            },
            type: "POST",
            dataType: "html",
            beforeSend: function() {
                $(".message").html("<div class=alert alert-warning>loading.......</div>");
            },
            success: function(databack) {
                $(".message").html("");
                if (databack == 's') {
                    $(".message").html("Data has been saved");
                    tabel();
                } else {
                    $(".message").html(databack);

                }
            }
        });
    }
</script>