<?php
/* Smarty version 3.1.33, created on 2022-02-02 14:24:31
  from 'D:\web\root\FED\bankjatim\apps\application\views\career\person.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_61fa31afc29055_17016898',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7e019818d891b2f12a5c31459e5bff35d8938d26' => 
    array (
      0 => 'D:\\web\\root\\FED\\bankjatim\\apps\\application\\views\\career\\person.html',
      1 => 1643227251,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./toolsbutton.html' => 1,
  ),
),false)) {
function content_61fa31afc29055_17016898 (Smarty_Internal_Template $_smarty_tpl) {
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
					<table width="100%">
						<thead>
						<tr>
							<th colspan="3">
								<h5 class="m-0 p-0"><img size="" class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/person detail.svg">
									Person Details</h5>
								<hr style="height: 1%;background-color: #000000">
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width="25%">NIP</td>
							<td width="2%">:</td>
							<td width="73%"><div id="v_person_number"></div></td>
						</tr>
						<tr>
							<td>Name</td>
							<td>:</td>
							<td><div id="v_person_name"></div></td>
						</tr>
						<tr>
							<td>Person Grade</td>
							<td>:</td>
							<td><div id="v_person_grade_num"></div></td>
						</tr>
						<tr>
							<td>Person Job Family</td>
							<td>:</td>
							<td><div id="v_person_jf"></div></td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td><div id="v_gender"></div></td>
						</tr>
						<tr>
							<td>Tanggal Lahir</td>
							<td>:</td>
							<td><div id="v_tgl_lahir"></div></td>
						</tr>
						<tr>
							<td>Agama</td>
							<td>:</td>
							<td><div id="v_agama"></div></td>
						</tr>
						<tr>
							<td>Pendidikan</td>
							<td>:</td>
							<td><div id="v_pendidikan"></div></td>
						</tr>
						<tr>
							<td>Tanggal Masuk</td>
							<td>:</td>
							<td><div id="v_tgl_masuk"></div></td>
						</tr>
						<tr>
							<td>Email</td>
							<td>:</td>
							<td><div id="v_email"></div></td>
						</tr>
						<!--<tr>
							<td>Talent Box</td>
							<td>:</td>
							<td><div id="v_talentbox"></div></td>
						</tr>-->
						<tr>
							<td>Performance Year-1</td>
							<td>:</td>
							<td><div id="v_performance_year1"></div></td>
						</tr><tr>
							<td>Performance Year-2</td>
							<td>:</td>
							<td><div id="v_performance_year2"></div></td>
						</tr>
						<tr>
							<td>Performance Level</td>
							<td>:</td>
							<td><div id="v_performance_level"></div></td>
						</tr>
						<tr>
							<td>Assessment</td>
							<td>:</td>
							<td><div id="v_assessment"></div></td>
						</tr>
						<tr>
							<td>Under Supervision</td>
							<td>:</td>
							<td><div id="v_mp"></div></td>
						</tr>
						<tr>
							<td>Top Talent</td>
							<td>:</td>
							<td><div id="v_top_talent"></div></td>
						</tr>
						<tr>
							<td>Notes</td>
							<td>:</td>
							<td><div id="v_notes"></div></td>
						</tr>
						</tbody>
					</table>
				</div>
				<!--<div class="col" style="display: none">
					<div>
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0"><img size="" class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/person detail.svg">
								Person Details</h5>
							<hr style="height: 1%;background-color: #000000">
							<div class="row mb-2">
								<div class="col-4">NIP</div>
								<div class="col-8 row">:&nbsp;<div id="v_person_number"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Name</div>
								<div class="col-8 row">:&nbsp;<div id="v_person_name"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Person Grade</div>
								<div class="col-8 row">:&nbsp;<div id="v_person_grade"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Person Job Family</div>
								<div class="col-8 row">:&nbsp;<div id="v_person_jf"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Jenis Kelamin</div>
								<div class="col-8 row">:&nbsp;<div id="v_gender"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Tanggal Lahir</div>
								<div class="col-8 row">:&nbsp;<div id="v_tgl_lahir"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Agama</div>
								<div class="col-8 row">:&nbsp;<div id="v_agama"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Pendidikan</div>
								<div class="col-8 row">:&nbsp;<div id="v_pendidikan"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Tanggal Masuk</div>
								<div class="col-8 row">:&nbsp;<div id="v_tgl_masuk"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Email</div>
								<div class="col-8 row">:&nbsp;<div id="v_email"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Talent Box</div>
								<div class="col-8 row">:&nbsp;<div id="v_talentbox"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Performance Level</div>
								<div class="col-8 row">:&nbsp;<div id="v_performance_level"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Assessment</div>
								<div class="col-8 row">:&nbsp;<div id="v_assessment"></div></div>
							</div>
						</div>
					</div>
				</div>-->
			</div>
			<div class="col-6">
				<div class="col mb-5">
					<table width="100%">
						<thead>
						<tr>
							<th colspan="3">
								<h5 class="m-0 p-0"><img class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/job families.svg">
									Job Details</h5>
								<hr style="height: 1%;background-color: #000000">
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width="25%">Job</td>
							<td width="2%">:</td>
							<td width="73%"><div id="v_job_name"></div></td>
						</tr>
						<tr>
							<td>Job Family</td>
							<td>:</td>
							<td><div id="v_job_jf"></div></td>
						</tr>
						<tr>
							<td>Job Grade</td>
							<td>:</td>
							<td><div id="v_job_grade"></div></td>
						</tr>
						<!--<tr>
							<td>Penggolongan Jabatan</td>
							<td>:</td>
							<td><div id="v_penggolongan"></div></td>
						</tr>-->
						</tbody>
					</table>
					<!--<div>
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0"><img class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/job families.svg">
								Job Details</h5>
							<hr style="height: 1%;background-color: #000000">
							<div class="row mb-2">
								<div class="col-4">Job</div>
								<div class="col-8 row">:&nbsp;<div id="v_job_name"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Job Family</div>
								<div class="col-8 row">:&nbsp;<div id="v_job_jf"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Job Grade</div>
								<div class="col-8 row">:&nbsp;<div id="v_job_grade"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Penggolongan Jabatan</div>
								<div class="col-8 row">:&nbsp;<div id="v_penggolongan"></div></div>
							</div>
						</div>
					</div>-->
				</div>
				<div class="col">
					<table width="100%">
						<thead>
						<tr>
							<th colspan="3">
								<h5 class="m-0 p-0"><img class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/TMT.svg">
									TMT Grade</h5>
								<hr style="height: 1%;background-color: #000000">
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width="25%">Appointment Date</td>
							<td width="2%">:</td>
							<td width="73%"><div id="v_tmtgrade"></div></td>
						</tr>
						<tr>
							<td>Work Period</td>
							<td>:</td>
							<td><div id="v_masa_kerja"></div></td>
						</tr>
						</tbody>
					</table>
					<!--<div>
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0"><img class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/TMT.svg">
								TMT Grade</h5>
							<hr style="height: 1%;background-color: #000000">
							<div class="row mb-2">
								<div class="col-4">Appointment Date</div>
								<div class="col-8 row">:&nbsp;<div id="v_tmtgrade"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Work Period</div>
								<div class="col-8 row">:&nbsp;<div id="v_masa_kerja"></div></div>
							</div>
						</div>
					</div>-->
				</div>

				<!--<div class="col">
					<div>
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0"><img class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/job families.svg">
								Job Details</h5>
							<hr style="height: 1%;background-color: #000000">
							<div class="row mb-2">
								<div class="col-4">Job</div>
								<div class="col-8 row">:&nbsp;<div id="v_job_name"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Job Family</div>
								<div class="col-8 row">:&nbsp;<div id="v_job_jf"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Job Grade</div>
								<div class="col-8 row">:&nbsp;<div id="v_job_grade"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Penggolongan Jabatan</div>
								<div class="col-8 row">:&nbsp;<div id="v_penggolongan"></div></div>
							</div>
						</div>
					</div>
				</div>-->
				<!--<div class="col">
					<div>
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0"><img class="pggreen mr-2" alt="person detail" src="<?php echo $_smarty_tpl->tpl_vars['host']->value;?>
assets/icons/aspirasi.svg">
								Aspirasi Karir</h5>
							<hr style="height: 1%;background-color: #000000">
							<div class="row mb-5">
								<div class="col-4">Aspirasi Karir</div>
								<div class="col-8 row">:&nbsp;<div id="v_aspirasi"></div></div>
							</div>
							&lt;!&ndash;
							<div class="mb-3">
								<div class="row mb-2">
									<div class="col-4">
										<div class="row">
											<div class="col-6" style="font-weight: bolder">&nbsp;Prioritas 1</div>
											<div class="col-6">Posisi 1</div>
										</div>
									</div>
									<div class="col-8 row">:&nbsp;<div id="v_pos1"></div></div>
								</div>
								<div class="row mb-2">
									<div class="col-4">
										<div class="row">
											<div class="col-6"></div>
											<div class="col-6">Lokasi 1</div>
										</div>
									</div>
									<div class="col-8 row">:&nbsp;<div id="v_loc1"></div></div>
								</div>
							</div>
							<div class="mb-3">
								<div class="row mb-2">
									<div class="col-4">
										<div class="row">
											<div class="col-6" style="font-weight: bolder">&nbsp;Prioritas 2</div>
											<div class="col-6">Posisi 2</div>
										</div>
									</div>
									<div class="col-8 row">:&nbsp;<div id="v_pos2"></div></div>
								</div>
								<div class="row mb-2">
									<div class="col-4">
										<div class="row">
											<div class="col-6"></div>
											<div class="col-6">Lokasi 2</div>
										</div>
									</div>
									<div class="col-8 row">:&nbsp;<div id="v_loc2"></div></div>
								</div>
							</div>
							<div class="mb-5">
								<div class="row mb-2">
									<div class="col-4">
										<div class="row">
											<div class="col-6" style="font-weight: bolder">&nbsp;Prioritas 3</div>
											<div class="col-6">Posisi 3</div>
										</div>
									</div>
									<div class="col-8 row">:&nbsp;<div id="v_pos3"></div></div>
								</div>
								<div class="row mb-2">
									<div class="col-4">
										<div class="row">
											<div class="col-6"></div>
											<div class="col-6">Lokasi 3</div>
										</div>
									</div>
									<div class="col-8 row">:&nbsp;<div id="v_loc3"></div></div>
								</div>
							</div>
							!&ndash;&gt;
							<div class="row mb-2">
								<div class="col-4">Fleksibilitas</div>
								<div class="col-8 row">:&nbsp;<div id="v_flexibility"></div></div>
							</div>
							<div class="row mb-2">
								<div class="col-4">Retention</div>
								<div class="col-8 row">:&nbsp;<div id="v_retention"></div></div>
							</div>
						</div>
					</div>
				</div>-->
			</div>
		</div>
		<div class="col text-center mt-5">
			<button type="button" class="btn btn-light-primary font-weight-bold" id="backButton" name="backButton">Back</button>
		</div>
	</div>

	<div class="card-body">
	<div id="data_crud" style="display:none">
		<div id="form_crud">
			<form class="from" id="kt_form_crud">
				<input class="form-control" id="form_method" name="form_method" type="hidden">
				<input class="form-control" id="person_id" name="person_id" type="hidden">
				<div id="form_field">
					<div style="background-color: #921a1d">
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0" style="color: #FFFFFF">General Information</h5>
						</div>
					</div>
					<div class="card-body py-3">
						<div class="col-12">
							<div class="col-11 row">
								<div class="col-2">
									<div class="form-group">
										<label class="col-form-label text-left col-12">NIP</label>
										<div class="col-12">
											<input class="form-control" id="person_number"
												   maxlength="50" minlength="3" name="person_number"
												   onkeyup="this.value = this.value.toUpperCase()" placeholder="NIK Person" type="text"/>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Name</label>
										<div class="col-12">
											<input class="form-control" id="person_name"
												   maxlength="50" minlength="3" name="person_name"
												   onkeyup="this.value = this.value.toUpperCase()" placeholder="Add Name" type="text"/>
										</div>
									</div>
								</div>
								<div class="col-2">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Person Grade</label>
										<div class="col-12">
											<select class="form-control" id="person_grade" name="person_grade">

											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-10">
								<div class="col-12 row">
									<div class="col-6 p-0 m-0"><label class="col-form-label text-left col-12">Job Family</label></div>
									<div class="col-6 p-0 m-0"><label class="col-form-label text-left col-12">Sub Job Family</label></div>
								</div>
								<div id="kt_repeater_1">
									<div data-repeater-list="">
										<div class="col-12 row mb-2" data-repeater-item="">
											<div class="col-6 p-0 m-0">
												<div class="col-12">
													<input class="form-control person_jf" id="person_jf"
														   maxlength="50" minlength="3" name="person_jf"
														   onkeyup="this.value = this.value.toUpperCase()" placeholder="Add Job Family" type="text" disabled/>
													<!--<select class="form-control person_jf" id="person_jf" name="person_jf">

													</select>-->
												</div>
											</div>
											<div class="col-6 row p-0 m-0">
												<div class="col-10">
													<!--<input class="form-control person_sjf" id="person_sfj"
														   maxlength="50" minlength="3" name="person_sfj"
														   onkeyup="this.value = this.value.toUpperCase()" placeholder="Add Sub Job Family" type="text"/>-->
													<select class="form-control person_sjf" id="person_sjf" name="person_sjf" onchange="getSkill('person_sjf', 'person_jf')">

													</select>
												</div>
												<div class="col-lg-2 removeButton_subskill" style="display: none">
													<a class="btn font-weight-bold btn-danger btn-icon subskill_name_rmbtn"
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
							<div class="col-6">
								<div class="form-group">
									<label class="col-form-label text-left col-12">Gender</label>
									<div class="col-12" id="gender">

									</div>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label class="col-form-label text-left col-12">Tanggal Lahir</label>
									<div class="col-12">
										<input class="form-control" type="date" id="tgl_lahir"/>
									</div>
								</div>
							</div>
							<div class="col-6 row">
								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Agama</label>
										<div class="col-12">
											<select class="form-control" id="agama" name="agama">

											</select>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Pendidikan</label>
										<div class="col-12">
											<select class="form-control" id="pendidikan" name="pendidikan">

											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-3">
								<div class="form-group">
									<label class="col-form-label text-left col-12">Tanggal Masuk</label>
									<div class="col-12">
										<input class="form-control" type="date" id="tgl_masuk"/>
									</div>
								</div>
							</div>
							<div class="col-5">
								<div class="form-group">
									<label class="col-form-label text-left col-12">Email</label>
									<div class="col-12">
										<input class="form-control" id="email" name="email" placeholder="Email Address" type="email"/>
									</div>
								</div>
							</div>
							<div class="col-6 row">
								<!--<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Talent Box</label>
										<div class="col-12">
											<select class="form-control" id="talentbox" name="talentbox">

											</select>
										</div>
									</div>
								</div>-->
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Performance Year-1</label>
										<div class="col-12">
											<input class="form-control" id="performance_year1" name="performance_year1" placeholder="Performance" type="text"/>
											<!--<select class="form-control" id="performance_level" name="performance_level">

											</select>-->
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Performance Year-2</label>
										<div class="col-12">
											<input class="form-control" id="performance_year2" name="performance_year2" placeholder="Performance" type="text"/>
											<!--<select class="form-control" id="performance_level" name="performance_level">

											</select>-->
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Assessment</label>
										<div class="col-12">
											<select class="form-control" id="assessment" name="assessment">

											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="background-color: #921a1d">
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0" style="color: #FFFFFF">Job Input</h5>
						</div>
					</div>
					<div class="card-body py-3">
						<div class="col-12">
							<div class="col-10 row">
								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Job Name</label>
										<div class="col-12">
											<select class="form-control" id="job_id" name="job_id">

											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-10 row">
								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Job Family</label>
										<div class="col-12">
											<input class="form-control" id="job_jf"
												   maxlength="50" minlength="3" name="job_jf"
												   onkeyup="this.value = this.value.toUpperCase()" placeholder="Add Job Family" type="text" disabled/>
										</div>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Sub Job Family</label>
										<div class="col-12">
											<input class="form-control" id="job_sjf"
												   maxlength="50" minlength="3" name="job_sjf"
												   onkeyup="this.value = this.value.toUpperCase()" placeholder="Add Sub Job Family" type="text" disabled/>
										</div>
									</div>
								</div>
							</div>
							<div class="col-10 row">
								<div class="col-2">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Job Grade</label>
										<div class="col-12">
											<input class="form-control" id="job_grade"
												   maxlength="50" minlength="3" name="job_grade" type="text" disabled/>
										</div>
									</div>
								</div>
								<!--<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Penggolongan</label>
										<div class="col-12">
											<select class="form-control" id="penggolongan" name="penggolongan">

											</select>
										</div>
									</div>
								</div>-->
							</div>
						</div>
					</div>
					<div style="background-color: #921a1d">
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0" style="color: #FFFFFF">TMT Grade</h5>
						</div>
					</div>
					<div class="card-body py-3">
						<div class="col-12 row">
							<div class="col-3">
								<div class="form-group">
									<label class="col-form-label text-left col-12">Tanggal Pengangkatan</label>
									<div class="col-12">
										<input class="form-control" type="date" id="tmtgrade"/>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="background-color: #921a1d">
						<div class="card-body py-3 col-12">
							<h5 class="m-0 p-0" style="color: #FFFFFF">More Information</h5>
						</div>
					</div>
					<div class="card-body py-3">
						
						<div class="col-12 row mb-4">
							<div class="col-10 row">
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Under Supervision</label>
										<div class="col-12">
											<select class="form-control" id="mp" name="mp">

											</select>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Top Talent</label>
										<div class="col-12">
											<select class="form-control" id="top_talent" name="top_talent">

											</select>
										</div>
									</div>
								</div>
								
							<div class="col-8">
								<div class="form-group">
									<label class="col-form-label text-left col-12">Notes</label>
									<div class="col-12">
										<input class="form-control" id="notes" name="notes" placeholder="Notes" type="input"/>
									</div>
								</div>
							</div>									
							</div>
						</div>						
					
						
						<!--
						<div class="col-12 row mb-4">
							<div class="col-10 row">
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Aspirasi Karir</label>
										<div class="col-12">
											<select class="form-control" id="aspirasi" name="aspirasi">

											</select>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Flesibilitas</label>
										<div class="col-12">
											<select class="form-control" id="flexibility" name="flexibility">

											</select>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label class="col-form-label text-left col-12">Retention</label>
										<div class="col-12">
											<select class="form-control" id="retention" name="retention">

											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-12">
							<div class="col-12 row">
								<div class="col-4">
									<h5 class="m-0 p-0">Prioritas 1</h5>
									<hr>
									<div class="col-12">
										<div class="form-group row">
											<label class="col-form-label text-left col-3">Posisi 1</label>
											<div class="col-9">
												<input class="form-control" id="pos1" maxlength="50" minlength="3" name="pos1" type="text"/>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group row">
											<label class="col-form-label text-left col-3">Lokasi 1</label>
											<div class="col-9">
												<input class="form-control" id="loc1" maxlength="50" minlength="3" name="loc1" type="text"/>
											</div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<h5 class="m-0 p-0">Prioritas 2</h5>
									<hr>
									<div class="col-12">
										<div class="form-group row">
											<label class="col-form-label text-left col-3">Posisi 2</label>
											<div class="col-9">
												<input class="form-control" id="pos2" maxlength="50" minlength="3" name="pos2" type="text"/>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group row">
											<label class="col-form-label text-left col-3">Lokasi 2</label>
											<div class="col-9">
												<input class="form-control" id="loc2" maxlength="50" minlength="3" name="loc2" type="text"/>
											</div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<h5 class="m-0 p-0">Prioritas 3</h5>
									<hr>
									<div class="col-12">
										<div class="form-group row">
											<label class="col-form-label text-left col-3">Posisi 3</label>
											<div class="col-9">
												<input class="form-control" id="pos3" maxlength="50" minlength="3" name="pos3" type="text"/>
											</div>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group row">
											<label class="col-form-label text-left col-lg-3">Lokasi 3</label>
											<div class="col-lg-9">
												<input class="form-control" id="loc3" maxlength="50" minlength="3" name="loc3" type="text"/>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						!-->
					</div>
				</div>
				<div class="card-body py-3">
					<div class="col-12 row">
						<div id="action_button">
							<div class="row">
								<div class="col-12 ml-auto">
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
  		<!--begin: Search Form-->
  		<div id="data_filter" style="display:none">    		
        <form class="kt-form kt-form--fit mb-15" id="formfilter">
        		<div class="row mb-6">
        			<div class="col-12 mb-0 mb-12">
        				<label>Search:</label>
        				<input type="text" class="form-control datatable-input" placeholder="" id="find_data" name="find_data"/>
        			  <span class="form-text text-muted">Input character to search</span> 
        			</div>
        			
        			<div class="col-lg-3  mb-lg-0 mb-6">
        				<label>Under supervision :</label>
    						<select class="form-control" id="find_mp">
    							<option value="">All</option>
    							<option value="0">No</option>
    							<option value="1">Yes</option>
    						</select>
            	  <span class="form-text text-muted">Select Under supervision</span>    
        			</div>  
        			
        			<div class="col-lg-3  mb-lg-0 mb-6">
        				<label>Assesment :</label>
    						<select class="form-control" id="find_assesment">
    							<option value="">All</option>
    							<option value="1">Low</option>
    							<option value="2">Medium</option>
    							<option value="3">High</option>
    						</select>
            	  <span class="form-text text-muted">Select assesment</span>    
        			</div>          			        			
        		</div>
        		
        		

        		<div class="row mt-8">
        			<div class="col-12">
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
  			              
  	    <table class="table table-striped table-bordered display nowrap table-hover" id="kt_datatable" style="width:100% !important">  
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
