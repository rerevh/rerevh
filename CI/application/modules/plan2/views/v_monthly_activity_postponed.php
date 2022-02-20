<section class="panel panel-faster">
	<div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
          	<li role="presentation" id="view2">
          		<a href="<?php echo site_url('plan/monthly-activity')?>" >
          			<i class="icon-list"></i>
          			Unprocessed
          		</a>
      		</li>
            <li role="presentation" class="">
          		<a href="<?php echo site_url('plan/monthly-activity-implemented')?>" >
          			<i class="icon-check"></i>
          			Implemented
          		</a>
      		</li>
            <li role="presentation" class="active">
          		<a href="<?php echo site_url('plan/monthly-activity-postponed')?>" >
          			<i class="icon-calendar"></i>
          			Postponed
          		</a>
      		</li>
            <li role="presentation" class="">
          		<a href="<?php echo site_url('plan/monthly-activity-canceled')?>" >
          			<i class="icon-close"></i>
          			Canceled
          		</a>
      		</li>
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-striped table-form " id="table-view-alllist" data-url='Plan/Monthly_activity_postponed'>
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Code Activity</th>
                  <th>Deliverables</th>
                  <th>Activity</th>
                  <th>Year</th>
                  <th>Month</th>
                  <th>Month Postpone</th>
                  <th>Budget Estimaton</th>
                  <th>Budget<br/>Status</th>
                  <th>Action </th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </div>
    </div>
</section>
<div class="modal" tabindex="-1" role="dialog" id='modal-proses'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header panel-heading-modal-faster">
        <h4 class="modal-title modal-title-alert"><i class="icon-note"></i> Set Status Update Monthly</h4>
      </div>
      <div class="modal-body">
        <form class='form-horizontal' action='<?php echo site_url('plan/monthly-activity/update')?>'>
          <input type="hidden" name="key" id="key">
          <div class='form-group'>
            <label class='control-label col-sm-2'>Status</label>
            <div class='col-sm-10'>
              <select class='form-control status' name='status' id='status'>
                <option value=''>Choise</option>
                <option value='1'>Implement</option>
                <option value="2">Postpone</option>
                <option value="3">Cancel</option>
              </select>
            </div>
          </div>
          <div class='form-group reason hidden'>
            <label class='control-label col-sm-2'>Reason</label>
            <div class='col-sm-10'>
              <textarea class='form-control' rows='4' placeholder='Type reason here...' name='reason' id='reason'></textarea>
            </div>
          </div>
          <div class="form-group month hidden">
            <label for="" class="control-label col-sm-2">Month</label>
            <div class="col-sm-10">
              <select class="form-control" id="month" name="month">
			          <option value="" >Select Month</option>
                <?php 
                  for($i=1;$i<=12;$i++)
                  {
                    echo '<option value="'.$i.'"';
                    if(isset($month) AND $month==$i){
                      echo "selected";
                    }
                    echo '>'.select_month($i).'</option>';
                  }
                ?>
			        </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-faster" id='btn-save'>Save</button>
        <button type="button" class="btn btn-faster-danger" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>