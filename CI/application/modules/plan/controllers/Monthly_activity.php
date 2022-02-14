<?php if (!defined('BASEPATH')) die();

class Monthly_activity extends CI_Controller {

	private $limit=20;
	private $site_id='';
	private $menu_titel='Settings';
	private $page_titel='Projects';

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Model_lib');
		if(!$this->authenty->check_editor()){
			redirect(base_url().'Logout');
		}
	}

	public function index()
	{
		$data['menu_titel']=$this->menu_titel;
		$data['page_titel']=$this->page_titel;

		$data['authen'] = $this->authenty->sess();

		$this->load->view('intranet_includes/v_header.php', $data);
		$this->load->view('v_view_activity.php');
		$this->load->view('intranet_includes/v_footer.php');
	}
        function dashboard_activity()
        {
        $data['menu_titel']=$this->menu_titel;
		$data['page_titel']=$this->page_titel;

		$data['authen'] = $this->authenty->sess();

		$this->load->view('intranet_includes/v_header.php', $data);
		$this->load->view('dashboard_activity.php');
		$this->load->view('intranet_includes/v_footer.php');
        }
        public function detail_budget()
	{
		$data['menu_titel']=$this->menu_titel;
		$data['page_titel']=$this->page_titel;

		$data['authen'] = $this->authenty->sess();

		$this->load->view('intranet_includes/v_header.php', $data);
		$this->load->view('v_view_budget.php');
		$this->load->view('intranet_includes/v_footer.php');
	}
         public function simpan()
        {
                  
                  $file_cek=$this->input->post("file");

                   if($file_cek=='undefined')
                   {
                       $err="Masukkan file yang akan diupload";
                       $klas="#file";
                   }
                   else
                   {
                           $file=$_FILES['file']['name'];
                           $fileExt = $this->get_file_extension($_FILES['file']['name']);
                           $exp = "upload_detail_monthly";
                           $nama_file=$exp;

                           $config['upload_path'] = './uploads/';
                           $config['allowed_types'] = '*';
                           $config['max_size'] = '5000000'; // max file yang boleh di upload 1 MB
                           $config['file_name'] = $nama_file.".".strtolower($fileExt);
                           $config['overwrite'] = true;
                           $this->load->library('upload', $config);

                            if ($this->upload->do_upload('file'))
                            {
                                $path ='./uploads/upload_detail_monthly.xlsx';
                                if(file_exists($path))
                                {
                                          include APPPATH.'third_party/PHPExcel/PHPExcel.php';
                                          
                                          $excelreader = new PHPExcel_Reader_Excel2007();
                                          $loadexcel = $excelreader->load('./uploads/upload_detail_monthly.xlsx'); // Load file yang telah diupload ke folder excel
                                          $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
    
                                            $numrow = 1;
                                            $ada = false;
                                            foreach($sheet as $row){
                                              // Cek $numrow apakah lebih dari 1
                                              // Artinya karena baris pertama adalah nama-nama kolom
                                              // Jadi dilewat saja, tidak usah diimport
                                              if($numrow > 1){
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
                                                  if(strlen($data['kode_kegiatan'])!='14')
                                                  {

                                                         $ada = true;
                                                         break;
                                                         
                                                  }
                                                  
                                              
                                                     $result = $this->Model_lib->insert("tb_detail_monthly",$data);
                                                  
                                              }

                                              $numrow++; // Tambah 1 setiap kali looping
                                            }
                                            
                                            $numrow = 1;
                                            if(!$ada)
                                            {
                                                foreach($sheet as $row){
                                                    // Cek $numrow apakah lebih dari 1
                                                    // Artinya karena baris pertama adalah nama-nama kolom
                                                    // Jadi dilewat saja, tidak usah diimport
                                                    if($numrow > 1){
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
                                                        $data['code_result'] = substr($data['kode_kegiatan'],0,4);
                                                        $data['code_group'] = substr($data['kode_kegiatan'],4,3);
                                                        $data['code_deliverables'] = substr($data['kode_kegiatan'],7,3);
                                                        $data['code_unik'] = substr($data['code_deliverables'],11,3);

                                                        $result = $this->Model_lib->insert("tb_detail_monthly",$data);
                                                        $err="s";
                                                        $klas="-";

                                                    }

                                                    $numrow++; // Tambah 1 setiap kali looping
                                                  }
                                            }
                                            else
                                            {
                                                 $err="code activity must be 14 digit";
                                                 $klas="-";  
                                            }
                                         
                                    
                                }
                                else
                                {

                                        // $result = $this->Model_lib->insert($tabel,$data);
                                    $err="Excel yang di upload  tidak dapat dibaca";
                                    $klas="-";
                                }
                                
                            }
                            else
                            {
                                $error = $this->upload->display_errors();
                                $err=$error.CI_VERSION;
                                //$err="Unggah file gagal dilakukan. Pastikan ukuran dan tipe file sesuai yang telah ditentukan";
                                $klas="-";
                            }
                            
                   }       
                     $arr = array ('err'=>$err,'klas'=>$klas);
                     echo json_encode($arr);
        }
          function form()
        {
            $id = $this->input->post("id");
            if(!empty($id))
            {
                $sql = "select*from tb_detail_monthly where id='".$id."'";
                $result = $this->Model_lib->SelectQuery($sql);
                if($result->num_rows()>0)
                {
                    foreach ($result->result() as $row)
                    {
                        $id = $row->id;
                        $kode_kegiatan = $row->kode_kegiatan;
                        $deliverables = $row->deliverables;
                        $activity = $row->activity;
                        $data_year = $row->year;
                        $month = $row->month;
                        $accountable = $row->accountable;
                        $consulted = $row->consulted;
                        $informed=$row->informed;
                        $budget_estimaton = $row->budget_estimaton;
                        $url = "proses_edit";
                    }
                }
                else
                {
                        $id="";
                        $kode_kegiatan = "";
                        $deliverables = "";
                        $activity = "";
                        $data_year = "";
                        $month="";
                        $accountable="";
                        $consulted="";
                        $informed="";
                        $budget_estimaton ="";
                        $url = "save";
                }
            }
            else
            {
                        $id="";
                        $kode_kegiatan = "";
                        $deliverables = "";
                        $activity = "";
                        $data_year = "";
                        $month="";
                        $accountable="";
                        $consulted="";
                        $informed="";
                        $budget_estimaton="";
                        $url = "save";
            }
            echo '<div class="row"><form id="submit" class="form-horizontal">';
                    echo '<div class="col-md-6">';
                            echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Code Activity</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="kode_kegiatan" name="kode_kegiatan" value="'.$kode_kegiatan.'">
                                  <input type="hidden" class="form-control" id="id" name="id" value="'.$id.'">
                                </div>
                              </div>';
                            echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Deliverables</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="deliverables" name="deliverables" value="'.$deliverables.'">
                                </div>
                              </div>';
                            echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Activity</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="activity" name="activity" value="'.$activity.'">
                                </div>
                              </div>';
                            echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Year</label>
                                <div class="col-sm-6"> <select class="form-control" id="year" name="year">';
                                    echo '<option value="0" >Select Year</option>';
                                    $year = date("Y")+1;
                                    $prev = $year-5;
                                    for($i=$year;$i>=$prev;$i--)
                                    {
                                        if($i==$data_year) 
                                         {
                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                         }
                                         else
                                         {
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                         }
                                    }
                                echo '</select></div>
                              </div>';
                                echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Month</label>
                                <div class="col-sm-6"> <select class="form-control" id="month" name="month">';
                                 echo '<option value="0" >Select Month</option>';
                                    for($i=1;$i<=12;$i++)
                                    {
                                        if($i==$month) 
                                         {
                                            echo '<option value="'.$i.'" selected>'.select_month($i).'</option>';
                                         }
                                         else
                                         {
                                            echo '<option value="'.$i.'">'.select_month($i).'</option>';
                                         }
                                    }
                                echo '</select></div>
                              </div>';
                            echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Accountable (A)</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="accountable" name="accountable" value="'.$accountable.'">
                                </div>
                              </div>';
                              echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Consulted (C)</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="consulted" name="consulted" value="'.$consulted.'">
                                </div>
                              </div>';
                            echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Informed (I)</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="informed" value="" name="informed"
                                  value="'.$informed.'">
                                </div>
                              </div>';
                             echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Budget Estimaton</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="budget_estimaton" value="'.$budget_estimaton.'" 
                                      name="budget_estimaton" onkeypress="return checkIt(event);" value="0">
                                </div>
                              </div>';
                    echo '</div>';
                    echo '<div class="col-md-12"><button type="button" class="btn btn-default '.$url.'">Save</button></div>';
             echo '</form></div>';
        }
        function tabel()
        {
            $month = date("n");
           // echo $month;
            $data['create_by'] = trim($this->authenty->session_user());
            $sql = "select*from tb_detail_monthly where month='".$month."' and create_by='".$data['create_by']."' and budget_estimaton>0 order by deliverables,year DESC,month ASC";
            $result = $this->Model_lib->SelectQuery($sql);
            
            echo '<table class="table table-bordered table-striped mb-none">
                    <tr>
                      <th class="text-center" rowspan="2">No</th>
                      <th class="text-center" rowspan="2">Code Activity</th>
                      <th class="text-center" rowspan="2">Deliverables</th>
                      <th class="text-center" rowspan="2">activity</th>
                      <th class="text-center" rowspan="2">Year</th>
                      <th class="text-center" rowspan="2">Month</th>
                      <th colspan="3" class="text-center">Roles at Country Level (RACI)</th>
                      <th class="text-center" rowspan="2">Budget Estimaton</th> 
                      <th class="text-center" rowspan="2"></th>
                    </tr>
                    <tr>
                      <td class="text-center">Accountable (A)</td>
                      <td class="text-center">Consulted (C)</td>
                      <td class="text-center">Informed (I)</td>
                    </tr>';
            
             if($result->num_rows()>0)
                {
                    $no=1;
                    foreach ($result->result() as $row)
                    {
                        if(!empty($row->budget_estimaton))
                        {
                            echo '<tr>
                              <td class="text-center">'.$no++.'</td>
                              <td class="text-center">'.$row->kode_kegiatan.'</td>
                              <td class="text-center">'.$row->deliverables.'</td>
                              <td class="text-center">'.$row->activity.'</td>
                              <td class="text-center">'.$row->year.'</td>
                              <td class="text-center">'.month($row->month).'</td>
                              <td class="text-center">'.$row->accountable.'</td>
                              <td class="text-center">'.$row->consulted.'</td>
                              <td class="text-center">'.$row->informed.'</td>
                              <td class="text-center">'.desimal($row->budget_estimaton).'</td>  
                              <td class="text-center"> 
                              <a href="#" id="update_status" title="status update" data-id="'.$row->id.'" data-kodekegiatan="'.$row->kode_kegiatan.'" data-status="'.$row->status.'" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i></a>
                              </td>
                            </tr>';
                        }
                    }
                }
                else
                {
                    echo '<tr>
                      <td class="text-center" colspan="10"></td>
                      </td>
                      </tr>';
                }
                        
                  echo '</table>';
        }
        function set_session_kodekegiatan()
        {
            $kode_kegiatan = $this->input->post("kode_kegiatan");
           // $this->session->set_userdata('kode_kegiatan', $kode_kegiatan);
            $_SESSION['kode_kegiatan']=$kode_kegiatan;
            echo "s";
        }
        function tabel_detail_budget()
        {
            $sql = "select tb.* from tb_detail_monthly tb inner join tb_detail_budget td "
                    . "on tb.kode_kegiatan=td.kode_kegiatan order by year DESC,month ASC";
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
                    </tr>';
            
             if($result->num_rows()>0)
                {
                    $no=1;
                    foreach ($result->result() as $row)
                    {
                    echo '<tr>
                      <td class="text-center">'.$no++.'</td>
                      <td class="text-center">'.$row->kode_kegiatan.'</td>
                      <td class="text-center">'.$row->deliverables.'</td>
                      <td class="text-center">'.$row->activity.'</td>
                      <td class="text-center">'.$row->year.'</td>
                      <td class="text-center">'.month($row->month).'</td>
                      <td class="text-center">'.$row->accountable.'</td>
                      <td class="text-center">'.$row->consulted.'</td>
                      <td class="text-center">'.$row->informed.'</td>
                      <td class="text-center">'.$row->budget_estimaton.'</td>      
                    </tr>';
                    }
                }
                else
                {
                    echo '<tr>
                      <td class="text-center" colspan="10"></td>
                      </td>
                      </tr>';
                }
                        
                  echo '</table>';
        }
        function save()
        {
            $data['kode_kegiatan']=$this->input->post("kode_kegiatan");
            $data['activity']=$this->input->post("activity");
            $data['deliverables']=$this->input->post("deliverables");
            $data['year']=$this->input->post("year");
            $data['month']=$this->input->post("month");
            $data['accountable']=$this->input->post("accountable");
            $data['consulted']=$this->input->post("consulted");
            $data['informed']=$this->input->post("informed");
            $data['budget_estimaton']=$this->input->post("budget_estimaton");
            
            if(empty($data['kode_kegiatan']))
            {
                $err="Please insert code activity";
                $klas="#kode_kegiatan";
            }
            else if(empty($data['deliverables']))
            {
                $err="Please insert deliverables";
                $klas="#deliverables";
            }
            else if(empty($data['activity']))
            {
                $err="Please insert activity";
                $klas="#activity";
            }
                else {
                    $tabel = "tb_detail_monthly";
                    $result = $this->Model_lib->insert($tabel,$data);
                    $err="s";
                    $klas="-";

                }
                $arr = array ('err'=>$err,'klas'=>$klas);
                echo json_encode($arr);
        }
        function save_status_update()
        {
            $data['id']=$this->input->post("id_status_update");
            $data['status']=$this->input->post("status_update");
            $data['reason']=$this->input->post("reason");
            $data['kode_kegiatan']=$this->input->post("kode_kegiatan");
           if($data['status']=="3") {
            $data['month']=$this->input->post("month");
            }
            $tabel = "tb_detail_monthly";
                    $param = array
                                    (
                                      'id' => $data['id']
                                    );
                    
            if($data['status']=="1")
            {
                $this->db->query("delete from tb_purchase_header_activity where code_activity='". $data['kode_kegiatan']."'");
            }

            $result = $this->Model_lib->update($data,$tabel,$param);
            echo "s";
        }
         function proses_edit()
        {
            $data['id']=$this->input->post("id"); 
            $data['kode_kegiatan']=$this->input->post("kode_kegiatan");
            $data['activity']=$this->input->post("activity");
            $data['deliverables']=$this->input->post("deliverables");
            $data['year']=$this->input->post("year");
            $data['month']=$this->input->post("month");
            $data['accountable']=$this->input->post("accountable");
            $data['consulted']=$this->input->post("consulted");
            $data['informed']=$this->input->post("informed");
            $data['budget_estimaton']=$this->input->post("budget_estimaton");
            
            if(empty($data['kode_kegiatan']))
            {
                $err="Please insert code activity";
                $klas="#kode_kegiatan";
            }
            else if(empty($data['deliverables']))
            {
                $err="Please insert deliverables";
                $klas="#deliverables";
            }
            else if(empty($data['activity']))
            {
                $err="Please insert activity";
                $klas="#activity";
            }
                else {
                     $tabel = "tb_detail_monthly";
                    $param = array
                                    (
                                      'id' => $data['id']
                                    );

                    $result = $this->Model_lib->update($data,$tabel,$param);
                    $err="s";
                    $klas="-";

                }
                $arr = array ('err'=>$err,'klas'=>$klas);
                echo json_encode($arr);
        }
        function alasan()
        {
            $id = $this->input->post("id");
            $sql = "select*from tb_detail_monthly where id='".$id."'";
            $result = $this->Model_lib->SelectQuery($sql);
            if($result->num_rows()>0)
            {
                $r = $result->row();
                $reason = $r->reason;
            }
            else
            {
                $reason = "";
            }
            
            echo "REASON: <textarea rows=4 cols=50 id='reason' name='reason'>$reason</textarea>";
        }
        function postponse()
        {
            $id = $this->input->post("id");
            $sql = "select*from tb_detail_monthly where id='".$id."'";
            $result = $this->Model_lib->SelectQuery($sql);
            if($result->num_rows()>0)
            {
                $r = $result->row();
                $month = $r->month_postponse;
            }
            else
            {
                $month = "";
            }
              
            echo '<select class="form-control" id="month" name="month">';
                for($i=1;$i<=12;$i++)
                {
                    if($i==$month) 
                     {
                        echo '<option value="'.$i.'" selected>'.select_month($i).'</option>';
                     }
                     else
                     {
                        echo '<option value="'.$i.'">'.select_month($i).'</option>';
                     }
                }
            echo '</select>';
        }
       function delete()
        {
                $id = $this->input->post("id");

                $del = $this->db->query("delete from tb_detail_monthly where id='".$id."'");
                $err="s";
             
                $arr = array ('err'=>$err);
                echo json_encode($arr);
        }
        function get_file_extension($filename)
        {
            $lastDotPos = strrpos($filename, '.');
            if ( !$lastDotPos ) return false;
            return substr($filename, $lastDotPos+1);
        }
     
}