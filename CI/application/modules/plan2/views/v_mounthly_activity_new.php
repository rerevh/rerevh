<section class="panel panel-faster">
    <div>
        <ul class="nav nav-tabs nav-faster" role="tablist">
        <li role="presentation" id="view2" class="active">
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
            <table class="table table-bordered table-striped table-form " id="table-view-alllist"
                data-url='plan/monthly-activity'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th><input type="checkbox" name="check_all" id="check_all"></th>
                        <th>Add To</br>Favorite</th>
                        <th>Code Activity</th>
                        <th>Charge Code(s)</th>
                        <th>Location</th>
                        <th>Activity</th>
                        <th>Key Activities</th>
                        <th>Month/Year</th>
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
                                <option value="2">Postpone</option>
                                <option value="3">Cancel</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group reason hidden'>
                        <label class='control-label col-sm-2'>Reason</label>
                        <div class='col-sm-10'>
                            <textarea class='form-control' rows='4' placeholder='Type reason here...' name='reason'
                                id='reason'></textarea>
                        </div>
                    </div>
                    <div class="form-group month hidden">
                        <label for="" class="control-label col-sm-2">Month</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="month" name="month">
                                <option value="">Select Month</option>
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


<div class="wizard" id="request_tor" data-title="Request TOR">
    <div class="wizard-card" data-cardname="card1">
        <h3>Proposal Background</h3>
        <textarea name="background" id="background" class='editor'></textarea>
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
        <textarea class='editor' id='justification' name='justification'></textarea>
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