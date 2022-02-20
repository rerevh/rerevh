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
            <li role="presentation" class="active">
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
            <li role="presentation" class="">
                <a href="<?php echo site_url('plan/monthly-activity/canceled')?>">
                    Canceled
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <table class="table table-bordered table-striped table-form " id="table-implemented"
                data-url='plan/monthly-activity/implemented'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width='165px'>TOR Number</th>
                        <th>Project</th>
                        <th>Charge Code(s)</th>
                        <th>TOT<br />Description</th>
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

<script>
    document.onreadystatechange = function () {
        if (document.readyState == 'complete') {
            var table = new getDataTable(null, "table-implemented");
            $('#table-implemented tbody').on('click', 'span.korelasi', function (e) {
                e.preventDefault();
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var tor_number = $(this).attr('tor_number');
                var el = $(this);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    tr.removeClass('selected');
                    el.find("span.long_display").html('<i class="fa fa-chevron-right"></i> ' + tor_number)
                } else {
                    $.ajax({
                        type: "GET",
                        url: base_url + 'Plan/Monthly_activity_new/get_activites_by_tor/' +
                            tor_number,
                        beforeSend: function () {
                            el.find("span.long_display").html(
                                "<i class='fa fa-spin fa-spinner'></i> Loading...")
                        },
                        dataType: 'html',
                        success: function (data) {
                            el.find("span.long_display").html(
                                '<i class="fa fa-chevron-down"></i> ' + tor_number)
                            row.child(data).show('slow');
                            tr.addClass('shown');
                            tr.addClass('selected');
                        }
                    });
                }
            });
        }
    }
</script>