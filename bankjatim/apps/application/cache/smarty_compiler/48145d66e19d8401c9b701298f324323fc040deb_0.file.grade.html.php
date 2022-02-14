<?php
/* Smarty version 3.1.33, created on 2022-01-25 12:49:24
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\career\grade.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61ef8f642bd766_37643316',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '48145d66e19d8401c9b701298f324323fc040deb' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\career\\grade.html',
      1 => 1642989975,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./toolsbutton.html' => 1,
  ),
),false)) {
function content_61ef8f642bd766_37643316 (Smarty_Internal_Template $_smarty_tpl) {
?><!--begin::Page Vendors Styles(used by this page)-->
<link href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<!--end::Page Vendors Styles-->    
<style>
.swal2-icon.swal2-question {
  border-color: #ee9d01;
  color: #ee9d01;
}	
</style>                
<div class="card card-custom">
   <div class="card-header">
	   <div id="modul_title" class="card-title">
		   <h3 class="card-label"><?php echo $_smarty_tpl->tpl_vars['modul_title']->value;?>

		   <div class="text-muted pt-2 font-size-sm"><?php echo $_smarty_tpl->tpl_vars['modul_desc']->value;?>
</div>
		   </h3>	   
	   </div>
	   <div id="tool_button" class="card-toolbar">
          <?php $_smarty_tpl->_subTemplateRender('file:./toolsbutton.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>               
	   </div> 	   
   </div>
    <div id="form_view" style="display: none">
        <div class="col row" style="margin-top: 4rem">
            <div class="col-6">
                <div class="col">
                    <div>
                        <div class="card-body py-3 col-lg-12">
                            <div class="row mb-2">
                                <div class="col-4">Kelompok Jabatan</div>
                                <div class="col-8 row">:&nbsp;<div id="v_jobgroup"></div></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Job Grade</div>
                                <div class="col-8 row">:&nbsp;<div id="v_jobgrade"></div></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Personal Grade</div>
                                <div class="col-8 row">:&nbsp;<div id="v_grade"></div></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">Corporate Title</div>
                                <div class="col-8 row">:&nbsp;<div id="v_grade_name"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col text-center mt-5">
            <button type="button" class="btn btn-light-primary font-weight-bold" id="backButton" name="backButton">Back</button>
        </div>
    </div>
    <div id="data_crud" style="display: none">
        <div id="form_crud">
            <form class="from" id="kt_form_crud">
                <input class="form-control" id="form_method" name="form_method" type="hidden">
                <input class="form-control" id="grade_id" name="grade_id" type="hidden">
                <div id="form_field">
                    <div class="card-body py-3">
                        <div class="col-lg-10 row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="col-form-label text-left col-lg-12">Kelompok Jabatan</label>
                                    <div class="col-lg-12">
                                        <select style="width: 100%" class="form-control" id="jobgroup" name="jobgroup">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="col-form-label text-left col-lg-12">Job Grade</label>
                                    <div class="col-lg-12">
                                        <input onkeyup="this.value = this.value.toUpperCase()" class="form-control" id="jobgrade" name="jobgrade" placeholder="Add Job Grade" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label class="col-form-label text-left col-lg-12">Personal Grade</label>
                                    <div class="col-lg-12">
                                        <input class="form-control" id="grade" name="grade" placeholder="Add Personal Grade" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label text-left col-lg-12">Corporate Title</label>
                                    <div class="col-lg-12">
                                        <input class="form-control" id="grade_name" name="grade_name" placeholder="Add Corporate Title" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="col-lg-12 row">
                        <div id="action_button">
                            <div class="row">
                                <div class="col-lg-12 ml-lg-auto">
                                    <button type="submit" class="btn btn-primary font-weight-bold mr-2" id="submitButton" name="submitButton">Save</button>
                                    <button type="submit" class="btn btn-danger font-weight-bold mr-2" id="deleteButton" name="deleteButton">Delete</button>
                                    <button type="reset" class="btn btn-light-primary font-weight-bold mr-2" id="cancelButton" name="cancelButton">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
  		<!--begin: Search Form-->
  		<div id="data_filter" style="display:none">    		
        <form class="kt-form kt-form--fit mb-15" id="formfilter">
        		<div class="row mb-6">
        			<div class="col-lg-12 mb-lg-0 mb-12">
        				<label>Search:</label>
        				<input type="text" class="form-control datatable-input" placeholder="" id="find_data" name="find_data"/>
        			 <span class="form-text text-muted">Input character to search</span> 
        			</div>
        		</div>

        		<div class="row mt-8">
        			<div class="col-lg-12">
        				<button class="btn btn-primary btn-primary--icon mr-2" id="kt_search" name="kt_search">
        					<span>
        						<i class="la la-search"></i>
        						<span>Search</span>
        					</span>
        				</button>
        				<button class="btn btn-secondary btn-secondary--icon" id="kt_reset" name="kt_reset">
        					<span>
        						<i class="la la-close"></i>
        						<span>Reset</span>
        					</span>
        				</button>
        			</div>
        		</div>
        </form>  	
  		</div>	  		
	    <!--end: Search Form--> 	
	    
	    <!--begin: Datatable-->	
  		<div id="data_list">
  	    <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">  
        </table>  	    
	    </div>	
	    <!--end: Datatable-->   
   </div>
</div>
<!--begin::Page Vendors(used by this page)-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/js/validation.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.js"><?php echo '</script'; ?>
>
<!--end::Page Vendors--><?php }
}
