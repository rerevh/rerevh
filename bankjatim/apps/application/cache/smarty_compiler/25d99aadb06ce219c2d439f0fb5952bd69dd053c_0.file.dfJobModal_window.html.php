<?php
/* Smarty version 3.1.33, created on 2022-01-29 22:31:49
  from 'D:\web\root\FED\bankjatim\apps\application\views\dfJobModal_window.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f55de507f325_99569079',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '25d99aadb06ce219c2d439f0fb5952bd69dd053c' => 
    array (
      0 => 'D:\\web\\root\\FED\\bankjatim\\apps\\application\\views\\dfJobModal_window.html',
      1 => 1641836142,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61f55de507f325_99569079 (Smarty_Internal_Template $_smarty_tpl) {
?><!--begin::Modal-->
<div class="modal fade" id="modalJobDetil" tabindex="-1" role="dialog" aria-labelledby="modalJobDetil" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Details Job Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="form_view" style="display:block">
                    <div class="col-12">
                        <table cellpadding=3 width=100<?php echo '%>';?>
                            <tr valign=top>
                                <td width=30<?php echo '%>';?>Job Name</td>
                                <td width=2<?php echo '%>';?>:</td>
                                <td>
                                    <div id="vj_job_name"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>Job Grade</td>
                                <td>:</td>
                                <td>
                                    <div id="vj_job_grade"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>Job Family</td>
                                <td>:</td>
                                <td>
                                    <div id="vj_job_jf"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>Sub Job Family</td>
                                <td>:</td>
                                <td>
                                    <div id="vj_job_sjf"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>Job Unit</td>
                                <td>:</td>
                                <td>
                                    <div id="vj_job_unit"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>sub Divisi</td>
                                <td>:</td>
                                <td>
                                    <div id="vj_subdiv"></div>
                                </td>
                            </tr>
                            <tr valign=top>
                                <td>Section</td>
                                <td>:</td>
                                <td>
                                    <div id="vj_section"></div>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal--> <?php }
}
