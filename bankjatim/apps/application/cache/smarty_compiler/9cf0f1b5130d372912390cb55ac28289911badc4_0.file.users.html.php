<?php
/* Smarty version 3.1.33, created on 2022-01-25 12:49:01
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\career\users.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61ef8f4d4d6b19_60678341',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9cf0f1b5130d372912390cb55ac28289911badc4' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\career\\users.html',
      1 => 1641359708,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./toolsbutton.html' => 1,
  ),
),false)) {
function content_61ef8f4d4d6b19_60678341 (Smarty_Internal_Template $_smarty_tpl) {
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
   <div class="card-body">
  		<div id="data_crud" style="display:none">
        <div id="form_crud">
          <form class="form" id="kt_form_crud">
            <input class="form-control" type="hidden" id="form_method" name="form_method">
<!--            <input class="form-control" type="hidden" id="users_id" name="users_id">							-->
          	<div id="input_crud">
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Users ID</label>
                                        <input class="form-control" id="user_id" name="user_id" placeholder="Fill the users" type="text" disabled/>
                                        <span class="form-text text-muted">Fill the users ID</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>          		
          		
                           <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" id="nama" name="nama" placeholder="Fill the name" type="text"/>
                                        <span class="form-text text-muted">Fill the users name</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>          		

                           <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input id="email" name="email" type="text" class="form-control" placeholder="Fill Email" minlength="3" maxlength="50"/>
                                        <span class="form-text text-muted">Fill Email</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div> 
                            
                           <div class="row">
                                <div class="col-xl-3">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Group</label>
              						              <select class="form-control" id="usergrp_id" name="usergrp_id" style="width: 100%">
                                                      <option value=""></option>
                                                      <option value="1">Admin</option>
                                                      <option value="2">User</option>
              						              </select>
                                        <span class="form-text text-muted">Select user group</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                
                                <div class="col-xl-3">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Status</label>
              						              <select class="form-control" id="actsts" name="actsts" style="width: 100%">
                                                      <option value=""></option>
                                                      <option value="1">Active</option>
                                                      <option value="2">Not Active</option>
              						              </select>
                                        <span class="form-text text-muted">Select status</span>
                                    </div>
                                    <!--end::Input-->
                                </div>                                
                            </div>                                         		

                           <div class="row">
                                <div class="col-xl-3" id="passwordInput">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="pword" name="pword" type="password" class="form-control" placeholder="Fill Password" minlength="3" maxlength="50"/>
                                        <span class="form-text text-muted">Fill Password</span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                
                                <div class="col-xl-3" id="passwordInput2">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input id="pword_check" name="pword_check" type="password" class="form-control" placeholder="Fill Password" minlength="3" maxlength="50"/>
                                        <span class="form-text text-muted">Fill Password</span>
                                    </div>
                                    <!--end::Input-->
                                </div>                                
                            </div>                             
          	</div>	 	    	  				                                  	                        				       
            <div id="action_button">
              <div class="row">
              	<div class="col-lg-12 ml-lg-auto">
              		<button type="submit" class="btn btn-primary font-weight-bold mr-2" id="submitButton" name="submitButton">Save</button>
              		<button type="reset" class="btn btn-light-primary font-weight-bold" id="cancelButton" name="cancelButton" >Cancel</button>
              		<button type="button" class="btn btn-light-primary font-weight-bold" id="backButton" name="backButton">Back</button>
              	</div>
              </div>
            </div>
          </form>
        </div>	
  		</div>		
  		
  		<!--begin: Search Form-->
  		<div id="data_filter" style="display:none">    		
        <form class="kt-form kt-form--fit mb-15" id="formfilter">
        		<div class="row mb-6">
        			<div class="col-lg-6 mb-lg-0 mb-12">
        				<label>Search:</label>
        				<input type="text" class="form-control datatable-input" placeholder="" id="find_data" name="find_data"/>
        			  <span class="form-text text-muted">Input character to find</span> 
        			</div>
        			
        			<div class="col-lg-3  mb-lg-0 mb-6">
        				<label>Group :</label>
    						<select class="form-control" id="find_group">
    							<option value="">All</option>
    							<option value="1">Administrator</option>
    							<option value="2">User</option>
    						</select>
            	  <span class="form-text text-muted">Select user group</span>    
        			</div>          			
        			
        			<div class="col-lg-3  mb-lg-0 mb-6">
        				<label>Status :</label>
    						<select class="form-control" id="find_status">
    							<option value="">All</option>
    							<option value="1">Active</option>
    							<option value="2">Not active</option>
    						</select>
            	  <span class="form-text text-muted">Select user status</span>    
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
