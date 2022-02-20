<section class="panel panel-faster">
	<div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
          	<li role="presentation" id="view2" class="">
          		<a href="<?php echo site_url('plan/monthly-activity')?>" >
          			<i class="icon-list"></i>
          			Unprocessed
          		</a>
      		</li>
            <li role="presentation" class="active">
          		<a href="<?php echo site_url('plan/monthly-activity-implemented')?>" >
          			<i class="icon-check"></i>
          			Implemented
          		</a>
      		</li>
            <li role="presentation" class="">
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
            <table class="table table-bordered table-striped table-form " id="table-monthly-implemented" data-url='plan/monthly-activity-implemented'>
              <thead>
                <tr>
                    <th>No.</th>
                    <th width='250'>Implemented Activity Info</th>
                    <th>Mini Proposal</th>
                    <th>Activity Budget</th>
                    <th>Direct Fund</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>
                
              </tbody>
            </table>
        </div>
    </div>
</section>