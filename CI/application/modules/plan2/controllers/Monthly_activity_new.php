<?php

class Monthly_activity_new extends Backend{

   function __construct(){
      parent::__construct();
      if(!$this->authenty->check_editor()){
			redirect(base_url().'Logout');
      }
      $this->load->model('M_plan','m_plan');
      $this->load->helper('activity');
   }

   function index(){
      if(ajax()==true){
         $this->load->library('datatable');
         $this->datatable->select('a.kode_kegiatan as id,a.kode_kegiatan as id_check,a.kode_kegiatan as id_fav,
         a.kode_kegiatan as kegiatan,
         c.charge_code as source_fund,
         (CONCAT(b.loca_province,IF(b.loca_district != "",CONCAT(" - ",b.loca_district),""))) as location,
         a.activity as actvty,e.deliv,
         a.month as bulan,
         d.username,
         CONCAT("Rp ",FORMAT(a.budget_estimaton,2,"de_DE")) as budget,
         a.isFavorite,a.year as tahun,
         a.deliverables
         ',true);
         $this->datatable->from('tb_detail_monthly as a');
         $this->datatable->join('tb_project_location as b','b.loca_id=a.project_location','LEFT');
         $this->datatable->join('tb_source_fund as c','c.fund_id=a.fund_id','LEFT');
         $this->datatable->join('tb_userapp as d','d.account_name = a.create_by','LEFT');
         $this->datatable->join('tb_deliverable e','e.id_deliv = a.deliverables','LEFT');
         $this->datatable->where([
            'd.unit_id'=>$this->session->unit_id,
            'a.status'=>'0',
         ]);
         $this->datatable->where("(month='".date('n')."' OR month='".(date('n')+1)."' OR month_postponse='".date('n')."' OR month_postponse='".(date('n')+1)."')");
         $this->datatable->edit_column('id_check',
         '<input type="checkbox" name="check_act_$1" id="check_act_$1" class="selected_act" data-id="$1" charge_code="$2" budget_est="$4" deliverables="$3" >'
         ,'get_url_encode(id_check),source_fund,deliverables,budget');
         $this->datatable->edit_column('id_fav',
            "<span class='text-center block'>$1</span>"
         ,'check_favorite_activity(id_fav,isFavorite)');
         $this->datatable->edit_column('kegiatan',
            "<span class='label label-success code-activity'>$1</span>"
         ,'kegiatan');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('bulan',
            "<span class='block text-center'>$1/$2</span>"
         ,'get_month_id(bulan),tahun');
         $this->datatable->edit_column('username',
            "<span class='badge badge-info'>$1</span>"
         ,'username');
         echo $this->datatable->generate();
      }else{
         set_label("Monthly Activity");
         add_css([
            'adporto/vendor/select2/css/select2.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
            'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',      
            'adporto/vendor/summernote/summernote.css',
            'wizard/bootstrap-wizard.css', 
            'custom/css/user_card.css' 
         ]);
         add_js([
            'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
            'adporto/vendor/select2/js/select2.js',
            'adporto/vendor/summernote/summernote.js',
            'wizard/bootstrap-wizard.js',
            'custom/js/page/monthactivity/alllist.js?v=1.0.0.0.3'
         ]);
         $data['operations'] = $this->db->get_where('tb_userapp', [
				'role' => 'OPERATION',
				'trash' => '0',
				'is_program_assistance' => 1
			])->result();
         $data['manajer']		=$this->b_model->getTorApprover()->result_array();
         $this->template('v_mounthly_activity_new',$data);
      }
   }

   function pending_tor(){
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,h.deliv,CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget,
         b.username as req_from,DATE_FORMAT(a.create_date,'%d %M %Y') as tgl_req,f.username as req_to,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		   ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitfrom","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left")
         ->join("tb_userapp f","f.email = a.submitto","left");
         $this->datatable->where("a.status","0");
         $this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->group_by('a.tor_number');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('what',
            "$1"
         ,'tot_description(what, where, who, date_start, date_end)');
         $this->datatable->edit_column('tor_number',
            "<span class='block korelasi cursor-pointer' title='Click to open detail activity' tor_number='$1'>
               <span class='badge badge-success long_display'><i class='fa fa-chevron-right'></i> $1</span>
            </div>"
         ,'tor_number');
         echo $this->datatable->generate();
      }else{
         set_label("Waiting for TOR approval");
         add_css([
            'adporto/vendor/select2/css/select2.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
            'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',        
         ]);
         add_js([
            'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
            'adporto/vendor/select2/js/select2.js',
            'custom/js/page/monthactivity/pending_tor.js?v=1.0.0.1'
         ]);
         $this->template('v_pending_tor');
      }
   }


