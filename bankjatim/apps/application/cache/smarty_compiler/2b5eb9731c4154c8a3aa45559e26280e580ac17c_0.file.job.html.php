<?php
/* Smarty version 3.1.33, created on 2022-01-26 11:42:04
  from 'C:\xampp\htdocs\Bank_Jatim\apps\application\views\career\job.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f0d11ce7c4d2_25610655',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b5eb9731c4154c8a3aa45559e26280e580ac17c' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Bank_Jatim\\apps\\application\\views\\career\\job.html',
      1 => 1642473787,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./toolsbutton.html' => 1,
  ),
),false)) {
function content_61f0d11ce7c4d2_25610655 (Smarty_Internal_Template $_smarty_tpl) {
?><!--begin::Page Vendors Styles(used by this page)-->
<link href="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/third_party/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet"
      type="text/css"/>
<!--end::Page Vendors Styles-->
<style>
    .swal2-icon.swal2-question {
        border-color: #ee9d01;
        color: #ee9d01;
    }
</style>
<div class="card card-custom">
    <div class="card-header">
        <div class="card-title" id="modul_title">
            <h3 class="card-label"><?php echo $_smarty_tpl->tpl_vars['modul_title']->value;?>

                <div class="text-muted pt-2 font-size-sm"><?php echo $_smarty_tpl->tpl_vars['modul_desc']->value;?>
</div>
            </h3>
        </div>
        <div class="card-toolbar" id="tool_button">
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
                            <div class="row mb-4">
                                <div class="col-4">Job Name</div>
                                <div class="col-8 row">:&nbsp;<div id="v_job_name"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">Job Grade</div>
                                <div class="col-8 row">:&nbsp;<div id="v_job_grade"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">Job Family</div>
                                <div class="col-8 row">:&nbsp;<div id="v_job_jf"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">Sub Job Family</div>
                                <div class="col-8 row">:&nbsp;<div id="v_job_sjf"></div>
                                </div>
                            </div>
                            <!--<div class="row mb-4">
                                <div class="col-4">Klasifikasi</div>
                                <div class="col-8 row">:&nbsp;<div id="v_klasifikasi"></div></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">Type</div>
                                <div class="col-8 row">:&nbsp;<div id="v_type"></div></div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-4">Organization Risk</div>
                                <div class="col-8 row">:&nbsp;<div id="v_orgrisk"></div></div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col text-center mt-5">
            <button class="btn btn-light-primary font-weight-bold" id="backButton" name="backButton" type="button">
                Back
            </button>
        </div>
    </div>

    <div class="card-body">
        <div id="data_crud" style="display: none">
            <div id="form_crud">
                <form class="from" id="kt_form_crud">
                    <input class="form-control" id="form_method" name="form_method" type="hidden">
                    <input class="form-control" id="job_id" name="job_id" type="hidden">
                    <div id="form_field">
                        <div class="card-body py-3">
                            <div class="col-lg-8 row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Job Name</label>
                                        <div class="col-lg-12">
                                            <input class="form-control" id="job_name" name="job_name"
                                                   placeholder="Add Job Name" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Job Grade</label>
                                        <div class="col-lg-12">
                                            <select class="form-control" id="job_grade" name="job_grade">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 row" id="job_sjf_input">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Job Family</label>
                                        <div class="col-lg-12">
                                            <input class="form-control" disabled id="job_jf"
                                                   name="job_jf" placeholder="Add Job Family" type="text"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Sub Job Family</label>
                                        <div class="col-lg-12">
                                            <select class="form-control" id="job_sjf" name="job_sjf"
                                                    onchange="getSkill('job_sjf', 'job_jf')">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-lg-7 row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Klasifikasi</label>
                                        <div class="col-lg-12">
                                            <select class="form-control" id="klasifikasi" name="klasifikasi">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Type</label>
                                        <div class="col-lg-12">
                                            <select class="form-control" id="type" name="type">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-form-label text-left col-lg-12">Organizational Risk</label>
                                        <div class="col-lg-12">
                                            <select class="form-control" id="orgrisk" name="orgrisk">

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="card-body py-3">
                        <div class="col-lg-12 row">
                            <div id="action_button">
                                <div class="row">
                                    <div class="col-lg-12 ml-lg-auto">
                                        <button class="btn btn-primary font-weight-bold mr-2" id="submitButton"
                                                name="submitButton" type="submit">Save
                                        </button>
                                        <button class="btn btn-danger font-weight-bold mr-2" id="deleteButton"
                                                name="deleteButton" type="submit">Delete
                                        </button>
                                        <button class="btn btn-light-primary font-weight-bold mr-2" id="cancelButton"
                                                name="cancelButton" type="reset">Cancel
                                        </button>
                                    </div>
                                </div>
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
                    <div class="col-lg-12 mb-lg-0 mb-12">
                        <label>Search:</label>
                        <input class="form-control datatable-input" id="find_data" name="find_data" placeholder=""
                               type="text"/>
                        <span class="form-text text-muted">Input character to search</span>
                    </div>
                    <div class="col-lg-3  mb-lg-0 mb-6">
                        <label>Job Family :</label>
                        <select class="form-control" id="find_job_family">
                        </select>
                        <span class="form-text text-muted">Select Job Family</span>
                    </div>
                    <!--<div class="col-lg-3  mb-lg-0 mb-6">
                        <label>Organizational Risk :</label>
                            <select class="form-control" id="find_org_risk">
                                <option value="">All</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                  <span class="form-text text-muted">Select organizational risk</span>
                    </div> -->
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
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable"
                   style="margin-top: 13px !important">
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
