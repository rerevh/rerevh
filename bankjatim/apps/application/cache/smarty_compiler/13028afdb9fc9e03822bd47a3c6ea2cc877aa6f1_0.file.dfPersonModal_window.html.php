<?php
/* Smarty version 3.1.33, created on 2022-01-29 22:31:49
  from 'D:\web\root\FED\bankjatim\apps\application\views\dfPersonModal_window.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61f55de50e4f92_83469055',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '13028afdb9fc9e03822bd47a3c6ea2cc877aa6f1' => 
    array (
      0 => 'D:\\web\\root\\FED\\bankjatim\\apps\\application\\views\\dfPersonModal_window.html',
      1 => 1643227873,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_61f55de50e4f92_83469055 (Smarty_Internal_Template $_smarty_tpl) {
?><!--begin::Modal-->
<div class="modal fade" id="modalPersonDetil" tabindex="-1" role="dialog" aria-labelledby="modalPersonDetil" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
        <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Details Person Information </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
			<div class="modal-body">
				<div id="form_view" style="display: block">
					<div class="row">
						<div class="col-sm">
							<table border="0" cellpadding="3" width="100%">
								<tr>
									<td colspan="3" valign="top">
										<h5 class="m-0 p-0"><img alt="person detail" class="pggreen mr-2" size=""
																 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/person detail.svg">
											Person Details</h5>
										<hr style="height: 1%;background-color: #000000">
									</td>
								</tr>
								<tr>
									<td valign="top" width="25%">NIP</td>
									<td align="center" valign="top" width="2%">:</td>
									<td valign="top">
										<div id="vp_person_number"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Name</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_person_name"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Person Grade</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_person_grade"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Person Job Family</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_person_jf"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Education</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_pendidikan"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Perf. Year-1</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_performance_year1"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Perf. Year-2</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_performance_year2"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Performance Level</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_performance_level"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Assessment</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_assessment"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Under Supervision</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_mp"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Top Talent</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_top_talent"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Notes</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_notes"></div>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" cellpadding="3" width="100%">
								<tr>
									<td colspan="3" valign="top">
										<h5 class="m-0 p-0"><img alt="person detail" class="pggreen mr-2"
																 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/TMT.svg">
											TMT Grade</h5>
										<hr style="height: 1%;background-color: #000000">
									</td>
								</tr>
								<tr>
									<td valign="top" width="25%">Appointment Date</td>
									<td align="center" valign="top" width="2%">:</td>
									<td valign="top">
										<div id="vp_tmtgrade"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Work Period</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_masa_kerja"></div>
									</td>
								</tr>
							</table>
							<br>
							<table border="0" cellpadding="3" width="100%">
								<tr>
									<td colspan="3" valign="top">
										<h5 class="m-0 p-0"><img alt="person detail" class="pggreen mr-2"
																 src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/job families.svg">
											Job Details</h5>
										<hr style="height: 1%;background-color: #000000">
									</td>
								</tr>
								<tr>
									<td valign="top" width="25%">Job</td>
									<td align="center" valign="top" width="2%">:</td>
									<td valign="top">
										<div id="vp_job_name"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Job Family</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_job_jf"></div>
									</td>
								</tr>
								<tr>
									<td valign="top">Job Grade</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_job_grade"></div>
									</td>
								</tr>
								<!--<tr>
									<td valign="top">Penggolongan Jabatan</td>
									<td align="center" valign="top">:</td>
									<td valign="top">
										<div id="vp_penggolongan"></div>
									</td>
								</tr>-->
							</table>							
						</div>

					</div>
				</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
              <!--  <button type="button" class="btn btn-primary font-weight-bold">Action</button> !-->
            </div>
        </div>
    </div>
</div>
<!--end::Modal--> <?php }
}
