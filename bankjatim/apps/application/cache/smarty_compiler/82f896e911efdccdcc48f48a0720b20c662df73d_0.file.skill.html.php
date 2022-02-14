<?php
/* Smarty version 3.1.33, created on 2022-01-26 11:24:30
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\career\skill.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f0ccfe860471_55464609',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '82f896e911efdccdcc48f48a0720b20c662df73d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\career\\skill.html',
      1 => 1642381878,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./toolsbutton.html' => 1,
    'file:../dfCompModal_window.html' => 1,
  ),
),false)) {
function content_61f0ccfe860471_55464609 (Smarty_Internal_Template $_smarty_tpl) {
?><!--begin::Page Vendors Styles(used by this page)-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/js/bootstrap-duallistbox.js"><?php echo '</script'; ?>
>
<link href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/css/bootstrap-duallistbox.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
<!--end::Page Vendors Styles-->
<style>
.swal2-icon.swal2-question {
  border-color: #ee9d01;
  color: #ee9d01;
}
ul{
	list-style-type: none;
	padding-left: 0;
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
								<div class="col-4">Job Family</div>
								<div class="col-8 row">:&nbsp;<div id="v_jf"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Sub Job Family</div>
								<div class="col-8 row">:&nbsp;&nbsp;&nbsp;&nbsp;<div>
									<ul id="v_sjf">

									</ul>
								</div>
								</div>
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
				<div id="form_skill" style="display: none">
					<input class="form-control" id="skill_id" name="skill_id" type="hidden">
					<div class="card-body py-3">
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-form-label text-left col-lg-12">Job Family</label>
								<div class="col-lg-12">
									<div class="typeahead">
										<input type="text" class="form-control" id="skill_name" name="skill_name" placeholder="Add Job Family">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-form-label text-left col-lg-12">Job Family Code</label>
								<div class="col-lg-12">
									<div class="typeahead">
										<input type="text" class="form-control" id="skill_code" name="skill_code" placeholder="Add JF Code">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				                  				
				<div id="form_subskill" style="display: none">
					<input class="form-control" id="subskill_id" name="subskill_id" type="hidden">
					<div class="card-body py-3">
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-form-label text-left col-lg-12">Sub Job Family</label>
								<div class="col-lg-12">
									<div class="typeahead">
										<input type="text" class="form-control" id="subskill_name" name="subskill_name" placeholder="Add Sub Job Family">
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label class="col-form-label text-left col-lg-12">Sub Job Family Code</label>
								<div class="col-lg-12">
									<div class="typeahead">
										<input type="text" class="form-control" id="subskill_code" name="subskill_code" placeholder="Add SJF Code">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="form_skillmap" style="display: none">
					<input class="form-control" id="skillmap_id" name="skillmap_id" type="hidden">
					<div class="card-body py-3">
						<div class="col-lg-10 row">
							<div class="col-5">
								<div class="form-group">
									<label class="col-form-label text-left col-lg-12">Job Family </label>
									<div class="col-lg-12">
										<select class="form-control" name="skill_id_select" id="skill_id_select">

										</select>
									</div>
								</div>
							</div>
							<div class="col-7">
								<div id="kt_repeater_1">
									<div class="form-group">
										<label class="col-form-label text-left col-lg-12">Sub Job Family</label>
										<div class="col-lg-12" data-repeater-list="" id="repeaterList1">
											<div class="form-group row mb-2" data-repeater-item>
												<div class="col-lg-10">
													<select class="form-control subskill_id_select" name="subskill_id_select" id="subskill_id_select">

													</select>
												</div>
												<div class="col-lg-2 removeButton_subskill" style="display: none">
													<a class="btn font-weight-bold btn-danger btn-icon subskill_id_rmbtn"
													   data-repeater-delete="">
														<i class="la la-remove"></i>
													</a>
												</div>
												<div class="col-lg-2 addButton_subskill">
													<a class="btn font-weight-bold btn-primary btn-icon"
													   data-repeater-create=""
													   id="addSkillBtn">
														<i class="la la-plus"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body py-3">
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
			<ul class="nav nav-tabs nav-tabs-line nav-tabs-line-3x" id="tab_list">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1" onclick="renderPick('Skill')">Job Family</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2" onclick="renderPick('Subskill')">Sub Job Family</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3" onclick="renderPick('Skillmap')">Job Family Map</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#kt_tab_pane_4" onclick="renderPick('compatibility')">Compatibility Matrix</a>
				</li>				
			</ul>
			<div class="tab-content mt-5" id="myTabContent">
				<div aria-labelledby="kt_tab_pane_1" class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
					<table class="table table-bordered table-hover table-checkable" id="kt_datatable_skill" style="width:100%; margin-top: 13px !important">
					</table>
				</div>
				<div aria-labelledby="kt_tab_pane_2" class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
					<table class="table table-bordered table-hover table-checkable" id="kt_datatable_subskill" style="width:100%; margin-top: 13px !important">
					</table>
				</div>
				<div aria-labelledby="kt_tab_pane_3" class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
					<table class="table table-bordered table-hover table-checkable" id="kt_datatable_skillmap" style="width:100%; margin-top: 13px !important">
					</table>
				</div>
				<div aria-labelledby="kt_tab_pane_4" class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
       	  <div id="matrix_parameter" class="row mt-5 mb-5" style="display:block">
            <div class="col ml-5">
              <div class="row">
              	<p>Please select compatibility matrix type</p>
              </div>
              <div class="row">
   							<div class="radio-inline mb-3">        								
   								<label class="radio radio-solid font-weight-bold">
   									<input class="form-control" type="radio" id="matrix_method" name="matrix_method" checked value="0"/>
   									<span></span>
   									Normal
   								</label>								
   								<label class="radio radio-solid font-weight-bold">
   									<input class="form-control" type="radio" id="matrix_method" name="matrix_method" value="1"/>
   									<span></span>
   									Special
   								</label>							
   							</div>    
              </div>
            </div>		  
       	  </div> 
          <div class="row">
            <div class="col">
              <form id="compability_form">
                <select multiple size="10" id="duallistbox_matrix" name="duallistbox_matrix" class="jobfamily_list">
                </select>
                <br>
                <div class="row">
                  <div class="col-md-6 offset-md-6">
                    <button type="submit" class="btn btn-primary w-10" style="float: right;">Show Compability Matrix</button>
                  </div>
                </div>
              </form>
            </div>
          </div>      
      		<div id="matrixdata_list">   
    	    </div>	
				</div>				
			</div>
	    </div>	
	    <!--end: Datatable-->   
   </div>
   <?php $_smarty_tpl->_subTemplateRender('file:../dfCompModal_window.html', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
</div>
<!--begin::Page Vendors(used by this page)-->
<!-- <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/js/validation.js"><?php echo '</script'; ?>
> !-->
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
var compmatrix = $('select[name="duallistbox_matrix[]"]').bootstrapDualListbox({
  nonSelectedListLabel: 'Non-selected',
  selectedListLabel: 'Selected',
  preserveSelectionOnMove: 'moved',
  moveOnSelect: false,
});
 
var jobfamily_list = $('.jobfamily_list').bootstrapDualListbox({
  nonSelectedListLabel: 'Available Job Family',
  selectedListLabel: 'Selected Job Family',
  preserveSelectionOnMove: 'moved',
  moveOnSelect: true,
});  
<?php echo '</script'; ?>
>
<!--end::Page Vendors--><?php }
}
