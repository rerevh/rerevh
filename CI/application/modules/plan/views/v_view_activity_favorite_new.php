<section class="panel panel-faster">
  <div>
    <ul class="nav nav-tabs nav-faster" role="tablist">
        <li role="presentation" id="view1" >
          <a href="<?php echo isset($kode_kegiatan) ? '' : site_url('plan/input-activity/') ?>">
            <?php echo isset($kode_kegiatan) ? '<i class="icon-note"></i> Update Activity' : '<i class="icon-note"></i> Form Input Activity' ?>
          </a>
        </li>
        <li role="presentation" id="view2" >
          <a href="<?php echo site_url('plan/input-activity/view-data-activity') ?>">
            <i class="icon-list"></i>
            Data Activity
          </a>
        </li>
        <li role="presentation" id="view2" class="active">
          <a href="<?php echo site_url('plan/input-activity/view-data-favorite') ?>">
            <i class="fa fa-star"></i>
            Favorite Activities
          </a>
        </li>
      </ul>
      <div class="tab-content">
          <table class="table table-bordered table-striped table-form " id="table-view-activity" data-url='plan/input-activity/view-data-favorite'>
            <thead>
              <tr>
                <th>No.</th>
                <th>Code Activity</th>
                <th>Deliverables</th>
                <th>Activity</th>
                <th>Year</th>
                <th>Month</th>
                <th>Budget Estimaton</th>
                <th width='150px'>Action</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
      </div>
  </div>
</section>


<div class="modal" tabindex="-1" role="dialog" id='modal_implementing_again'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header panel-heading-modal-faster">
                <h4 class="modal-title modal-title-alert"><i class="icon-action-undo"></i> Implementing agaian</h4>
            </div>
            <div class="modal-body">
                <form class='form-horizontal' action='<?php echo site_url('Plan/Input_activity/Impementing_again')?>'>
                <input type="hidden" name="key" id="key">
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Deliveribles</label>
                    <div class='col-sm-10'>
                        <textarea  cols="30" class='form-control' id='deliverables' disabled></textarea>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Activities</label>
                    <div class='col-sm-10'>
                        <textarea cols="30" class='form-control' id='activities' name='activities' ></textarea>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Budget Est</label>
                    <div class='col-sm-10'>
                        <input type="text" disabled id='budget_est' class="form-control">
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Year</label>
                    <div class='col-sm-10'>
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
                <div class='form-group'>
                    <label class='control-label col-sm-2'>Month</label>
                    <div class='col-sm-10'>
                        <select class="form-control" id="month" name="month[]" multiple="multiple">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<option value="' . $i . '"';
                                if ($i >= date("m")) {
                                    echo "selected";
                                }
                                echo '>' . select_month($i) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id='btn-save'><i class='icon-action-undo'></i> Implementing again</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='icon-close'></i> Cancel</button>
            </div>
        </div>
    </div>
</div>