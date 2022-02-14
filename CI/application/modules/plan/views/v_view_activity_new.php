<section class="panel panel-faster">
  <div>
    <ul class="nav nav-tabs nav-faster" role="tablist">
        <li role="presentation" id="view1" >
          <a href="<?php echo isset($kode_kegiatan) ? '' : site_url('plan/input-activity/') ?>">
            <?php echo isset($kode_kegiatan) ? '<i class="icon-note"></i> Update Activity' : '<i class="icon-note"></i> Form Input Activity' ?>
          </a>
        </li>
        <li role="presentation" id="view2" class="active">
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
      <div class="tab-content">
          <table class="table table-bordered table-striped table-form " id="table-view-activity" data-url='plan/input-activity/view-data-activity'>
            <thead>
              <tr>
                <th>No.</th>
                <th>Code Activity</th>
                <th>Activity</th>
                <th>Year</th>
                <th>Month</th>
                <th>Status</th>
                <th>Budget Estimaton</th>
                <th>Manage<br/>Favorite</th>
                <th width='70'>Option</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
      </div>
  </div>
</section>