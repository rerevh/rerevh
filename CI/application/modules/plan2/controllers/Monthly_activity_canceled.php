<?php

class Monthly_activity_canceled extends Backend{

   function __construct(){
      parent::__construct();
      if(!$this->authenty->check_editor()){
			redirect(base_url().'Logout');
      }
      $this->load->model('M_plan','m_plan');
   }

   function index(){
      if(ajax()==true){
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
         a.reason
         ',true);
         $this->datatable->from('tb_detail_monthly as a');
         $this->datatable->join('tb_deliverable as b','b.id_deliv=a.deliverables','LEFT');
         $this->datatable->where([
            'create_by'=>$this->id_user,
            'status'=>'3',
         ]);
         $this->datatable->where('budget_estimaton > 0 ');
         $this->datatable->where("(month='".date('n')."' OR month_postponse='".date('n')."')");

         $this->datatable->edit_column('kegiatan',
         "<span class='label label-success code-activity'>$1</span>"
         ,'kegiatan');
         $this->datatable->edit_column('budget',
         "<span class='badge badge-error'>$1</span>"
         ,'budget');
         $this->datatable->edit_column('stt',
         "<span class='badge badge-success'>$1</span>"
         ,'stt');
         echo $this->datatable->generate();
      }else{
         set_label("Monthly Activity");
         add_css([
            'adporto/vendor/select2/css/select2.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.min.css',
            'adporto/vendor/select2-bootstrap-theme/select2-bootstrap.css',
            'adporto/vendor/jquery-datatables-bs3/assets/css/datatables.css',        
         ]);
         add_js([
            'adporto/vendor/jquery-datatables-bs3/assets/js/datatables.js',
            'adporto/vendor/select2/js/select2.js',
            'custom/js/page/monthactivity/alllist.js'
         ]);
         $this->template('v_monthly_activity_canceled');
      }
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
            if($this->m_plan->UpdateMonthlyActivityStatus()){
               $this->response['success']=true;
               $this->response['f_callback']='directfund';
            }else{
               $this->response['success']=false;
               $this->response['messages']['notif']='Update Monthly Status Failed, Try Again !';
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
}