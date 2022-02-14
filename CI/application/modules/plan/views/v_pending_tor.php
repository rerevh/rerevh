<section class="panel panel-faster">
    <div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
        <li role="presentation" id="view2">
                <a href="<?php echo site_url('plan/monthly-activity')?>">
                    Unprocessed
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation" class="active">
                <a href="<?php echo site_url('plan/monthly-activity-pending-tor')?>">
                    Waiting for TOR approval
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="<?php echo site_url('Plan/Monthly_activity_new/pending_finance')?>">
                    Waiting for PR request
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation" class="">
                <a href="<?php echo site_url('Plan/Monthly_activity_new/pending_finance_approve')?>">
                    Waiting for finance approval
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation">
                <a href="<?php echo site_url('Plan/Monthly_activity_new/implemented')?>">
                    Implemented
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation">
                <a href="<?php echo site_url('plan/monthly-activity/postponed')?>">
                    Postponed
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation">
                <a href="<?php echo site_url('plan/monthly-activity/rejected')?>">
                    Rejected
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation">
                <a href="<?php echo site_url('plan/monthly-activity/canceled')?>">
                    Canceled
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-striped table-form " id="pending_tor"
                data-url='plan/monthly-activity-pending-tor'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width='165px'>TOR Number</th>
                        <th>Project</th>
                        <th>Charge Code(s)</th>
                        <th>TOR<br />Description</th>
                        <th>Key Activities</th>
                        <th>Budget Estimation</th>
                        <th>Requester</th>
                        <th>Request Date</th>
                        <th>Request To</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>