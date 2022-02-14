<?php if (!defined('BASEPATH')) die();

class Work_plan extends CI_Controller
{

    private $limit = 20;
    private $site_id = '';
    private $menu_titel = 'Settings';
    private $page_titel = 'Projects';

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Model_lib');
        if (!$this->authenty->check_editor()) {
            redirect(base_url() . 'Logout');
        }
    }

    public function index()
    {
        $data['menu_titel'] = $this->menu_titel;
        $data['page_titel'] = $this->page_titel;

        $data['authen'] = $this->authenty->sess();

        $this->load->view('intranet_includes/v_header.php', $data);
        $this->load->view('v_work_plan.php');
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
                            $data['year'] = $row['D'];
                            $data['month'] = $row['E'];
                            $data['accountable'] = $row['F'];
                            $data['consulted'] = $row['G'];
                            $data['informed'] = $row['H'];
                            $data['budget_estimaton'] = $row['I'];
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
    function filter()
    {
        echo '<div class="col-sm-12">';
        echo '<div class="col-sm-1">Filter Year</div>';
        echo '<div class="col-sm-2"><select class="form-control" id="filter_year">';
        echo '<option value="0" >Select Year</option>';
        $year = date("Y") + 1;
        $prev = $year - 5;
        for ($i = $year; $i >= $prev; $i--) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '</div>';
        echo "<br><br>";
        echo '<div class="col-sm-12">';
        echo '<div class="col-sm-1">Filter locations</div>';
        echo '<div class="col-sm-2"><select class="form-control" id="filter_lokasi">';
        select_location("");
        echo '</select>';
        echo '</div>';
        echo '</div>';
        echo "<br><br>";
        echo '<div class="col-sm-12">';
        echo '<div class="col-sm-1">Filter Group</div>';
        echo '<div class="col-sm-2"><select class="form-control" id="filter_group">';
        echo  '<option value="">Select Group</option>';
        echo  '<option value="901">The First 90 group</option>';
        echo  '<option value="902">The scond 90 group</option>';
        echo  '<option value="903">The third 90 group</option>';
        echo  '<option value="904">The fourt 90 group</option>';
        echo '</select>';
        echo '</div>';
        echo '</div>';
    }
    function tabel()
    {
        // $param = $this->input->post("param");
        $year = $this->input->post("year");
        $lokasi = $this->input->post("lokasi");
        $group = $this->input->post("group");

        $join = 'left join tb_userapp re on re.username = dm.create_by
            left join tb_mini_proposal_new pn on pn.code_activity = dm.kode_kegiatan
            left join tb_userapp inf on inf.email = pn.submitto and inf.is_tor_approver = 1';

        if (!empty($year) && !empty($lokasi) && !empty($group)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where dm.year='" . $year . "' "
                . "and dm.project_location='" . $lokasi . "' and dm.code_group>='" . $group . "' order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else if (!empty($year) && !empty($group)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where dm.year='" . $year . "' "
                . " and dm.code_group='" . $group . "' order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else if (!empty($lokasi) && !empty($group)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where  dm.project_location='" . $lokasi . "' and dm.code_group>='" . $group . "' order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else if (!empty($year) && !empty($lokasi)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where dm.year='" . $year . "' "
                . "and dm.project_location='" . $lokasi . "'  order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else if (!empty($lokasi)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where dm.project_location='" . $lokasi . "' order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else if (!empty($year)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where dm.year='" . $year . "' order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else if (!empty($group)) {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join." where dm.code_group>='" . $group . "' order by dm.code_result,dm.code_group,dm.code_deliverables";
        } else {
            $sql = "select dm.*, re.username as _accountable, inf.username as _consulted from tb_detail_monthly dm ".$join."";
        }

        $result = $this->Model_lib->SelectQuery($sql);

        echo '<table class="table table-bordered table-striped mb-none">
                    <tr>
                      <th class="text-center">No</th>
                      <th class="text-center">Code Activity</th>
                      <th class="text-center">Activity</th>
                      <th class="text-center">Month</th>
                      <th class="text-center">Budget Estimaton</th>
                      <th colspan="3" class="text-center">Roles at Country Level (RACI)</th>
                    </tr>
                    <tr>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center"></td>
                      <td class="text-center">Accountable (A)</td>
                      <td class="text-center">Consulted (C)</td>
                      <td class="text-center">Informed (I)</td>
                    </tr>';

        if ($result->num_rows() > 0) {
            $no = 1;
            $i = 1;
            $temp = "";
            foreach ($result->result() as $row) {
                $filter = $row->code_result;
                if ($temp != $filter) {
                    echo '<tr><td colspan="8">Results Area ' . $i++ . '</td></tr>';
                }

                if (!empty($row->budget_estimaton)) {
                    $budget_estimaton = $row->budget_estimaton;
                } else {
                    $budget_estimaton = 0;
                }
                echo '<tr>
                              <td class="text-center">' . $no++ . '</td>
                              <td class="text-center"><span class="label label-success code-activity">' . $row->kode_kegiatan . '</span></td>
                              <td class="text-center">' . $row->activity . '</td>  
                              <td class="text-center">' . month($row->month) . '</td>
                              <td class="text-center">' . desimal($budget_estimaton) . '</td>     
                              <td class="text-center">' . $row->_accountable . '</td>
                              <td class="text-center">' . $row->_consulted . '</td>
                              <td class="text-center">' . $row->informed . '</td> 
                            </tr>';
                $temp = $row->code_result;
            }
        } else {
            echo '<tr>
                      <td class="text-center" colspan="11"></td>
                      </td>
                      </tr>';
        }

        echo '</table>';
    }
    function get_file_extension($filename)
    {
        $lastDotPos = strrpos($filename, '.');
        if (!$lastDotPos) return false;
        return substr($filename, $lastDotPos + 1);
    }
}
