<?php if (!defined('BASEPATH')) die();

class Input_activity extends Backend
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_lib');
        $this->load->model('M_plan', 'm_plan');
        $this->load->helper('activity');
        if (!$this->authenty->check_editor()) {
            redirect(base_url() . 'Logout');
        }
    }

    public function index_new($id = null)
    {
        if ($id != null) {
            $data = $this->m_plan->getRowActivity(get_url_decode($id));
        }
        set_label('Input Activity');
        add_js([
            'custom/js/page/intake/form-activity.js?v=1.0.0.2'
        ]);
        $this->breadcrumbs->push("Planning", 'Dashboard/plan');
        $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
        $this->breadcrumbs->push("Input Activity", "plan/input-activity");
        $data['projects']     = $this->b_model->getProjects();
        $data['group']        = $this->b_model->getResultTeam()->result_array();
        $data['level_ta']     = $this->b_model->getResultLevelTa()->result_array();
        $this->template('v_input_activity_new', $data);
    }

    public function input_budget_ori()
    {
        if (ajax()) {
            # code...
            $program_assistance_df_number = ["1"];

            if ($this->session->us_jabatan === 'OPERATION') {
                $program_assistance = $this->db->get_where('tb_program_assistance', [
                    'user_id' => $this->session->us_id
                ])->result();

                foreach($program_assistance as $pa) {
                    $program_assistance_df_number[] = $pa->direct_fund_code;
                }

            }
            $this->load->library('datatable');
            $this->datatable->select('a.kode_kegiatan as id,
            a.kode_kegiatan as kegiatan,b.deliv as beliv,a.activity as actvty,a.year as tahun,
            (CASE 
            WHEN a.month="1" THEN "Jan"
            WHEN a.month="2" THEN "Feb"
            WHEN a.month="3" THEN "Mar"
            WHEN a.month="4" THEN "Apr"
            WHEN a.month="5" THEN "Mei"
            WHEN a.month="6" THEN "Jun"
            WHEN a.month="7" THEN "Jul"
            WHEN a.month="8" THEN "Agt"
            WHEN a.month="9" THEN "Sep"
            WHEN a.month="10" THEN "Okt"
            WHEN a.month="11" THEN "Nov"
            WHEN a.month="12" THEN "Des"
            END) as bulan,
            CONCAT("Rp ",FORMAT(a.budget_estimaton,2,"de_DE")) as budget,
            a.budget_status as stt,
            a.kode_kegiatan as act
            ', true);
            $this->datatable->from('tb_mini_proposal_new as c ');
            $this->datatable->join('tb_detail_monthly as a', 'c.code_activity = a.kode_kegiatan', 'INNER');
            $this->datatable->join('tb_deliverable as b', 'b.id_deliv=a.deliverables', 'LEFT');
            $this->datatable->join('tb_program_assistance as d', 'd.direct_fund_code = c.direct_fund_code ', 'LEFT');
            $this->datatable->where('c.status','1');
            $this->datatable->where("c.finance_request",'0');
            $this->datatable->where_in('c.direct_fund_code', $program_assistance_df_number);
            $this->datatable->group_by("c.direct_fund_code");
            $this->datatable->edit_column(
                'act',
                "<a href='" . site_url('request/request-budget/$1') . "' class='edit btn btn-sm btn-faster btn-xs'><i class='icon-note'></i></a>",
                'get_url_encode(act)'
            );
            $this->datatable->edit_column(
                'kegiatan',
                "<span class='label label-success code-activity'>$1</span>",
                'kegiatan'
            );
            $this->datatable->edit_column(
                'budget',
                "<span class='badge badge-error'>$1</span>",
                'budget'
            );
            $this->datatable->edit_column(
                'stt',
                "<span class='badge badge-success'>$1</span>",
                'stt'
            );
            echo $this->datatable->generate();
        } else {
            set_label('Activity Budget');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_budget');
            // echo $this->id_user;
        }
    }
    
    public function activity_budget_unprocessed()
    {
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,i.username, DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved, 
         CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget,
         a.tor_number as id2, b.username as approved_by,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		     ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitto","left")
         ->join("tb_userapp i","a.create_by = i.id","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         //-rere $this->datatable->where("a.finance_request","0");
         $this->datatable->where("a.status_finance","0");
         $this->datatable->where("a.status","1");
         $this->datatable->where("a.unit_code",$this->session->unit_id);
         /////$this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->where("((c.detail_activity=0) OR (c.detail_activity=1))");
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
         $this->datatable->edit_column('budget', "<span class='badge badge-error'>$1</span>", 'budget');
       
         echo $this->datatable->generate();
      }else{
            set_label('Activity Budget');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('_new_v_view_activity_budget');
            // echo $this->id_user;
      }
    }  
    
    public function activity_budget_processed()
    {
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,i.username, DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved, 
         CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget, a.tor_number as id_submit, b.username as approved_by,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		     ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitto","left")
         ->join("tb_userapp i","a.create_by = i.id","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         //-rere $this->datatable->where("a.finance_request","0");
         $this->datatable->where("a.status_finance","0");
         $this->datatable->where("a.status","1");
         /////$this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->where("c.detail_activity", 2);
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
            </span>"
         ,'tor_number');
         $this->datatable->edit_column('id_submit',
            "<button class='btn btn-default btn-submit-activityx submit-activity' type='button' tor_number='$1'>Submit</button>"
         ,'id_submit');         
       
         echo $this->datatable->generate();
      }else{
            set_label('Activity Budget');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_processed');
            // echo $this->id_user;
      }
    }   
    
    public function activity_budget_submited()
    {
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,i.username, DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved, 
         CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget, a.tor_number as id_submit, b.username as approved_by,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		     ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitto","left")
         ->join("tb_userapp i","a.create_by = i.id","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         //-rere $this->datatable->where("a.finance_request","0");
         $this->datatable->where("a.status_finance","0");
         $this->datatable->where("a.status","1");
         /////$this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->where("c.detail_activity", 3);
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
            </span>"
         ,'tor_number');
         $this->datatable->edit_column('id_submit',
            "<button class='btn btn-default btn-submit-activityx submit-activity' type='button' tor_number='$1'>Submit</button>"
         ,'id_submit');         
       
         echo $this->datatable->generate();
      }else{
            set_label('Activity Budget');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_submited');
            // echo $this->id_user;
      }
    }         
        
    public function activity_budget_approved()
    {
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,i.username, DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved, 
         CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget, a.tor_number as id_submit, b.username as approved_by,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		     ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitto","left")
         ->join("tb_userapp i","a.create_by = i.id","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         //-rere $this->datatable->where("a.finance_request","0");
         $this->datatable->where("a.status_finance","1");
         $this->datatable->where("a.status","1");
         /////$this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->where("c.detail_activity", 4);
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
            </span>"
         ,'tor_number');
         $this->datatable->edit_column('id_submit',
            "<button class='btn btn-default btn-submit-activityx submit-activity' type='button' tor_number='$1'>Submit</button>"
         ,'id_submit');         
       
         echo $this->datatable->generate();
      }else{
            set_label('Activity Budget');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_approved');
            // echo $this->id_user;
      }
    }   
    
    public function activity_budget_rejected()
    {
      if(ajax()){
         $this->load->library('datatable');
         $this->load->helper('monthly_activity');
         $this->datatable->select("
         a.tor_number as id, a.tor_number,d.project_name,(CONCAT(e.charge_code,' - ',e.source_fund)) as charge_code,
         a.what,i.username, DATE_FORMAT(a.approve_date,'%d %M %Y') as tgl_approved, 
         CONCAT('Rp ',FORMAT(SUM(c.budget_estimaton),2,'de_DE'))  as budget, a.tor_number as id_submit, b.username as approved_by,
         a.who,a.where, DATE_FORMAT(a.date_start,'%d %M %Y') as date_start, DATE_FORMAT(a.date_end,'%d %M %Y') as date_end
         ");
         $this->datatable->from("tb_mini_proposal_new as a")
         ->join("tb_detail_monthly c","c.kode_kegiatan = a.code_activity","left")
         ->join("tb_project d","d.project_id = c.id_project","left")
		     ->join("tb_source_fund e","e.fund_id = c.fund_id","left")
         ->join("tb_userapp b","b.email = a.submitto","left")
         ->join("tb_userapp i","a.create_by = i.id","left")
         ->join("tb_deliverable h","h.id_deliv = c.deliverables","left");
         //-rere $this->datatable->where("a.finance_request","0");
         $this->datatable->where("a.status_finance","2");
         $this->datatable->where("a.status","1");
         /////$this->datatable->where("a.create_by",$this->session->us_id);
         $this->datatable->where("c.jenis_data", 1);
         $this->datatable->where("c.detail_activity", 5);
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
            </span>"
         ,'tor_number');
         $this->datatable->edit_column('id_submit',
            "<button class='btn btn-default btn-submit-activityx submit-activity' type='button' tor_number='$1'>Submit</button>"
         ,'id_submit');         
       
         echo $this->datatable->generate();
      }else{
            set_label('Activity Budget');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_rejected');
            // echo $this->id_user;
      }
    }              

    public function View_data()
    {
        if (ajax()) {
            # code...
            $this->load->helper('activity');
            $this->load->library('datatable');
            $this->datatable->select('a.kode_kegiatan as id,
                a.kode_kegiatan as kegiatan,a.activity as actvty,a.year as tahun,
                (CASE 
                WHEN a.month="1" THEN "January"
                WHEN a.month="2" THEN "February"
                WHEN a.month="3" THEN "March"
                WHEN a.month="4" THEN "April"
                WHEN a.month="5" THEN "May"
                WHEN a.month="6" THEN "June"
                WHEN a.month="7" THEN "July"
                WHEN a.month="8" THEN "August"
                WHEN a.month="9" THEN "September"
                WHEN a.month="10" THEN "October"
                WHEN a.month="11" THEN "November"
                WHEN a.month="12" THEN "December"
                END) as bulan,
                c.code_activity as status_implemented,
                CONCAT("Rp ",FORMAT(a.budget_estimaton,2,"de_DE")) as budget,
                a.kode_kegiatan as id_fav,
                a.kode_kegiatan as act,
                a.isFavorite,
                c.status,c.status_finance,c.finance_request
                ',
            true);
            $this->datatable->from('tb_detail_monthly as a');
            $this->datatable->join('tb_deliverable as b', 'b.id_deliv=a.deliverables', 'LEFT');
            $this->datatable->join('tb_mini_proposal_new as c', 'c.code_activity = a.kode_kegiatan', 'LEFT');
            $this->datatable->where([
                'a.create_by' => $this->id_user,
            ]);
            $this->datatable->edit_column(
                'act',
                '<span class="block text-center">$1</span>',
                'action_on_data_activity(act,status_implemented)'
            );
            $this->datatable->edit_column(
                'kegiatan',
                "<span class='label label-success code-activity'>$1</span>",
                'kegiatan'
            );
            $this->datatable->edit_column(
                'budget',
                "<span class='badge badge-error'>$1</span>",
                'budget'
            );
            $this->datatable->edit_column(
                'id_fav',
                "<span class='text-center block'>$1</span>",
                'check_favorite_activity(id_fav,isFavorite)'
            );
            $this->datatable->edit_column(
                'status_implemented',
                "<span class='text-center block'>$1</span>",
                'labelingStatusActivity(status_implemented,status,status_finance,finance_request)'
            );
            $this->datatable->edit_column(
                'stt',
                "<span class='badge badge-success'>$1</span>",
                'stt'
            );
            echo $this->datatable->generate();
        } else {
            set_label('View Activity');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity.js?v=1.0.0.1',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_new');
        }
    }

    public function View_data_favorite()
    {
        if (ajax()) {
            # code...
            $this->load->library('datatable');
            $this->datatable->select('a.kode_kegiatan as id,
        a.kode_kegiatan as kegiatan,b.deliv as beliv,a.activity as actvty,a.year as tahun,
        (CASE 
          WHEN a.month="1" THEN "January"
          WHEN a.month="2" THEN "February"
          WHEN a.month="3" THEN "March"
          WHEN a.month="4" THEN "April"
          WHEN a.month="5" THEN "May"
          WHEN a.month="6" THEN "June"
          WHEN a.month="7" THEN "July"
          WHEN a.month="8" THEN "August"
          WHEN a.month="9" THEN "September"
          WHEN a.month="10" THEN "October"
          WHEN a.month="11" THEN "November"
          WHEN a.month="12" THEN "December"
        END) as bulan,
        CONCAT("Rp ",FORMAT(a.budget_estimaton,2,"de_DE")) as budget,
        a.kode_kegiatan as act
        ', true);
            $this->datatable->from('tb_detail_monthly as a');
            $this->datatable->join('tb_deliverable as b', 'b.id_deliv=a.deliverables', 'LEFT');
            $this->datatable->join('tb_mini_proposal_new as c', 'c.code_activity = a.kode_kegiatan', 'LEFT');
            $this->datatable->join('tb_purchases_item as d', 'd.df_code = c.direct_fund_code', 'LEFT');
            $this->datatable->where([
                'a.create_by' => $this->id_user,
                'a.isFavorite' => '1'
            ]);
            $this->datatable->where('d.df_code IS NOT NULL');
            $this->datatable->group_by('a.kode_kegiatan');
            $this->datatable->edit_column(
                'act',
                "<span style='text-align:left !important;display:block !important'>
                    <a href='#' data-id='$2'  data-deliverables='$3'  data-activities='$4'  data-budget='$5' class='implementing_again text-success '><i class='icon-action-undo'></i> Implementing again</a><br/>
                    <a href='#' class='text-danger remove_to_fav' data-id='$2'><i class='icon-trash'></i> Remove from favorit</a>
                </span>",
                'get_url_encode(act),act,beliv,actvty,budget'
            );
            $this->datatable->edit_column(
                'kegiatan',
                "<span class='label label-success code-activity'>$1</span>",
                'kegiatan'
            );
            $this->datatable->edit_column(
                'budget',
                "<span class='badge badge-error'>$1</span>",
                'budget'
            );
            $this->datatable->edit_column(
                'stt',
                "<span class='badge badge-success'>$1</span>",
                'stt'
            );
            echo $this->datatable->generate();
        } else {
            set_label('View Activity');
            add_css([
                'adporto/vendor/select2/css/select2.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
                'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
                'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',
            ]);
            add_js([
                'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
                'adporto/vendor/select2/js/select2.js',
                'custom/js/page/intake/view_activity_favorite.js?v=1.0.0.1',
            ]);
            $this->breadcrumbs->push("Planning", 'Dashboard/plan');
            $this->breadcrumbs->push("Intake", "plan/input-activity/dashboard-intake");
            $this->breadcrumbs->push("Input Activity", "plan/input-activity/view-data-activity");
            $this->breadcrumbs->push("View Data", "#");
            $this->template('v_view_activity_favorite_new');
        }
    }

    public function saving($id = null)
    {
        if (ajax()) {
            $this->response['success'] = false;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('project_location', 'Project Location', 'required');
            $this->form_validation->set_rules('id_project', 'Project', 'required');
            $this->form_validation->set_rules('fund_id', 'Source Fund', 'required');
            $this->form_validation->set_rules('group_id', 'Group/Team', 'required');
            $this->form_validation->set_rules('deliverables', 'Deliverables', 'required');
            $this->form_validation->set_rules('activity', 'Activity', 'required');
            $this->form_validation->set_rules('year', 'Year', 'required');
            $this->form_validation->set_rules('month', 'Month', 'required');
            $this->form_validation->set_rules('budget_es', 'Budget Estimation', 'required');
            $this->form_validation->set_error_delimiters('', '');
            if ($this->form_validation->run()) {
                if (post('IdEdit') != '') {
                    if ($this->m_plan->update_activity() == true) {
                        $this->response['success'] = true;
                        $this->response['notif'] = '<b>' . post('code_act') . '</b><br/>Success updated !';
                    } else {
                        $this->response['notif'] = '<b>' . post('code_act') . '</b><br/>Failed update !';
                    }
                } else {
                    if ($this->m_plan->save_activity(true)) {
                        $this->response['success'] = true;
                        $this->response['notif'] = 'Activity saved successfully';
                    } else {
                        $this->response['notif'] = 'Failed save data activity !';
                    }
                }
            } else {
                foreach ($_POST as $key => $value) {
                    $this->response['messages'][$key] = str_replace('The','',form_error($key));
                }
            }
            echo json_encode($this->response);
        } else {
            exit("No direct script access allowed");
        }
    }

    public function Delete_data()
    {
        if (ajax()) {
            $do_delete_activity = $this->m_plan->detele_actifity(get_url_decode(post('id')));
            if($do_delete_activity == true){
                $this->response=[
                    'success'=>true
                ];
            } else {
                $this->response=[
                    'success'=>true
                ];
            }
            echo json_encode($this->response);
        } else {
            exit("No direct script access allowed.");
        }
    }

    public function Detail_budget_new()
    {
        redirect(base_url('/plan/input-activity'));
    }

    function getKeyFocus()
    {
        if (ajax()) {
            echo json_encode($this->m_plan->getKeyFocus(post('id'))->result_array());
        } else {
            exit("No direct script access allowed.");
        }
    }

    function getDeliveribleByGroup(){
        if (ajax()) {
            echo json_encode($this->m_plan->getDeliverableByGroup(post('id'))->result_array());
        } else {
            exit("No direct script access allowed.");
        }
    }

    function getKeyFocusGroup($group=''){
        $focus = $this->m_plan->getKeyFocusGroup($group);
        if ($focus) {
            echo "<option value=''>Project Objectives";
            foreach ($focus as $fc) {
                echo "<option value='" . $fc->id_key . "'>" . $fc->key_name . "</option>";
            }
        } else {
            echo "<option value=''>roject Objectives</option>";
        }
    }

    function getKeyActivities($group=''){
        $activities = $this->m_plan->getKeyActivities($group);
        if ($activities) {
            echo "<option value=''>Key Activities by Project Objectives";
            foreach ($activities as $ac) {
                echo "<option value='".$ac->id_deliv."'>".$ac->deliv."</option>";
            }
        }else{
            echo "<option value=''>Key Activities by Project Objectives";
        }
    }

    function getDeliverable()
    {
        if (ajax()) {
            echo json_encode($this->m_plan->getDeliverable(post('id'))->result_array());
        } else {
            exit("No direct script access allowed.");
        }
    }

    public function index()
    {
        $data['menu_titel'] = $this->menu_titel;
        $data['page_titel'] = $this->page_titel;

        $data['authen'] = $this->authenty->sess();

        $this->load->view('intranet_includes/v_header.php', $data);
        $this->load->view('v_input_activity.php');
        $this->load->view('intranet_includes/v_footer.php');
    }

    function dashboard_intake()
    {
        redirect(site_url('plan/input-activity/'));
    }

    public function detail_budget()
    {
        $data['menu_titel'] = $this->menu_titel;
        $data['page_titel'] = $this->page_titel;

        $data['authen'] = $this->authenty->sess();

        $this->load->view('intranet_includes/v_header.php', $data);
        $this->load->view('v_detail_budget.php');
        $this->load->view('intranet_includes/v_footer.php');
    }

    public function simpan()
    {
        $file_cek = $this->input->post("file");

        if ($file_cek == 'undefined') {
            $err = "Masukkan file yang akan diupload";
            $klas = "#file";
        } else {
            $file = $_FILES['file']['name'];
            $fileExt = $this->get_file_extension($_FILES['file']['name']);
            $exp = "upload_detail_monthly";
            $nama_file = $exp;

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '5000000'; // max file yang boleh di upload 1 MB
            $config['file_name'] = $nama_file . "." . strtolower($fileExt);
            $config['overwrite'] = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {
                $path = './uploads/upload_detail_monthly.xlsx';
                if (file_exists($path)) {
                    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                    $excelreader = new PHPExcel_Reader_Excel2007();
                    $loadexcel = $excelreader->load('./uploads/upload_detail_monthly.xlsx'); // Load file yang telah diupload ke folder excel
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    foreach ($sheet as $row) {
                        // Cek $numrow apakah lebih dari 1
                        // Artinya karena baris pertama adalah nama-nama kolom
                        // Jadi dilewat saja, tidak usah diimport
                        if ($numrow > 1) {
                            // Kita push (add) array data ke variabel data
                            $data['kode_kegiatan'] = $row['A'];
                            $data['deliverables'] = $row['B'];
                            $data['activity'] = $row['C'];
                            $data['month'] = $row['D'];
                            $data['periode_month_1'] = $row['E'];
                            $data['periode_month_2'] = $row['F'];
                            $data['periode_month_3'] = $row['G'];
                            $data['periode_month_4'] = $row['H'];
                            $data['accountable'] = $row['I'];
                            $data['consulted'] = $row['J'];
                            $data['informed'] = $row['K'];
                            $data['ta'] = $row['L'];
                            $data['status'] = $row['M'];
                            $data['budget_estimaton'] = $row['N'];
                            $result = $this->Model_lib->insert("tb_detail_monthly", $data);
                        }

                        $numrow++; // Tambah 1 setiap kali looping
                    }

                    $err = "s";
                    $klas = "-";
                } else {

                    // $result = $this->Model_lib->insert($tabel,$data);
                    $err = "Excel yang di upload  tidak dapat dibaca";
                    $klas = "-";
                }
            } else {
                $error = $this->upload->display_errors();
                $err = $error . CI_VERSION;
                //$err="Unggah file gagal dilakukan. Pastikan ukuran dan tipe file sesuai yang telah ditentukan";
                $klas = "-";
            }
        }
        $arr = array('err' => $err, 'klas' => $klas);
        echo json_encode($arr);
    }

    function form()
    {
        $id = $this->input->post("id");
        if (!empty($id)) {
            $sql = "select*from tb_detail_monthly where id='" . $id . "'";
            $result = $this->Model_lib->SelectQuery($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $row) {
                    $id = $row->id;
                    $kode_kegiatan = $row->kode_kegiatan;
                    $deliverables = $row->deliverables;
                    $activity = $row->activity;
                    $data_year = $row->year;
                    $month = $row->month;
                    $accountable = $row->accountable;
                    $consulted = $row->consulted;
                    $informed = $row->informed;
                    $budget_estimaton = $row->budget_estimaton;
                    $project_location = $row->project_location;
                    $url = "proses_edit";
                    $readonly = "readonly";
                }
            } else {
                $id = "";
                $kode_kegiatan = "";
                $deliverables = "";
                $activity = "";
                $data_year = "";
                $month = "";
                $accountable = "";
                $consulted = "";
                $informed = "";
                $budget_estimaton = "";
                $project_location = "";
                $url = "save";
                $readonly = "";
            }
        } else {
            $id = "";
            $kode_kegiatan = "";
            $deliverables = "";
            $activity = "";
            $data_year = "";
            $month = "";
            $accountable = "";
            $consulted = "";
            $informed = "";
            $budget_estimaton = "";
            $project_location = "";
            $url = "save";
            $readonly = "";
        }
        echo '<div class="row"><form id="submit" class="form-horizontal">';
        echo '<div class="col-md-6">';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Project Location</label>
                        <div class="col-sm-6"> <select class="form-control" id="project_location" name="project_location">';
        select_location($project_location);
        echo '</select></div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Code Activity</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="kode_kegiatan" name="kode_kegiatan" value="' . $kode_kegiatan . '" ' . $readonly . '>(ex:RA01904D01-001)
                          <input type="hidden" class="form-control" id="id" name="id" value="' . $id . '">
                        </div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Deliverables</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="deliverables" name="deliverables" value="' . $deliverables . '">
                        </div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Activity</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="activity" name="activity" value="' . $activity . '">
                        </div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-6"> <select class="form-control" id="year" name="year">';
        echo '<option value="0" >Select Year</option>';
        $year = date("Y") + 1;
        $prev = $year - 5;
        for ($i = $year; $i >= $prev; $i--) {
            if ($i == $data_year) {
                echo '<option value="' . $i . '" selected>' . $i . '</option>';
            } else {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
        }
        echo '</select></div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Month</label>
                        <div class="col-sm-6"> <select class="form-control" id="month" name="month">';
        echo '<option value="0" >Select Month</option>';
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $month) {
                echo '<option value="' . $i . '" selected>' . select_month($i) . '</option>';
            } else {
                echo '<option value="' . $i . '">' . select_month($i) . '</option>';
            }
        }
        echo '</select></div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Accountable (A)</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="accountable" name="accountable" value="' . $accountable . '">
                        </div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Consulted (C)</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="consulted" name="consulted" value="' . $consulted . '">
                        </div>
                      </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Informed (I)</label>
                        <div class="col-sm-6">
                          <input type="text" class="form-control" id="informed" value="" name="informed"
                          value="' . $informed . '">
                        </div>
                      </div>';
        // echo '<div class="form-group">
        //    <label for="inputEmail3" class="col-sm-3 control-label">Budget Estimaton</label>
        //    <div class="col-sm-6">
        //      <input type="text" class="form-control" id="budget_estimaton" value="'.$budget_estimaton.'" 
        //          name="budget_estimaton" onkeypress="return checkIt(event);" value="0">
        //    </div>
        //  </div>';
        echo '<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Budget Estimaton</label>
                        <div class="col-sm-6">
                          <button type="button" class="btn btn-primary btn-sm" value="" data-toggle="modal" data-target="#myModal">Create Purchase Request Form</button>
                      </div>';


        echo '</div>';
        echo '<div class="col-md-12"><button type="button" class="btn btn-default ' . $url . '">Save</button></div>';
        echo '</form></div>';
    }

    function tabel()
    {
        $data['create_by'] = trim($this->authenty->session_user());

        $sql = "select*from tb_detail_monthly where create_by='" . $data['create_by'] . "' order by year DESC,month ASC";
        $result = $this->Model_lib->SelectQuery($sql);

        echo '<table class="table table-bordered table-striped mb-none">
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Code Activity</th>
              <th class="text-center">Deliverables</th>
              <th class="text-center">activity</th>
               <th class="text-center">Year</th>
              <th class="text-center">Month</th>
              <th colspan="3" class="text-center">Roles at Country Level (RACI)</th>
              <th class="text-center">Budget Estimaton</th> 
              <th class="text-center">Edit</th>
            </tr>
            <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center">Accountable (A)</td>
              <td class="text-center">Consulted (C)</td>
              <td class="text-center">Informed (I)</td>
              <td class="text-center"></td>
              <td class="text-center"></td>
            </tr>';

        if ($result->num_rows() > 0) {
            $no = 1;
            foreach ($result->result() as $row) {
                echo '<tr>
              <td class="text-center">' . $no++ . '</td>
              <td class="text-center">' . $row->kode_kegiatan . '</td>
              <td class="text-center">' . $row->deliverables . '</td>
              <td class="text-center">' . $row->activity . '</td>
              <td class="text-center">' . $row->year . '</td>
              <td class="text-center">' . month($row->month) . '</td>
              <td class="text-center">' . $row->accountable . '</td>
              <td class="text-center">' . $row->consulted . '</td>
              <td class="text-center">' . $row->informed . '</td>
              <td class="text-center">' . $row->budget_estimaton . '</td>     
               <td class="text-center">
                        <a href="#" id="edit" title="Edit Row" data-id="' . $row->id . '" data-kodekegiatan="' . $row->kode_kegiatan . '"><i class="fa fa-pencil"></i></a>
                        <a href="#" id="delete" title="Delete Row" data-id="' . $row->id . '" data-kodekegiatan="' . $row->kode_kegiatan . '"><i class="fa fa-trash-o"></i></a>
               </td>    
            </tr>';
            }
        } else {
            echo '<tr>
              <td class="text-center" colspan="10"></td>
              </td>
              </tr>';
        }

        echo '</table>';
    }

    function tabel_detail_budget()
    {
        $data['create_by'] = trim($this->authenty->session_user());

        $sql = "select*from tb_detail_monthly where create_by='" . $data['create_by'] . "' order by year DESC,month ASC";
        $result = $this->Model_lib->SelectQuery($sql);

        echo '<table class="table table-bordered table-striped mb-none">
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Code Activity</th>
              <th class="text-center">Deliverables</th>
              <th class="text-center">activity</th>
              <th class="text-center">Year</th>
              <th class="text-center">Month</th>
              <th colspan="3" class="text-center">Roles at Country Level (RACI)</th>
              <th class="text-center">Budget Estimaton</th> 
              <th class="text-center">Detail Budget</th>
            </tr>
            <tr>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center"></td>
              <td class="text-center">Accountable (A)</td>
              <td class="text-center">Consulted (C)</td>
              <td class="text-center">Informed (I)</td>
              <td class="text-center"></td>
              <td class="text-center"></td>
            </tr>';

        if ($result->num_rows() > 0) {
            $no = 1;
            foreach ($result->result() as $row) {
                if (!empty($row->budget_estimaton)) {
                    $budget = desimal($row->budget_estimaton);
                } else {
                    $budget = 0;
                }
                echo '<tr>
              <td class="text-center">' . $no++ . '</td>
              <td class="text-center">' . $row->kode_kegiatan . '</td>
              <td class="text-center">' . $row->deliverables . '</td>
              <td class="text-center">' . $row->activity . '</td>
              <td class="text-center">' . $row->year . '</td>
              <td class="text-center">' . month($row->month) . '</td>
              <td class="text-center">' . $row->accountable . '</td>
              <td class="text-center">' . $row->consulted . '</td>
              <td class="text-center">' . $row->informed . '</td>
              <td class="text-center">' . $budget . '</td>     
              <td class="text-center">
                <a href="#" id="input_detail_budget" title="Input Detail Budget" 
                data-id="' . $row->id . '" data-status="' . $row->status . '" data-kodekegiatan="' . $row->kode_kegiatan . '" class="set_update_status"><i class="fa fa-pencil"></i></a>
               </td>    
            </tr>';
            }
        } else {
            echo '<tr>
              <td class="text-center" colspan="10"></td>
              </td>
              </tr>';
        }

        echo '</table>';
    }

    function save()
    {
        $data['kode_kegiatan'] = $this->input->post("kode_kegiatan");
        $data['activity'] = $this->input->post("activity");
        $data['deliverables'] = $this->input->post("deliverables");
        $data['year'] = $this->input->post("year");
        $data['month'] = $this->input->post("month");
        $data['accountable'] = $this->input->post("accountable");
        $data['consulted'] = $this->input->post("consulted");
        $data['create_by']         = trim($this->authenty->session_user());
        $data['create_date']     = date("Y-m-d H:i:s");
        $data['budget_estimaton'] = $this->input->post("budget_estimaton");

        if (empty($data['kode_kegiatan'])) {
            $err = "Please insert code activity";
            $klas = "#kode_kegiatan";
        } else if (strlen($data['kode_kegiatan']) != '14') {
            $err = "code activity must be 14 digit";
            $klas = "#kode_kegiatan";
        } else if (empty($data['deliverables'])) {
            $err = "Please insert deliverables";
            $klas = "#deliverables";
        } else if (empty($data['activity'])) {
            $err = "Please insert activity";
            $klas = "#activity";
        } else {
            $data['code_result'] = substr($data['kode_kegiatan'], 0, 4);
            $data['code_group'] = substr($data['kode_kegiatan'], 4, 3);
            $data['code_deliverables'] = substr($data['kode_kegiatan'], 7, 3);
            $data['code_unik'] = substr($data['kode_kegiatan'], 11, 3);
            $tabel = "tb_detail_monthly";
            $result = $this->Model_lib->insert($tabel, $data);
            $err = "s";
            $klas = "-";
        }
        $arr = array('err' => $err, 'klas' => $klas);
        echo json_encode($arr);
    }

    function save_status_update()
    {
        $data['id'] = $this->input->post("id_status_update");
        $data['status'] = $this->input->post("status_update");
        $data['reason'] = $this->input->post("reason");
        if ($data['status'] == "3") {
            $data['month'] = $this->input->post("month");
        }
        $tabel = "tb_detail_monthly";
        $param = array(
            'id' => $data['id']
        );

        $result = $this->Model_lib->update($data, $tabel, $param);
        echo "s";
    }

    function proses_edit()
    {
        $data['id'] = $this->input->post("id");
        $data['kode_kegiatan'] = $this->input->post("kode_kegiatan");
        $data['activity'] = $this->input->post("activity");
        $data['deliverables'] = $this->input->post("deliverables");
        $data['year'] = $this->input->post("year");
        $data['month'] = $this->input->post("month");
        $data['accountable'] = $this->input->post("accountable");
        $data['consulted'] = $this->input->post("consulted");
        $data['informed'] = $this->input->post("informed");
        $data['budget_estimaton'] = $this->input->post("budget_estimaton");
        $data['project_location'] = $this->input->post("project_location");

        if (empty($data['kode_kegiatan'])) {
            $err = "Please insert code activity";
            $klas = "#kode_kegiatan";
        } else if (empty($data['deliverables'])) {
            $err = "Please insert deliverables";
            $klas = "#deliverables";
        } else if (empty($data['activity'])) {
            $err = "Please insert activity";
            $klas = "#activity";
        } else {
            $tabel = "tb_detail_monthly";
            $param = array(
                'id' => $data['id']
            );

            $result = $this->Model_lib->update($data, $tabel, $param);
            $err = "s";
            $klas = "-";
        }
        $arr = array('err' => $err, 'klas' => $klas);
        echo json_encode($arr);
    }

    function alasan()
    {
        $id = $this->input->post("id");
        $sql = "select*from tb_detail_monthly where id='" . $id . "'";
        $result = $this->Model_lib->SelectQuery($sql);
        if ($result->num_rows() > 0) {
            $r = $result->row();
            $reason = $r->reason;
        } else {
            $reason = "";
        }

        echo "REASON: <textarea rows=4 cols=50 id='reason' name='reason'>$reason</textarea>";
    }

    function postponse()
    {
        $id = $this->input->post("id");
        $sql = "select*from tb_detail_monthly where id='" . $id . "'";
        $result = $this->Model_lib->SelectQuery($sql);
        if ($result->num_rows() > 0) {
            $r = $result->row();
            $month = $r->month_postponse;
        } else {
            $month = "";
        }

        echo '<select class="form-control" id="month" name="month">';
        for ($i = 1; $i <= 12; $i++) {
            if ($i == $month) {
                echo '<option value="' . $i . '" selected>' . select_month($i) . '</option>';
            } else {
                echo '<option value="' . $i . '">' . select_month($i) . '</option>';
            }
        }
        echo '</select>';
    }

    function delete()
    {
        $id = $this->input->post("id");

        $del = $this->db->query("delete from tb_detail_monthly where id='" . $id . "'");
        $err = "s";

        $arr = array('err' => $err);
        echo json_encode($arr);
    }

    function get_file_extension($filename)
    {
        $lastDotPos = strrpos($filename, '.');
        if (!$lastDotPos) return false;
        return substr($filename, $lastDotPos + 1);
    }

    /**
     * fetch source fund data by project_id
     * 
     * @param int $id_project
     * @return void
     */
    public function fetch_source_fund($id_project)
    {
        $option = '<option value="">Select Source Fund</option>';
        foreach (source_fund($id_project) as $fund) {
            $auto_select='';
            if($id_project == '8'){
                $auto_select='7';
            } else if($id_project == '1'){
                $auto_select='2';
            }
            $option .= '<option value="' . $fund->fund_id . '"';
            $option .= $fund->fund_id == $auto_select ? 'selected':'';
            $option .= '>' . $fund->source_fund . '</option>';
        }

        echo $option;
    }

    public function is_po($item_id)
    {
        $cek = $this->db->get_where('item_activity', [
            'id' => $item_id
        ])->row();

        if ($cek->item_type == 1) {
            echo 'No';
        } else if ($cek->item_type == 2) {
            echo 'Yes';
        }
    }

    function Impementing_again(){
        if (ajax()) {
            $monthSelected=post('month[]');
            $year=$_POST['year'];
            $code_activity=$_POST['key'];
            if(count($monthSelected) > 1){
                $this->exist='';
                $this->reimplemented='';
                $this->failreimplemented='';
                for ($i=0; $i < count($_POST['month']); $i++) { 
                    # code...
                    $month=$_POST['month'][$i];
                    $isExist = $this->m_plan->cek_existing_reimplementing_activities_from_favorites($month,$year,$code_activity);
                    if($isExist){
                        $this->exist .=' - '.get_month_id($month).'<br/>';
                    } else {
                        $reImplementing = $this->m_plan->reImplementing($code_activity,post('activities'),$month,$year);
                        if($reImplementing){
                            $this->reimplemented .=' - '.get_month_id($month).'<br/>';
                        } else {
                            $this->failreimplemented .=' - '.get_month_id($month).'<br/>';
                        }
                    }
                }
                if($this->reimplemented != ''){
                    $this->notif='';
                    $this->notif.=post('activities').'<br/>';
                    $this->notif.='Success reimplemented on month :<br/>';
                    $this->notif.=$this->reimplemented;
                    $this->exist !='' ? $this->notif.='<br/>Exist on month :<br/>' : '';
                    $this->notif.=$this->exist;
                    $this->failreimplemented !='' ? $this->notif.='<br/>Failed reimplemented on month :<br/>':'';
                    $this->notif.=$this->failreimplemented;
                    $this->response=[
                        'success'=>true,
                        'f_notif'=>$this->notif,
                        'f_callback'=>'hideModalReimplementingActivity'
                    ];
                }else{
                    $this->notif='Failed implementing again this favorite activities, because<br/>';
                    $this->exist !='' ? $this->notif.='<br/>Exist on month :<br/>' : '';
                    $this->notif.=$this->exist;
                    $this->failreimplemented !='' ? $this->notif.='<br/>Failed reimplemented on month :<br/>':'';
                    $this->notif.=$this->failreimplemented;
                    $this->response=[
                        'success'=>false,
                        'f_notif'=>$this->notif,
                    ];
                }
            } else {
                $month=$_POST['month'][0];
                $isExist = $this->m_plan->cek_existing_reimplementing_activities_from_favorites($month,$year,$code_activity);
                if($isExist){
                    $this->response=[
                        'success'=>false,
                        'f_notif'=>post('activities').' exist on the year and month period selected.',
                    ];
                } else {
                    $reImplementing = $this->m_plan->reImplementing($code_activity,post('activities'),$month,$year);
                    if($reImplementing){
                        $this->response=[
                            'success'=>true,
                            'f_notif'=>post('activities').' implemented again successfully',
                            'f_callback'=>'hideModalReimplementingActivity'
                        ];
                    } else {
                        $this->response=[
                            'success'=>false,
                            'f_notif'=>'Failed implementing again this favorite activities.',
                        ];
                    }
                }
            }
            echo json_encode($this->response);
        } else {
            exit("No direct script access allowed.");
        }
    }
}
