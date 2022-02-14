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
				<li><span>Detail Budget</span></li>
                                
            </ol>

			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
		</div>
	</header>

		<section class="panel">
			<header class="panel-heading" style=" border: 1px solid #5B707B; padding: 10px 14px; background: #5B707B;">
				<h2 class="panel-title" style="font-size: medium; color: white;"><i class="fa fa-chevron-right"> </i> Detail Budget</h2>
			</header>
                    
                        <div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" id="view1" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Form</a></li>
                              <li role="presentation" id="view2"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Table</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    <div class="message_form"></div>
                                     <div class="form"></div>
                                </div>
                              <div role="tabpanel" class="tab-pane" id="profile">
                                    <div class="panel-body">
                                                <div class="row"> 
                                                        <div class="col-sm-3">
                                                                <div class="mb-md">
                                                                        <a class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Upload Excel</a>
                                                                        <a class="btn btn-primary download_excel_detail_budget">Download Format Excel</a>
                                                                </div>

                                                        </div>
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

                                                </div>
                                            <div class="tabel"></div>
                                        </div>
                              </div>
                            </div>

                          </div>
			
		</section>
</section>




<!-- Vendor -->
<script src="<?=base_url();?>assets/adporto/vendor/jquery/jquery.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/nanoscroller/nanoscroller.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/magnific-popup/jquery.magnific-popup.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<script src="<?=base_url();?>assets/adporto/vendor/select2/js/select2.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>


<!-- Specific Page Vendor -->
<script src="<?=base_url();?>assets/adporto/vendor/jquery-ui/jquery-ui.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/select2/js/select2.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-timepicker/bootstrap-timepicker.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/fuelux/js/spinner.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/dropzone/dropzone.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-markdown/js/markdown.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-markdown/js/to-markdown.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/lib/codemirror.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/addon/selection/active-line.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/addon/edit/matchbrackets.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/mode/javascript/javascript.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/mode/xml/xml.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/codemirror/mode/css/css.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/summernote/summernote.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/ios7-switch/ios7-switch.js"></script>
<!-- <script src="<?=base_url();?>assets/adporto/vendor/bootstrap-confirmation/bootstrap-confirmation.js"></script> -->
<script src="<?=base_url();?>assets/adporto/vendor/magnific-popup/jquery.magnific-popup.js"></script>


<script src="<?=base_url();?>assets/adporto/vendor/bootstrap/js/bootstrap.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/jquery-placeholder/jquery-placeholder.js"></script>

<!-- Specific Page Vendor -->
<script src="<?=base_url();?>assets/adporto/vendor/select2/js/select2.js"></script>
<script src="<?=base_url();?>assets/adporto/vendor/pnotify/pnotify.custom.js"></script>

<!-- Theme Base, Components and Settings -->
<script src="<?=base_url();?>assets/adporto/javascripts/theme.js"></script>

<!-- Theme Custom -->
<script src="<?=base_url();?>assets/adporto/javascripts/theme.custom.js"></script>

<!-- Theme Initialization Files -->
<script src="<?=base_url();?>assets/adporto/javascripts/theme.init.js"></script>

<!-- Examples -->
<script src="<?=base_url();?>assets/adporto/javascripts/ui-elements/examples.modals.js"></script>
<!-- Examples -->
<script src="<?=base_url();?>assets/adporto/javascripts/forms/examples.advanced.form.js"></script>

<script src="<?=base_url();?>assets/adporto/javascripts/tables/examples.datatables.tabletools.js"></script>


<script>
$(document).ready(function() 
{
    form();
    tabel();
    popup();
    loading();
    $(document).on('click','.cancel',function(ee){
          $('#modalForm').modal('hide');
      //    alert("tes");

      });
      
     $(document).on('click','#btn_save',function(ee){
               var formData = new FormData("#modalForm");
               formData.append('file', $('#file').prop('files')[0]);
             $.ajax({
                 url: BASE_URL+"index.php/Plan/Activity/simpan",
                 data: formData,
                 mimeType:"multipart/form-data",
                 contentType: false,
                 processData:false,
                 type: "POST",
                 dataType : "json",
                 beforeSend: function() {
                        $(".message").html("<div class=alert alert-warning>loading.......</div>");
                 },
                 success: function(databack) {
                     $(".message").html("");          
                    if(databack.err=='s') {
                       $(".message").html("<div class=alert alert-success>Process Upload Excel Success</div>");
                       tabel();
                    } else {
                       $(".message").html("<div class=alert alert-warning>"+databack.err+"</div>");
                    }    
                 }
              });

      });
        $(document).on('click','.save',function(ee){
            save();
        })
         $(document).on('click','.download_excel_detail_budget',function(ee){
                location.href = BASE_URL+"uploads/uploadexcel.xlsx";
        })

         $(document).on('click','.proses_edit',function(ee){
            proses_edit();
        })
        
        $(document).on('click','a#edit',function(){
             var id=$(this).data("id");
                edit(id);

        });
        $(document).on('click','a#delete',function(){
                    var id=$(this).data("id");
                      if (confirm('Are you sure to delete this data')) {
                            del(id);
                     }
        });

})

function tabel()
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/Activity/tabel",
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".tabel").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.tabel').html("");
                      $('.tabel').html(callback);
                }
            })
}
function form()
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/Activity/form",
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".form").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.form').html("");
                      $('.form').html(callback);
                }
            })
}
function save()
{
    
    $.ajax({
         url: BASE_URL+"index.php/Plan/Activity/save",
         data: $('#submit').serialize(),
         type: "POST",
         dataType : "json",
         beforeSend: function() {
             open_loading();
         },
         success: function(databack) {
            close_loading();
            if(databack.err=='s') {
               alert("Data has been saved");
               tabel();
               form();
            } else {
               $(databack.klas).focus();
               alert(databack.err);
               
            }    
         }
      });
}
function proses_edit()
{
    
    $.ajax({
         url: BASE_URL+"index.php/Plan/Activity/proses_edit",
         data: $('#submit').serialize(),
         type: "POST",
         dataType : "json",
         beforeSend: function() {
             open_loading();
         },
         success: function(databack) {
            close_loading();
            if(databack.err=='s') {
               alert("Data has been edited");
               tabel();
               form();
            } else {
               $(databack.klas).focus();
               alert(databack.err);
               
            }    
         }
      });
}
function edit(id)
{
    $("#view2").removeClass( "active" );
    $("#view1").addClass( "active" );
    $("#profile").removeClass( "active" );
    $("#home").addClass( "active" );
    
    
       $.ajax({
                type: "POST",
                url : BASE_URL+"index.php/Plan/Activity/form",
                data :
                        {
                            id:id
                        },
                beforeSend : function(jqXHR,setting)
                {
                   $(".form").html("<div class=alert alert-warning>loading.......</div>");
                },
                success: function(callback){
                  $('.form').html("");
                  $('.form').html(callback);
            }
          })
}
function del(id)
{
    $.ajax({
               url : BASE_URL+"index.php/Plan/Activity/delete",
               data: 
                       {
                           id:id
                       },
               type: "POST",
               dataType : "json",
               beforeSend: function() {
                       open_loading();
               },
               success: function(databack) {
                    close_loading();
                    if(databack.err=='s') {
                             alert("Data telah di hapus");
                             tabel();
                     } else {
                             alert(databack.err);

                     }   
               }
            });
}
</script>
