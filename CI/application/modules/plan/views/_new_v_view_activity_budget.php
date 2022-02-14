<section class="panel panel-faster">
	<div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
          	<li role="presentation" id="view2" class="active">
          		<a href="<?php echo site_url('plan/activity-budget')?>" >
          			<i class="icon-magnifier-add"></i>
          			Unprocessed
          		</a>
      		</li>
          <li role="presentation">
          		<a href="<?php echo site_url('plan/activity-budget-processed')?>" >
          			<i class="icon-magnifier-add"></i>
          			Processed
          		</a>
      		</li>         		
          <li role="presentation">
              <a href="<?php echo site_url('plan/activity-budget-submited')?>">
                  <i class="icon-list"></i>
                  Submited
              </a>
          </li>     
          <li role="presentation">        	
              <a href="<?php echo site_url('plan/activity-budget-approved')?>">
                  <i class="icon-list"></i>
                  Approved
              </a>
          </li>  
          <li role="presentation">
              <a href="<?php echo site_url('plan/activity-budget-rejected')?>">
                  <i class="icon-list"></i>
                  Rejected
              </a>
          </li>                       		
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-striped table-form " id="table-view-activity-unprocess" 
            	data-url='Plan/Input_activity/activity_budget_unprocessed' style='width:100% !important;''>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width='165px'>TOR Number</th>
                        <th>Project</th>
                        <th>Charge Code(s)</th>
                        <th>TOR<br />Description</th>
                        <th>Submited by</th>
                        <th>TOR Approved Date</th>
                        <th>Total Budget Estimated</th>
                    </tr>
                </thead>
              <tbody>
                
              </tbody>
            </table>
        </div>
    </div>
</section>