<section class="panel panel-faster">
	<div>
		<ul class="nav nav-tabs nav-faster" role="tablist">
			<li role="presentation" id="view1" class="active">
				<a href="<?php echo isset($kode_kegiatan) ? '' : site_url('plan/input-activity/') ?>">
					<?php echo isset($kode_kegiatan) ? '<i class="icon-note"></i> Update Activity' : '<i class="icon-note"></i> Form Input Activity' ?>
				</a>
			</li>
			<li role="presentation" id="view2">
				<a href="<?php echo site_url('plan/input-activity/view-data-activity') ?>">
					<i class="icon-list"></i>
					Data Activity
				</a>
			</li>
			<li role="presentation" id="view2">
				<a href="<?php echo site_url('plan/input-activity/view-data-favorite') ?>">
					<i class="fa fa-star"></i>
					Favorite Activities
				</a>
			</li>
		</ul>
		<?php
		if (isset($kode_kegiatan)) { ?>
			<div class="tab-actions tab-actions-faster">
				<a href="<?php echo site_url('plan/input-activity') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add New Activity</a>
			</div>
		<?php } ?>
	</div>
	<div class="tab-content">
		<div class="row">
			<div class="col-sm-12">
				<form class="form-horizontal" method="POST" action="<?php echo site_url('plan/input-activity/saving') ?>" id="form-input-activity">
				<input type="hidden" name="IdEdit" id="IdEdit" value="<?php echo isset($kode_kegiatan) ? get_url_encode($kode_kegiatan) : '' ?>">
				<div class="col-md-12">
					<?php
					if (isset($kode_kegiatan)) {
						?>
						<input type="hidden" name='code_act' id="code_act" value="<?php echo isset($kode_kegiatan) ? $kode_kegiatan : '' ?>">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Code Activity</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="code_activity" name="code_activity" value="<?php echo isset($kode_kegiatan) ? $kode_kegiatan : '' ?>" disabled>
							</div>
						</div>
						<?php
					}
					?>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Select Location</label>
						<div class="col-sm-9">
							<select class="form-control" id="project_location" name="project_location">
								<option value="">Select Location</option>
								<?php select_location(isset($kode_kegiatan) ? $project_location : $this->session->userdata('loca_id')); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Select Project</label>
						<div class="col-sm-9">
							<select class="form-control select2" id="id_project" name="id_project">
								<option value="">Select Project</option>
								<?php foreach ($projects as $project) : ?>
									<option 
									<?php 
									if (@$id_project == $project->project_id) {
										echo 'selected';
									} else if ($this->session->userdata('project_id') == $project->project_id) {
										echo 'selected';
									} 
									?> value="<?= $project->project_id ?>"><?= $project->project_name ?></option>
								<?php endforeach; ?>

							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Select Source Fund</label>
						<div class="col-sm-9">
							<select class="form-control select2" id="fund_id" name="fund_id">
								<option value="">Select Source Fund</option>
								<?php foreach (source_fund(isset($id_project) ? $id_project : 0) as $fund) : ?>
									<option 
									<?php 
									$auto_select='';
									if($this->session->userdata('project_id') == '8'){
										$auto_select='7';
									} else if($this->session->userdata('project_id') == '1'){
										$auto_select='2';
									}
									echo $fund_id == $fund->fund_id || $auto_select == $fund->fund_id ? 'selected':'';
									?> value="<?= $fund->fund_id ?>"><?= $fund->source_fund ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Select Group/Team</label>
						<div class="col-sm-9">
							<select class="form-control" id="group_id" name="group_id" data-url='Plan/Input_activity/getDeliveribleByGroup'>
								<option value="">Group / Team</option>
								<?php
								foreach ($group as $g) {
									# code...
									echo "<option value='" . $g['id_group'] . "'";
									if (isset($kode_kegiatan)) {
										if($id_group == $g['id_group']){
											echo 'selected';
											$this->id_group=$g['id_group'];
										}
									}else{
										if($this->session->userdata('unit_id') == $g['mapping_id_units']){
											echo 'selected';
											$this->id_group=$g['id_group'];
										}
									}
									echo ">" . $g['name_group'] . "</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group"> 
						<label for="inputEmail3" class="col-sm-3 control-label">Deliverables</label>
						<div class="col-sm-9">
							<select class="form-control select2" id="deliverables" name="deliverables">
								<option value="">Select Deliverables</option>
								<?php
									foreach ($this->m_plan->getDeliverableByGroup($this->id_group)->result_array() as $dv) {
										# code...
										echo "<option value='" . $dv['id'] . "'";
										echo $dv['id'] == @$deliverables ? 'selected' : '';
										echo ">" . $dv['val'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Activity</label>
						<div class="col-sm-9">
							<input type="text"  placeholder='Write description activity...' class="form-control" id="activity" name="activity" value="<?php echo isset($kode_kegiatan) ? $activity : '' ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Year</label>
						<div class="col-sm-9">
							<select class="form-control" id="year" name="year">
								<option value="">Select Year</option>
								<?php
								$prev = date("Y") - 2;
								for ($i = date("Y") + 4; $i >= $prev; $i--) {
									echo '<option value="' . $i . '"';
									if (isset($year) and $year == $i) {
										echo "selected";
									} elseif (date("Y") == $i) {
										echo "selected";
									}
									echo '>' . $i . '</option>';
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Month</label>
						<div class="col-sm-9">
							<select class="form-control" id="month" name="month">
								<option value="">Select Month</option>
								<?php
								for ($i = 1; $i <= 12; $i++) {
									echo '<option value="' . $i . '"';
									if (isset($month) and $month == $i) {
										echo "selected";
									} elseif (date("m") == $i) {
										echo "selected";
									}
									echo '>' . select_month($i) . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Level Of TA</label>
						<div class="col-sm-9">
							<select class="form-control" id="level_of_ta" name="level_of_ta">
								<option value="">Select Level Of TA</option>
								<?php
									foreach ($level_ta as $l_ta) {
										# code...
										echo "<option value='" . $l_ta['id_data'] . "'";
										echo $l_ta['id_data'] == @$level_of_ta ? 'selected' : '';
										echo ">" . $l_ta['level_of_ta'] . "</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Budget Estimation</label>
						<div class="col-sm-9">
							<input type="text" placeholder='Ex : 25.000.000,00' class="form-control updatePrice" id="budget_es" name="budget_es" value="<?php if (@$budget_estimaton) {
								echo number_format(@$budget_estimaton, 2, ',', '.');
							} ?>" onkeyup="updatePrice(this)">
							
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Add To Favorite</label>
						<div class="col-sm-2" style='padding-top: 8px;'>
							<div class="radio-custom radio-success">
								<input type="radio"  name="add_to_favorite" value='1' <?= @$isFavorite!='' && @$isFavorite=='1' ? 'checked':'';?>>
								<label>Yes, add to favorites</label>
							</div>
						</div>
						<div class="col-sm-2" style='padding-top: 8px;'>
							<div class="radio-custom radio-danger">
								<input type="radio"  name="add_to_favorite" value='0' <?= @$isFavorite!='' && @$isFavorite=='1' ? '':'checked';?>>
								<label >No, don't add to favorites</label>
							</div>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<button type="submit" class="btn btn-success"><span class='glyphicon glyphicon-floppy-saved'></span>
								<?php echo isset($kode_kegiatan) ? 'Update Activity' : 'Save Activity' ?>
							</button>
							<a href="<?php echo site_url('plan/intake/dashboard') ?>" class="btn btn-danger"><i class='icon-close'></i>
								<?php echo isset($kode_kegiatan) ? 'Cancel Update' : 'Cancel Save' ?>
							</a>
						</div>
					</div>
			    </div>
			</form>
		</div>
	</div>
</section>