   function pending_finance(){
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,h.deliv,b.username as approved_by,DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		   ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitto","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         $this->datatable->where("a.finance_request","0");
         $this->datatable->where("a.status_finance","0");
         $this->datatable->where("a.status","1");
         $this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->group_by('a.tor_number');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('what',
            "$1"
         ,'tot_description(what, where, who, date_start, date_end)');
         $this->datatable->edit_column('tor_number',
            "<span class='block korelasi cursor-pointer' title='Click to open detail activity' tor_number='$1'>
               <span class='badge badge-success long_display'><i class='fa fa-chevron-right'></i> $1</span>
            </div>"
         ,'tor_number');
         echo $this->datatable->generate();
      }else{
         set_label("Waiting for PR request");
         add_css([
            'adporto/vendor/select2/css/select2.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
            'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',        
         ]);
         add_js([
            'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
            'adporto/vendor/select2/js/select2.js',
            'custom/js/page/monthactivity/pending_finance.js?v=1.0.0.0'
         ]);
         $this->template('v_pending_finance');
      }
   }

   function pending_finance_approve(){
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,h.deliv,b.username as approved_by,DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		  ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.id = a.finance_request_by","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         $this->datatable->where("a.finance_request","1");
         $this->datatable->where("a.status_finance","0");
         $this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->group_by('a.tor_number');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('what',
            "$1"
         ,'tot_description(what, where, who, date_start, date_end)');
         $this->datatable->edit_column('tor_number',
            "<span class='block korelasi cursor-pointer' title='Click to open detail activity' tor_number='$1'>
               <span class='badge badge-success long_display'><i class='fa fa-chevron-right'></i> $1</span>
            </div>"
         ,'tor_number');
         echo $this->datatable->generate();
      }else{
         set_label("Waiting for finance approval");
         add_css([
            'adporto/vendor/select2/css/select2.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
            'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',        
         ]);
         add_js([
            'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
            'adporto/vendor/select2/js/select2.js',
            'custom/js/page/monthactivity/pending_finance.js?v=1.0.0.0'
         ]);
         $this->template('v_pending_finance_approve');
      }
   }

   function postponed(){
      if(ajax()==true){
         $this->load->library('datatable');
         $this->datatable->select('a.kode_kegiatan as id,
         a.kode_kegiatan as kegiatan,
         c.charge_code as source_fund,
         (CONCAT(b.loca_province,IF(b.loca_district != "",CONCAT(" - ",b.loca_district),""))) as location,
         a.activity as actvty,e.deliv,
         a.month as bulan,
         (CASE 
      WHEN a.month_postponse="1" THEN "January"
      WHEN a.month_postponse="2" THEN "February"
      WHEN a.month_postponse="3" THEN "March"
      WHEN a.month_postponse="4" THEN "April"
      WHEN a.month_postponse="5" THEN "May"
      WHEN a.month_postponse="6" THEN "June"
      WHEN a.month_postponse="7" THEN "July"
      WHEN a.month_postponse="8" THEN "August"
      WHEN a.month_postponse="9" THEN "September"
      WHEN a.month_postponse="10" THEN "October"
      WHEN a.month_postponse="11" THEN "November"
      WHEN a.month_postponse="12" THEN "December"
    END),
         d.username,
         CONCAT("Rp ",FORMAT(a.budget_estimaton,2,"de_DE")) as budget,
         a.year as tahun,
         a.deliverables
         ',true);
         $this->datatable->from('tb_detail_monthly as a');
         $this->datatable->join('tb_project_location as b','b.loca_id=a.project_location','LEFT');
         $this->datatable->join('tb_source_fund as c','c.fund_id=a.fund_id','LEFT');
         $this->datatable->join('tb_userapp as d','d.account_name = a.create_by','LEFT');
         $this->datatable->join('tb_deliverable e','e.id_deliv = a.deliverables','LEFT');
         $this->datatable->where([
            'd.unit_id'=>$this->session->unit_id,
            'a.status'=>'2',
         ]);
         $this->datatable->where("(month='".date('n')."' OR month='".(date('n')+1)."')");
         $this->datatable->edit_column('kegiatan',
            "<span class='label label-success code-activity'>$1</span>"
         ,'kegiatan');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('bulan',
            "<span class='block text-center'>$1/$2</span>"
         ,'get_month_id(bulan),tahun');
         $this->datatable->edit_column('username',
            "<span class='badge badge-info'>$1</span>"
         ,'username');
         echo $this->datatable->generate();
      }else{
         set_label("Postponed Activity");
         $this->template('v_monthly_activity_postponed_new');
      }
   }

   function canceled(){
      if(ajax()==true){
         $this->load->library('datatable');
         $this->datatable->select('a.kode_kegiatan as id,
         a.kode_kegiatan as kegiatan,
         c.charge_code as source_fund,
         (CONCAT(b.loca_province,IF(b.loca_district != "",CONCAT(" - ",b.loca_district),""))) as location,
         a.activity as actvty,e.deliv,
         a.month as bulan,
         a.reason,
         d.username,
         CONCAT("Rp ",FORMAT(a.budget_estimaton,2,"de_DE")) as budget,
         a.year as tahun,
         a.deliverables
         ',true);
         $this->datatable->from('tb_detail_monthly as a');
         $this->datatable->join('tb_project_location as b','b.loca_id=a.project_location','LEFT');
         $this->datatable->join('tb_source_fund as c','c.fund_id=a.fund_id','LEFT');
         $this->datatable->join('tb_userapp as d','d.account_name = a.create_by','LEFT');
         $this->datatable->join('tb_deliverable e','e.id_deliv = a.deliverables','LEFT');
         $this->datatable->where([
            'd.unit_id'=>$this->session->unit_id,
            'a.status'=>'3',
         ]);
         $this->datatable->where("(month='".date('n')."' OR month='".(date('n')+1)."')");
         $this->datatable->edit_column('kegiatan',
            "<span class='label label-success code-activity'>$1</span>"
         ,'kegiatan');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('bulan',
            "<span class='block text-center'>$1/$2</span>"
         ,'get_month_id(bulan),tahun');
         $this->datatable->edit_column('username',
            "<span class='badge badge-info'>$1</span>"
         ,'username');
         echo $this->datatable->generate();
      }else{
         set_label("Cancelled Activity");
         $this->template('v_monthly_activity_canceled_new');
      }
   }

   function rejected(){
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what as what,
         a.rejected_reason,
         CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget,
         b.username as req_from,DATE_FORMAT(a.create_date,'%d %M %Y') as tgl_req, a.direct_fund_code as action,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		   ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitfrom")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left")
         ->join("tb_userapp f","f.email = a.submitto");
        //  $this->datatable->where('a.submitfrom', $this->session->email);
         $this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("a.status","2" );
         $this->datatable->or_where("a.status_finance","2");
         $this->datatable->group_by('a.tor_number');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('what',
            "$1"
         ,'tot_description(what, where, who, date_start, date_end)');
         $this->datatable->edit_column('tor_number',
            "<span class='block korelasi cursor-pointer' title='Click to open detail activity' tor_number='$1'>
               <span class='badge badge-success long_display'><i class='fa fa-chevron-right'></i> $1</span>
            </div>"
         ,'tor_number');
         $this->datatable->edit_column('action', '
            <div class="btn-group">
                <button class="btn btn-xs btn-warning btn-edit" data-id="$1"><i class="fa fa-edit"></i> Edit</button>
                <button class="btn btn-xs btn-danger btn-delete" data-id="$1"><i class="fa fa-trash"></i> Delete</button>
            </div>
        ', 'action');
         echo $this->datatable->generate();
      }else{
         set_label("Rejected");
         add_css([
            'adporto/vendor/select2/css/select2.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
            'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',      
            'adporto/vendor/summernote/summernote.css',
            'wizard/bootstrap-wizard.css', 
            'custom/css/user_card.css' 
         ]);
         add_js([
            'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
            'adporto/vendor/select2/js/select2.js',
            'adporto/vendor/summernote/summernote.js',
            'wizard/bootstrap-wizard.js',
         ]);
         $data['operations'] = $this->db->get_where('tb_userapp', [
				'role' => 'OPERATION',
				'trash' => '0',
				'is_program_assistance' => 1
			])->result();
         $data['manajer']		=$this->b_model->getTorApprover()->result_array();
         $this->template('v_rejected', $data);
      }
   }
   
   public function detailTor(){
      $code = $this->input->post('code');
      $data = $this->db->select('direct_fund_code, tor_number, background, what, where, who, date_start, date_end, justification')->from('tb_mini_proposal_new')
               ->where('direct_fund_code', $code)->get()->row();
      echo json_encode($data);
   }

   public function deleteRejected(){
      $response = ['status' => false, 'message' => 'Failed to delete mini proposal, please contact adminstrator!'];
      $code = $this->input->post('id');

      if ($code) {
         $this->db->where('direct_fund_code', $code)->delete('tb_mini_proposal_new');
         $response = ['status' => true, 'message' => 'Mini proposal deleted successfully'];
      }

      echo json_encode($response);
   }

   function update(){
      if(ajax()){
         $this->load->library('form_validation');
         $this->form_validation->set_rules('status','Status','required');
         if(post('status')=='2'){
            $this->form_validation->set_rules('month','Month','required');
         }else if(post('status')=='3'){
            $this->form_validation->set_rules('reason','Reason','required');
         }
         $this->form_validation->set_error_delimiters('', '');
         if($this->form_validation->run()){
            $tryExplode = explode(',',post('key'));
            $countingExplodeKey=count($tryExplode);
            $multiActivityState = $countingExplodeKey > 1 ? true:false;
            for ($i=0; $i < $countingExplodeKey; $i++) { 
               # code...
               if($this->m_plan->UpdateMonthlyActivityStatus($tryExplode[$i])){
                  $this->response['success']=true;
                  $this->response['f_callback']='directfund';
               }else{
                  $this->response['success']=false;
                  $this->response['messages']['notif']='Update Monthly Status Failed, Try Again !';
               }
            }
         }else{
            foreach ($_POST as $key => $value) {
              $this->response['messages'][$key]=form_error($key);
            }
         }
         echo json_encode($this->response);
      }else{
         exit("No direct scripts access allowed.");
      }
   }

   function implemented(){
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,h.deliv,CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget,
         b.username as req_from,DATE_FORMAT(a.create_date,'%d %M %Y') as tgl_req,f.username as req_to,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		   ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitfrom","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left")
         ->join("tb_userapp f","f.email = a.submitto","left");
         $this->datatable->where("a.status","1");
         $this->datatable->where("a.status_finance","1");
         $this->datatable->where("c.status","1");
         $this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->group_by('a.tor_number');
         $this->datatable->edit_column('budget',
            "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('what',
            "$1"
         ,'tot_description(what, where, who, date_start, date_end)');
         $this->datatable->edit_column('tor_number',
            "<span class='block korelasi cursor-pointer' title='Click to open detail activity' tor_number='$1'>
               <span class='badge badge-success long_display'><i class='fa fa-chevron-right'></i> $1</span>
            </div>"
         ,'tor_number');
         echo $this->datatable->generate();
      }else{
         set_label("Implemented Activity");
         $this->template('v_monthly_activity_implemented_new');
      }
   }

   function Resubmit_miniproposal($key=null){
      if(signatureCheck($this->session->us_id)){
         $df_number=$this->m_plan->getDirectFundNumber($key);
         $df=$df_number['direct_fund_code'];
         $data_df=$this->b_model->getDirectFund($df)->row_array();
         if($data_df['status']==1){
            $this->response=[
               'title'=>'Error !',
               'text'=>'Miniproposal Was Approved By '.$data_df['req_name'].' Cannot Resubmitted',
               'type'=>'error'
            ];
         }elseif($data_df['status']==2){
            $this->response=[
               'title'=>'Error !',
               'text'=>'Miniproposal Was Rejected By '.$data_df['req_name'].' Cannot Resubmitted',
               'type'=>'error'
            ];
         }elseif($this->SendMiniProposal($df)){
            $this->response=[
               'title'=>'Success !',
               'text'=>'Direct Fund Saved and Miniproposal Was Submited To Manajer !',
               'type'=>'success'
            ];
         }else{
            $this->response=[
               'title'=>'Error !',
               'text'=>'Miniproposal Submit Not Successful !',
               'type'=>'error'
            ];
         }
      }else{
         $this->response=[
            'title'=>'Error !',
            'text'=>'Sorry Direct Fund Failed Submited Because You Dont Have A Signature File, Please Contact Administrator System To Attach Your Signature And Try Agian !',
            'type'=>'error'
         ];
      }			
      echo json_encode($this->response);
   }

   function Delete_miniproposal($key=null){
      $df_number=$this->m_plan->getDirectFundNumber($key);
      $df=$df_number['direct_fund_code'];
      $data_df=$this->b_model->getDirectFund($df)->row_array();
      if($data_df['status']==1){
         $this->response=[
            'title'=>'Error !',
            'text'=>'Miniproposal Was Approved By '.$data_df['req_name'].' Cannot Deleted !',
            'type'=>'error'
         ];
      }elseif($data_df['status']==2){
         $this->response=[
            'title'=>'Error !',
            'text'=>'Miniproposal Was Rejected By '.$data_df['req_name'].' Cannot Deleted !',
            'type'=>'error'
         ];
      }else{
         if($this->m_plan->delete_directFund($data_df['df_code'])){
            $this->response=[
               'title'=>'Success !',
               'text'=>'Direct Fund Data With Number : '.$data_df['df_code'].' Was Deleted !',
               'type'=>'success'
            ];
         }else{
            $this->response=[
               'title'=>'Error !',
               'text'=>'Direct Fund Data With Number : '.$data_df['df_code'].' Failed To Deleted, Contact Administrator System !',
               'type'=>'error'
            ];
         }
      }
      echo json_encode($this->response);
   }

   function Restore_miniproposal($key=null){
      $cek=$this->m_plan->getRowActivity(get_url_decode($key));
      if($cek['kode_kegiatan']!=''){
         $df_number=$this->m_plan->getDirectFundNumber($key);
         $df=$df_number['direct_fund_code'];
         if($df!=''){
            $data_df=$this->b_model->getDirectFund($df)->row_array();
            if($data_df['status']==1){
               $this->response=[
                  'title'=>'Error !',
                  'text'=>'This Activity Have Miniproposal Was Approved By '.$data_df['req_name'].' Cannot Restored !',
                  'type'=>'error'
               ];
            }elseif($data_df['status']==2){
               $this->response=[
                  'title'=>'Error !',
                  'text'=>'This Activity Have Miniproposal Was Rejected By '.$data_df['req_name'].' Cannot Restored !',
                  'type'=>'error'
               ];
            }else{
               if($this->m_plan->restore_directFund(get_url_decode($key),$data_df['df_code'])){
                  $this->response=[
                     'title'=>'Success !',
                     'text'=>'This Activity Have Direct Fund Data With Number : '.$data_df['df_code'].' Was Restored !',
                     'type'=>'success'
                  ];
               }else{
                  $this->response=[
                     'title'=>'Error !',
                     'text'=>'This Activity Have Direct Fund Data With Number : '.$data_df['df_code'].' Failed To Restored, Contact Administrator System !',
                     'type'=>'error'
                  ];
               }
            }
         }else{
            if($this->m_plan->restore_directFund(get_url_decode($key))){
               $this->response=[
                  'title'=>'Success !',
                  'text'=>'This Activity With Number : '.get_url_decode($key).' Was Restored !',
                  'type'=>'success'
               ];
            }else{
               $this->response=[
                  'title'=>'Error !',
                  'text'=>'This Activity With Number : '.get_url_decode($key).' Failed To Restored, Contact Administrator System !',
                  'type'=>'error'
               ];
            }
         }
      }else{
         $this->response=[
            'title'=>'Error !',
            'text'=>'Activity With Number : '.get_url_decode($key).' Cannot Be Found, Try Again !',
            'type'=>'error'
         ];
      }
      echo json_encode($this->response);
   }
   
   function submit_to_finance(){
   	  $key = get("id");
   	  $email = get("email");

        $this->db->select('a.code_activity, b.detail_activity');
        $this->db->from('tb_mini_proposal_new a');
        $this->db->join("tb_detail_monthly b","a.code_activity = b.kode_kegiatan","left");
        $this->db->where('a.tor_number',$key);
        $this->db->where('b.detail_activity',2);
        $query=$this->db->get();   
        
        
                     foreach ($query->result_array() as $row) {
                  
                    		$this->db->where('kode_kegiatan', $row['code_activity'])->update('tb_detail_monthly', [
                    			'detail_activity' => 3
                    		]);                        

                    }
                    


		$this->db->where('tor_number', $key);
		$update = $this->db->update('tb_mini_proposal_new', [
			'finance_request' => '1',
			'finance_request_by'=>$this->session->us_id,
			'finance_request_at'=>date('Y-m-d H:i:s')
		]);
		                    
                           	  

      if($update){
         $this->response=[
            'success'=>true,
         ];
      }else{
         $this->response=[
            'success'=>false,
         ];
      }
      echo json_encode($this->response);
   }   


   function add_to_favorite(){
      $key = post("id");
      $this->db->where('kode_kegiatan',$key);
      $update = $this->db->update('tb_detail_monthly',['isFavorite'=>true]);
      if($update){
         $this->response=[
            'success'=>true,
         ];
      }else{
         $this->response=[
            'success'=>false,
         ];
      }
      echo json_encode($this->response);
   }

   function remove_to_favorite(){
      $key = post("id");
      $this->db->where('kode_kegiatan',$key);
      $update = $this->db->update('tb_detail_monthly',['isFavorite'=>false]);
      if($update){
         $this->response=[
            'success'=>true,
         ];
      }else{
         $this->response=[
            'success'=>false,
         ];
      }
      echo json_encode($this->response);
   }
   
   function add_to_process(){
      $key = post("id");
      $this->db->where('kode_kegiatan',$key);
      $update = $this->db->update('tb_detail_monthly',['detail_activity'=>2]);
      if($update){
         $this->response=[
            'success'=>true,
         ];
      }else{
         $this->response=[
            'success'=>false,
         ];
      }
      echo json_encode($this->response);
   }   
   
   function get_activites_by_tor($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->where("b.tor_number",$tor_number)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form'>
         <thead>
            <tr>
               <th width='5px'>No.</th>
               <th width='100px'>Code Activity</th>
               <th>Activity</th>
               <th width='100px'>Activity<br/> Status</th>
               <th width='100px'>Budget<br/> Estimation</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>
               <td align='left'>".$ta->activity."</td>";
            echo"
               <td align='left'>";
               echo labelingStatusActivity(true,$ta->status,$ta->status_finance,$ta->finance_request);
            echo"</td>
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   }
   
   
   function get_activites_by_tor2($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		->where("((a.detail_activity = 0) OR (a.detail_activity = 1))")
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>  
               <th width='5px'></th>              
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>
               <th>Detil Budget</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><input ".(($ta->detail_activity == 0) ? 'disabled':'')." type='checkbox' name='check_act_".$ta->kode_kegiatan."' id='check_act_".$ta->kode_kegiatan."' class='selected_act' data-id='".$ta->kode_kegiatan."'></td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>               
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td><span class='badge badge-success'>".$ta->budget_status."</span></td><td><a href='" . site_url('request/request-budget/'.get_url_encode($ta->kode_kegiatan)) . "' class='edit btn btn-sm btn-faster btn-xs'><i class='icon-note'></i></a></td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   } 
   
   function get_activites_by_tor3($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		->where("a.detail_activity",2)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>             
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>
               <th>Detil Budget</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>               
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td><span class='badge badge-success'>".$ta->budget_status."</span></td><td><a href='" . site_url('request/request-budget/'.get_url_encode($ta->kode_kegiatan)) . "' class='edit btn btn-sm btn-faster btn-xs'><i class='icon-note'></i></a></td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   } 
   
   function get_activites_by_tor5($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		->where("a.detail_activity",3)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>             
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>
               <th>Detil Budget</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>               
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td><span class='badge badge-success'>".$ta->budget_status."</span></td><td><a href='" . site_url('request/request-budget/'.get_url_encode($ta->kode_kegiatan)) . "' class='edit btn btn-sm btn-faster btn-xs'><i class='icon-note'></i></a></td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   }  
   
   function get_activites_by_tor6($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		->where("a.detail_activity",4)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>             
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>
               <th>Detil Budget</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>               
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td><span class='badge badge-success'>".$ta->budget_status."</span></td><td><a href='" . site_url('request/request-budget/'.get_url_encode($ta->kode_kegiatan)) . "' class='edit btn btn-sm btn-faster btn-xs'><i class='icon-note'></i></a></td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   }     
      
   
   function get_activites_by_tor4($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		->where("a.detail_activity",3)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>               
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td></td>
               <td>".action_implementing_status_manajemen1($ta->kode_kegiatan, $ta->direct_fund_code, $ta->status_finance, $ta->status, $ta->submitto, $ta->jenis_data)."</td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   }  
   
   function get_activites_by_tor4a($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		//->where("a.detail_activity",3)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>               
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>";
               if ($this->session->us_budget_reviewer == 1) {
               	echo "<th>Action</th>";
               	}
         echo "   </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td></td>";
               if ($this->session->us_budget_reviewer == 1) {
            echo   "<td>".action_implementing_status_manajemen1($ta->kode_kegiatan, $ta->direct_fund_code, $ta->status_finance, $ta->status, $ta->submitto, $ta->jenis_data)."</td>";
              	};
            echo "</tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   }     
   
   function get_activites_by_tor7($tor_number=null){
      $get_activities=$this->db->select("a.*,b.*,c.deliv,
            (CASE 
            WHEN a.month='1' THEN 'Jan'
            WHEN a.month='2' THEN 'Feb'
            WHEN a.month='3' THEN 'Mar'
            WHEN a.month='4' THEN 'Apr'
            WHEN a.month='5' THEN 'Mei'
            WHEN a.month='6' THEN 'Jun'
            WHEN a.month='7' THEN 'Jul'
            WHEN a.month='8' THEN 'Agt'
            WHEN a.month='9' THEN 'Sep'
            WHEN a.month='10' THEN 'Okt'
            WHEN a.month='11' THEN 'Nov'
            WHEN a.month='12' THEN 'Des'
            END) as bulan      
      ")
		->from("tb_detail_monthly a")
		->join("tb_mini_proposal_new b","b.code_activity = a.kode_kegiatan","left")
		->join("tb_deliverable c","c.id_deliv = a.deliverables","left")
		->where("b.tor_number",$tor_number)
		->where("a.detail_activity",5)
		->get();

      echo "
      <table class='table table-bordered table-striped table-form' style='width:100% !important;'>
         <thead>
            <tr>
               <th width='5px'>No.</th>             
               <th width='100px'>Code Activity</th>
               <th>Deliverables</th>
               <th>Activity</th>
               <th>Year</th>
               <th>Month</th>
               <th>Budget Estimated</th>
               <th>Budget Status</th>
               <th>Detil Budget</th>
            </tr>
         </thead>
         <tbody>";
         $no=1;
         foreach ($get_activities->result() as $ta) {
            # code...
            echo"
            <tr>
               <td>".$no."</td>
               <td><span class='label label-success'>".$ta->kode_kegiatan."</span></td>               
               <td align='left'>".$ta->deliv."</td>
               <td align='left'>".$ta->activity."</td>
               <td align='left'>".$ta->bulan."</td>
               <td align='left'>".$ta->year."</td>";
            echo"
               <td ><span class='badge badge-error'>Rp ".number_format($ta->budget_estimaton,2,',','.')."</span></td>
               <td><span class='badge badge-success'>".$ta->budget_status."</span></td><td><a href='" . site_url('request/request-budget/'.get_url_encode($ta->kode_kegiatan)) . "' class='edit btn btn-sm btn-faster btn-xs'><i class='icon-note'></i></a></td>
            </tr>
            ";
            $no++;
         }

      echo"</tbody>
      </table>
      ";
   }         

}