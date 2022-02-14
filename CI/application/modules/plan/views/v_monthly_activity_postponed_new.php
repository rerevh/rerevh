<section class="panel panel-faster">
    <div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
            <li role="presentation" id="view2">
                <a href="<?php echo site_url('plan/monthly-activity')?>">
                    Unprocessed
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation">
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
            <li role="presentation" class="">
                <a href="<?php echo site_url('plan/monthly-activity/implemented')?>">
                    Implemented
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation" class="active">
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
            <li role="presentation" class="">
                <a href="<?php echo site_url('plan/monthly-activity/canceled')?>">
                    Canceled
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-striped table-form " id="table-postponed"
                data-url='plan/monthly-activity/postponed'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Code Activity</th>
                        <th>Charge Code(s)</th>
                        <th>Location</th>
                        <th>Activity</th>
                        <th>Key Activities</th>
                        <th>Month/Year</th>
                        <th>Postponed to month</th>
                        <th>Create<br />By</th>
                        <th>Budget Estimaton</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    document.onreadystatechange = function () {
        if (document.readyState == 'complete') {
         var table = new getDataTable(null,"table-postponed");     
        }
    }
</script>