<section role="main" class="content-body">
	<header class="page-header">
		<h2>Quarterly Plan</h2>

		<div class="right-wrapper pull-right">
			<ol class="breadcrumbs">
				<li>
					<a href="">
						<i class="fa fa-home"></i>
					</a>
				</li>
				<li><a href=""><span>Plan</span></a></li>
				<li><span>/Quarterly Plan</span></li>
            </ol>

			<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
		</div>
	</header>

		<section class="panel">
			<header class="panel-heading" style=" border: 1px solid #5B707B; padding: 10px 14px; background: #5B707B;">
				<h2 class="panel-title" style="font-size: medium; color: white;"><i class="fa fa-chevron-right"> </i> Quarterly Plan</h2>
			</header>
			   <div>



                                   <div class="panel-body">
                                       <div class="filter"></div>
                                       <div class="filter_quartal"></div>
                                       <br><br>
                                            <div class="tabel"></div>
                                        </div>

                          </div>
		</section>
                 <div id="myModal" class="modal fade" role="dialog">
                                                                    <div class="modal-dialog">

                                                                      <!-- Modal content-->
                                                                      <div class="modal-content">
                                                                        <div class="modal-header">
                                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                          <h4 class="modal-title">Status Update Monthly</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                                    <p class="message"></p>
                                                                                     <input type="hidden" class="form-control" id="id_status_update" name="id_status_update" value="">
                                                                                    <select class="form-control" id="status_update" name="status_update">
                                                                                        <option value="" seleted>Pilih</option>
                                                                                        <option value="1">Implement</option>
                                                                                        <option value="2">Cancel</option>
                                                                                        <option value="3">Postpone</option>   
                                                                                    </select>
                                                                                    <br><br>
                                                                                    <div class="form_status_update"></div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" id="btn_save_status_update">Save</button>
                                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                      </div>

                                                                    </div>
                                                          </div>
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
    tabel();
    filter();
    filter_quartal();
  //  form();
    $(document).on('click','.cancel',function(ee){
          $('#modalForm').modal('hide');
      //    alert("tes");

      });
      $(document).on('click','.download_excel_detail_budget',function(ee){
                location.href = BASE_URL+"uploads/upload_detail_monthly.xlsx";
        })
      $(document).on('click','.save',function(ee){
            save();
      })
      
      $(document).on('click','#input_detail_budget',function(ee){
          var id=$(this).data("id");
          form(id);
      })
      
       $(document).on('change','#filter_year',function(ee){
           var param = $(this).val();
           var quartal = $("#filter_quartal").val();
           $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/tabel",
                    data : 
                            {
                              param:param,
                              quartal:quartal
                            },
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".tabel").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.tabel').html("");
                      $('.tabel').html(callback);
                }
            })
       })
       
       $(document).on('change','#filter_quartal',function(ee){
           var param = $("#filter_year").val();
           var quartal = $("#filter_quartal").val();
           $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/tabel",
                    data : 
                            {
                              param:param,
                              quartal:quartal
                            },
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".tabel").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.tabel').html("");
                      $('.tabel').html(callback);
                }
            })
       })
      
      $(document).on('change','#status_update',function(ee){
            $(".form_status_update").html("");
            var val = $(this).val();
            if(val=="2")
            {
                reason("");
            }
            else if(val=="3")
            {
                postponse("");
            }
      })
      
      $(document).on('click','#update_status',function(ee){
             var id=$(this).data("id");
             var status=$(this).data("status");
             $('.form_status_update').html("");
            //  $("#status_update option[value=]").attr("selected","selected");
             if(status=="2")
             {
                 reason(id);
             }
             else if(status=="3")
             {
                 postponse(id);
             }
             $("#status_update option[value="+status+"]").attr("selected","selected");
      })
      
      $(document).on('click','.set_update_status',function(ee){
             $(".form_status_update").html("");
             var id=$(this).data("id");
             $('#id_status_update').val(id);
              
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
     $(document).on('click','#btn_save',function(ee){
               var formData = new FormData("#modalForm");
               formData.append('file', $('#file').prop('files')[0]);
             $.ajax({
                 url: BASE_URL+"index.php/Plan/quarterly_plan/simpan",
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
                       $(".message").html("<div class=alert alert-success>Proses Upload Excel Success</div>");
                       tabel();
                    } else {
                       $(".message").html("<div class=alert alert-warning>"+databack.err+"</div>");
                    }    
                 }
              });

      });
      $(document).on('click','#btn_save_status_update',function(ee){
            var id_status_update = $("#id_status_update").val();
            var status_update = $("#status_update").val();
            var reason = $("#reason").val();
            var month = $("#month").val();
            save_status_update(id_status_update,status_update,reason,month);
      })
})
function filter()
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/filter",
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".filter").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.filter').html("");
                      $('.filter').html(callback);
                }
            })
}
function filter_quartal()
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/filter_quartal",
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".filter_quartal").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.filter_quartal').html("");
                      $('.filter_quartal').html(callback);
                }
            })
}
function tabel()
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/tabel",
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
function form(id)
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/form",
                    data :
                            {
                              id:id  
                            },
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
function reason(id)
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/alasan",
                    data :
                            {
                                id:id
                            },
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".form_status_update").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.form_status_update').html("");
                      $('.form_status_update').html(callback);
                }
            })
}
function postponse(id)
{
        $.ajax({
                    type: "POST",
                    url : BASE_URL+"index.php/Plan/quarterly_plan/postponse",
                    data :
                            {
                                id:id
                            },
                    beforeSend : function(jqXHR,setting)
                    {
                       $(".form_status_update").html("<div class=alert alert-warning>loading.......</div>");
                    },
                    success: function(callback){
                      $('.form_status_update').html("");
                      $('.form_status_update').html(callback);
                }
            })
}
function save_status_update(id_status_update,status_update,reason,month)
{
    
    $.ajax({
         url: BASE_URL+"index.php/Plan/quarterly_plan/save_status_update",
         data:
                 {
                     id_status_update:id_status_update,
                     status_update:status_update,
                     reason:reason,
                     month:month
                 },
         type: "POST",
         dataType : "html",
         beforeSend: function() {
             $(".message").html("<div class=alert alert-warning>loading.......</div>");
         },
         success: function(databack) {
            $(".message").html("");
            if(databack=='s') {
                $(".message").html("Data has been saved");
            } else {
                $(".message").html(databack);
               
            }    
         }
      });
}
function save()
{
    
    $.ajax({
         url: BASE_URL+"index.php/Plan/quarterly_plan/save",
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
               //form();
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
         url: BASE_URL+"index.php/Plan/quarterly_plan/proses_edit",
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
               //form();
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
                url : BASE_URL+"index.php/Plan/quarterly_plan/form",
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
               url : BASE_URL+"index.php/Plan/quarterly_plan/delete",
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
                             alert("Data has been deleted");
                             tabel();
                     } else {
                             alert(databack.err);

                     }   
               }
            });
}
</script>
