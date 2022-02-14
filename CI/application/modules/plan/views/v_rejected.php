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
            <li role="presentation">
                <a href="<?php echo site_url('plan/monthly-activity/postponed')?>">
                    Postponed
                    <span class='badge badge-ontabs'>-</span>
                </a>
            </li>
            <li role="presentation" class="active">
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
            <table class="table table-bordered table-striped table-form " id="rejected"
                data-url='plan/monthly-activity/rejected'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th width='165px'>TOR Number</th>
                        <th>Project</th>
                        <th>Charge Code(s)</th>
                        <th>TOT<br />Description</th>
                        <th>Rejected Reason</th>
                        <th>Budget Estimation</th>
                        <th>Requester</th>
                        <th>Request Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="wizard" id="edit_tor" data-title="Request TOR">
    <div class="wizard-card" data-cardname="card1">
        <h3>Proposal Background</h3>
        <textarea name="background" id="background" class='editor background'></textarea>
    </div>

    <div class="wizard-card" data-cardname="card2">
        <h3>4W (What, Where, Who & When)</h3>
        <div class='alert alert-warning'>
            Please complete to filling out <b>What</b>, <b>Where</b>, <b>Who</b>, <b>When</b> because those information
            will be appeared in supervisor email for review prior to approve.
        </div>
        <div class='col-sm-12'>
            <div class="form-group">
                <label for="">What</label>
                <textarea name="what" id="what" cols="30" rows="3" class='form-control'
                    placeholder='Type what you want to do...'></textarea>
            </div>
            <div class="form-group">
                <label for="">Where</label>
                <textarea name="where" id="where" cols="30" rows="3" class='form-control'
                    placeholder='Type where you want to do...'></textarea>
            </div>
            <div class="form-group">
                <label for="">Who</label>
                <textarea name="who" id="who" cols="30" rows="3" class='form-control'
                    placeholder='Type who is related...'></textarea>
            </div>
            <div class="form-group">
                <label for="">When</label>
                <div class="input-daterange input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" class="form-control" name="date_from" id='date_from' data-plugin-datepicker
                        data-plugin-options='{"format": "dd-mm-yyyy"}'>
                    <span class="input-group-addon">to</span>
                    <input type="text" class="form-control" name="date_to" id='date_to' data-plugin-datepicker
                        data-plugin-options='{"format": "dd-mm-yyyy"}'>
                </div>
            </div>
        </div>
    </div>
    <div class="wizard-card" data-cardname="card3">
        <h3>How and or Justification</h3>
        <textarea class='editor justification' id='justification' name='justification'></textarea>
    </div>
    <div class="wizard-card" data-cardname="card4">
        <h3>Program Assistance</h3>
        <div class='row'>
            <div class="col-sm-12 data_pa">
                <div class='alert alert-warning'>
                    Select program assistance to help this activity<br />
                    The program assistance will receive a notification email after the TOR is approved.
                </div>
                <?php 
            $unit=$this->session->unit_id;
            foreach ($operations as $pa) {
                # code...
                $isPaSelected='';
                $cek = $this->db->get_where('tb_units_pa',[
                    'id_pa_users'=>$pa->id,
                    'id_units'=>$unit
                ]);
                if($cek->num_rows() > 0){
                    $isPaSelected='checked';
                }
                echo "<span  class='form-control mb-2'><input type='checkbox' name='pa[]'   value='".$pa->id."' ".$isPaSelected."> ".$pa->username.' <a href="mailto:'.$pa->email.'" target="_blank" class="label label-warning">'.$pa->email.'</a></span>';
            }
            ?>
            </div>
        </div>
    </div>

    <div class="wizard-card" data-cardname="card4">
        <h3>Supporting Document</h3>
        <div class="col-sm-12">
            <div class="form-group">
                <label for="" class="">Upload Supporting Document (If any/required)</label>
                <input type="file" class="form-control" name="supporting_document" id="supporting_document" />
                <p class="text-danger" style="font-style: italic">pdf, png, jpg, docx, excel</p>
            </div>
        </div>

        <div class="wizard-card" data-cardname="card4">
            <h3>Submit Request</h3>
            <div class="card select_manager" title='Click to select manager receiver'
                manager_email='fadelalfayed27@gmail.com'>
                <div class="additional">
                    <div class="user-card">
                        <img src="<?=site_url('images/avatars/no-img.jpg')?>" alt="">
                    </div>
                    <div class="more-info">
                        <h1>Fadel Al Fayed</h1>
                        <div class="coords">
                            <span>Email : fadelalfayed27@gmail.com</span>
                        </div>
                    </div>
                    <div class='selected'>
                        <i class='icon-check'></i>
                    </div>
                </div>
                <div class="general">
                    <h1>Fadel</h1>
                    <div class="coords">
                        <span>Email : fadelalfayed27@gmail.com</span>
                    </div>
                </div>
            </div>
            <?php 
        foreach($manajer as $mn){
        ?>
            <div class="card select_manager" title='Click to select manager receiver'
                manager_email='<?= $mn['email'];?>'>
                <div class="additional">
                    <div class="user-card">
                        <img src="<?= $mn['email'] =='CFrancis@fhi360.org' ? site_url('images/avatars/cf.jpeg'):site_url('images/avatars/no-img.jpg')?>"
                            alt="">
                    </div>
                    <div class="more-info">
                        <h1><?= $mn['username']?></h1>
                        <div class="coords">
                            <span>Email : <?= $mn['email']?></span>
                        </div>
                    </div>
                    <div class='selected'>
                        <i class='icon-check'></i>
                    </div>
                </div>
                <div class="general">
                    <h1><?= $mn['username']?></h1>
                    <div class="coords">
                        <span>Email : <?= $mn['email']?></span>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </div>
    </div>

    <script>
        document.onreadystatechange = function () {
            if (document.readyState == 'complete') {
                var table = new getDataTable(null, "rejected");
                let df_code
                let tor_number
                $('#rejected tbody').on('click', 'span.korelasi', function (e) {
                    e.preventDefault();
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    var tor_number = $(this).attr('tor_number');
                    var el = $(this);
                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                        tr.removeClass('selected');
                        el.find("span.long_display").html('<i class="fa fa-chevron-right"></i> ' +
                            tor_number)
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

                $(document).on('click', '.btn-delete', function (e) {
                    e.preventDefault();
                    const id = $(this).attr('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value === true) {
                            $.post(site_url + 'plan/delete-rejected', {
                                id: id
                            }, function (response) {
                                if (response.status === true) {
                                    table.draw()
                                    Swal.fire('Deleted!', response.message, 'success')
                                } else {
                                    App.notify(response.message, 'error');
                                }
                            }, 'JSON');
                        }
                    })
                });

                $(document).on('click', '.btn-edit', function (e) {
                    e.preventDefault();
                    let code = $(this).attr('data-id');
                    df_code = code
                    $.post(site_url + 'plan/detail-tor', {
                        code: code
                    }, function (res) {
                        tor_number = res.tor_number
                        $(".background").summernote("code", res.background);
                        $(".justification").summernote("code", res.justification);
                        $("#what").val(res.what);
                        $("#where").val(res.where);
                        $("#who").val(res.who);
                        $("#date_from").val(res.date_start);
                        $("#date_to").val(res.date_end);
                    }, 'JSON');
                    wizard.show();
                });

                var manager_email = '';
                $.fn.wizard.logging = true;
                var options = {
                    contentHeight: 0.70 * screen.height,
                    contentWidth: 0.85 * screen.width,
                    backdrop: 'static',
                    keyboard: false,
                };

                var wizard = $("#edit_tor").wizard(options);
                var charge_code = '';
                var deliverables = '';

                $('#background').summernote({
                    height: 0.45 * screen.height,
                    placeholder: 'Type or paste your Mini Proposal (TOR) Background here...'
                });
                $('#justification').summernote({
                    height: 0.45 * screen.height,
                    placeholder: 'Type how and or justification here...'
                });
                $(".select_manager").click(function () {
                    $('.select_manager').removeClass('active');
                    $(this).addClass('active')
                    manager_email = $(this).attr('manager_email')
                })

                wizard.on("submit", function (wizard) {
                    console.log('submit')
                    let background = $("#background").val();
                    let what = $("#what").val();
                    let where = $("#where").val();
                    let who = $("#who").val();
                    let when_start = $("#date_from").val();
                    let when_end = $("#date_to").val();
                    var formData = new FormData();
                    var supporting_document = document.getElementById('supporting_document');
                    formData.append('supporting_document', supporting_document.files[0]);
                    let justification = $("#justification").val();
                    program_assistance_array = [];
                    let el_pa = document.getElementsByName('pa[]');
                    for (var i = 0; i < el_pa.length; i++) {
                        if (el_pa[i].checked == true) {
                            program_assistance_array.push(el_pa[i].value)
                        }
                    }
                    formData.append('program_assistance', program_assistance_array);
                    formData.append('background', background);
                    formData.append('what', what);
                    formData.append('where', where);
                    formData.append('who', who);
                    formData.append('when', when_start);
                    formData.append('when_end', when_end);
                    formData.append('justification', justification);
                    formData.append('email', manager_email);
                    formData.append('df_code', df_code);
                    formData.append('tor_number', tor_number);
                    $.ajax({
                        type: 'post',
                        url: site_url + 'request/resubmit-rejected-request',
                        dataType: 'json',
                        data: formData,
                        contentType: false,
                        processData: false,
                        error: function () {
                            notifikasi('Fail connecting to server !', 0)
                        },
                        success: function (res) {
                            callback.call(this, res)
                        }
                    })


                    callback = function (res) {
                        if (res.success) {
                            swalboot({
                                title: 'Successfully !',
                                text: res.notif,
                                type: 'success'
                            }).then((result) => {
                                window.location.href = base_url +
                                    'plan/monthly-activity/rejected'
                            })
                        } else {
                            swalboot("Failed !", res.notif, 'error');
                            wizard.submitFailure();
                            wizard.reset();
                            wizard.setCard(5)
                        }
                    }
                });



            }
        }
    </script>