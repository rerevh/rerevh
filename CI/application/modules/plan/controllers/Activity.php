<?php if (!defined('BASEPATH')) die();

class Activity extends CI_Controller
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
        $this->load->view('v_activity.php');
        $this->load->view('intranet_includes/v_footer.php');
    }
    
    public function detail_budget()
    {
        $data['menu_titel'] = $this->menu_titel;
        $data['page_titel'] = $this->page_titel;

        $data['authen'] = $this->authenty->sess();

        $this->load->view('intranet_includes/v_header.php', $data);
        $this->load->view('v_activity.php');
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
            $exp = "uploadexcel";
            $nama_file = $exp;

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '5000000'; // max file yang boleh di upload 1 MB
            $config['file_name'] = $nama_file . "." . strtolower($fileExt);
            $config['overwrite'] = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {
                $path = './uploads/uploadexcel.xlsx';
                if (file_exists($path)) {
                    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                    $excelreader = new PHPExcel_Reader_Excel2007();
                    $loadexcel = $excelreader->load('./uploads/uploadexcel.xlsx'); // Load file yang telah diupload ke folder excel
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    //$sudah = false;
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    foreach ($sheet as $row) {
                        // Cek $numrow apakah lebih dari 1
                        // Artinya karena baris pertama adalah nama-nama kolom
                        // Jadi dilewat saja, tidak usah diimport
                        if ($numrow > 1) {
                            // Kita push (add) array data ke variabel data
                            $data['kode_kegiatan'] = $row['A'];
                            $data['activity'] = $row['B'];
                            $data['team'] = $row['C'];
                            $data['total_usd'] = str_replace(".", "", $row['D']);
                            $data['total_idr'] = str_replace(".", "", $row['E']);
                            $data['time_per_year'] = str_replace(".", "", $row['F']);
                            $data['estimate_per_activity'] = str_replace(".", "", $row['G']);
                            $data['participants'] = str_replace(".", "",  $row['H']);
                            $data['daystimes'] =  str_replace(".", "",  $row['I']);
                            $data['meals'] = str_replace(".", "",  $row['J']);
                            $data['airfare'] = str_replace(".", "",  $row['K']);
                            $data['local_transport'] = str_replace(".", "",  $row['L']);
                            $data['mie'] = str_replace(".", "",  $row['M']);
                            $data['meeting_package'] =  str_replace(".", "",  $row['N']);
                            $data['printing'] = str_replace(".", "",  $row['O']);
                            $data['facilitator_fee'] = str_replace(".", "",  $row['P']);
                            $data['miscellaneous'] = str_replace(".", "",  $row['Q']);

                            $result = $this->Model_lib->insert("tb_detail_budget", $data);
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
    
    public function simpan()
    {
        $file_cek = $this->input->post("file");

        if ($file_cek == 'undefined') {
            $err = "Masukkan file yang akan diupload";
            $klas = "#file";
        } else {
            $file = $_FILES['file']['name'];
            $fileExt = $this->get_file_extension($_FILES['file']['name']);
            $exp = "uploadexcel";
            $nama_file = $exp;

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '5000000'; // max file yang boleh di upload 1 MB
            $config['file_name'] = $nama_file . "." . strtolower($fileExt);
            $config['overwrite'] = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {
                $path = './uploads/uploadexcel.xlsx';
                if (file_exists($path)) {
                    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                    $excelreader = new PHPExcel_Reader_Excel2007();
                    $loadexcel = $excelreader->load('./uploads/uploadexcel.xlsx'); // Load file yang telah diupload ke folder excel
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    //$sudah = false;
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    foreach ($sheet as $row) {
                        // Cek $numrow apakah lebih dari 1
                        // Artinya karena baris pertama adalah nama-nama kolom
                        // Jadi dilewat saja, tidak usah diimport
                        if ($numrow > 1) {
                            // Kita push (add) array data ke variabel data
                            $data['kode_kegiatan'] = $row['A'];
                            $data['activity'] = $row['B'];
                            $data['team'] = $row['C'];
                            $data['total_usd'] = str_replace(".", "", $row['D']);
                            $data['total_idr'] = str_replace(".", "", $row['E']);
                            $data['time_per_year'] = str_replace(".", "", $row['F']);
                            $data['estimate_per_activity'] = str_replace(".", "", $row['G']);
                            $data['participants'] = str_replace(".", "",  $row['H']);
                            $data['daystimes'] =  str_replace(".", "",  $row['I']);
                            $data['meals'] = str_replace(".", "",  $row['J']);
                            $data['airfare'] = str_replace(".", "",  $row['K']);
                            $data['local_transport'] = str_replace(".", "",  $row['L']);
                            $data['mie'] = str_replace(".", "",  $row['M']);
                            $data['meeting_package'] =  str_replace(".", "",  $row['N']);
                            $data['printing'] = str_replace(".", "",  $row['O']);
                            $data['facilitator_fee'] = str_replace(".", "",  $row['P']);
                            $data['miscellaneous'] = str_replace(".", "",  $row['Q']);

                            $result = $this->Model_lib->insert("tb_detail_budget", $data);
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

    function tabel()
    {
        $sql = "select*from tb_detail_budget";
        $result = $this->Model_lib->SelectQuery($sql);

        echo '<table class="table table-bordered table-striped mb-none">
                        <thead>
                                <tr>
                                        <th class="text-center">NO.</th>
                                        <th class="text-center">Kode Activity</th>
                                        <th class="text-center">Activity</th>
                                        <th class="text-center">Team</th>
                                        <th class="text-center">Total USD</th>
                                        <th class="text-center">Total IDR</th>
                                        <th class="text-center">Times Per Year</th>
                                        <th class="text-center">Estimate Per Activity</th>
                                        <th class="text-center">Participants</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-center">Meals</th>
                                        <th class="text-center">Airfare</th>
                                        <th class="text-center">Local Transport</th>
                                        <th class="text-center">M&IE</th>
                                        <th class="text-center">Meeting Package</th>
                                        <th class="text-center">Printing</th>
                                        <th class="text-center">Facilitator Fee</th>
                                        <th class="text-center">Miscellaneous</th>
                                        <th class="text-center">Actions</th>
                                </tr>
                        </thead>
                        <tbody>';
        if ($result->num_rows() > 0) {
            $no = 1;
            foreach ($result->result() as $row) {
                echo '<tr>
                                                <td>' . $no++ . '</td>
                                                <td class="text-center">' . $row->kode_kegiatan . '</td>
                                                <td>' . $row->activity . '</td>
                                                <td>' . $row->team . '</td>
                                                <td class="text-center">' . desimal($row->total_usd) . '</td>
                                                <td class="text-center">' . desimal($row->total_idr) . '</td>
                                                <td class="text-center">' . desimal($row->time_per_year) . '</td>
                                                <td class="text-center">' . desimal($row->estimate_per_activity) . '</td>
                                                <td class="text-center">' . desimal($row->participants) . '</td>
                                                <td class="text-center">' . desimal($row->daystimes) . '</td>
                                                <td class="text-center">' . desimal($row->meals) . '</td>
                                                <td class="text-center">' . desimal($row->airfare) . '</td>
                                                <td class="text-center">' . desimal($row->local_transport) . '</td>
                                                <td class="text-center">' . desimal($row->mie) . '</td>
                                                <td class="text-center">' . desimal($row->meeting_package) . '</td>
                                                <td class="text-center">' . desimal($row->printing) . '</td>
                                                <td class="text-center">' . desimal($row->facilitator_fee) . '</td>
                                                <td class="text-center">' . desimal($row->miscellaneous) . '</td>
                                                <td class="text-center">
                                                    <a href="#" id="edit" title="Edit Row" data-id="' . $row->id . '"><i class="fa fa-pencil"></i></a>
                                                    <a href="#" id="delete" title="Delete Row" data-id="' . $row->id . '"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                        </tr>';
            }
        } else {
            echo '<tr><td colspan="18"></td></tr>';
        }
        echo '</tbody>
            </table>';
    }
    function form()
    {
        $id = $this->input->post("id");
        $kode_kegiatan_ouput = $this->input->post("kode_kegiatan");
        if (!empty($id)) {
            $sql = "select*from tb_detail_budget where kode_kegiatan='" . $kode_kegiatan_ouput . "'";
            $result = $this->Model_lib->SelectQuery($sql);
            if ($result->num_rows() > 0) {
                foreach ($result->result() as $row) {
                    $kode_kegiatan = $row->kode_kegiatan;
                    $activity = $row->activity;
                    $team = $row->team;
                    $total_usd = $row->total_usd;
                    $total_idr = $row->total_idr;
                    $time_per_year = $row->time_per_year;
                    $estimate_per_activity = $row->estimate_per_activity;
                    $participants = $row->participants;
                    $daystimes = $row->daystimes;
                    $meals = $row->meals;
                    $airfare = $row->airfare;
                    $local_transport = $row->local_transport;
                    $mie = $row->mie;
                    $meeting_package = $row->meeting_package;
                    $printing = $row->printing;
                    $facilitator_fee = $row->facilitator_fee;
                    $miscellaneous = $row->miscellaneous;
                    $url = "proses_edit";
                }
            } else {
                $kode_kegiatan = "";
                $activity = "";
                $team = "";
                $total_usd = 0;
                $total_idr = 0;
                $time_per_year = 0;
                $estimate_per_activity = 0;
                $participants = 0;
                $daystimes = 0;
                $meals = 0;
                $airfare = 0;
                $local_transport = 0;
                $mie = 0;
                $meeting_package = 0;
                $printing = 0;
                $facilitator_fee = 0;
                $miscellaneous = 0;
                $url = "save";
            }
        } else {
            $kode_kegiatan = "";
            $activity = "";
            $team = "";
            $total_usd = 0;
            $total_idr = 0;
            $time_per_year = 0;
            $estimate_per_activity = 0;
            $participants = 0;
            $daystimes = 0;
            $meals = 0;
            $airfare = 0;
            $local_transport = 0;
            $mie = 0;
            $meeting_package = 0;
            $printing = 0;
            $facilitator_fee = 0;
            $miscellaneous = 0;
            $url = "save";
        }
        echo '<div class="row"><form id="submit" class="form-horizontal">';
        echo '<div class="col-md-6">';
        echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Code Activity</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="kode_kegiatan" name="kode_kegiatan" value="' . $kode_kegiatan_ouput . '" readonly>
                                  <input type="hidden" class="form-control" id="id" name="id" value="' . $id . '">
                                </div>
                              </div>';
        //                            echo '<div class="form-group">
        //                                <label for="inputEmail3" class="col-sm-3 control-label">Activity</label>
        //                                <div class="col-sm-6">
        //                                  <input type="text" class="form-control" id="activity" name="activity" value="'.$activity.'">
        //                                </div>
        //                              </div>';
        echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Team</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="team" name="team" value="' . $team . '">
                                </div>
                              </div>';
        echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Total USD</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="total_usd" name="total_usd" value="' . $total_usd . '" onkeypress="return checkIt(event);" value="0">
                                </div>
                              </div>';
        echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Total IDR</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="total_idr" name="total_idr" value="' . $total_idr . '" onkeypress="return checkIt(event);" value="0">
                                </div>
                              </div>';
        echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Times Per Year</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="time_per_year" name="time_per_year" value="' . $time_per_year . '" onkeypress="return checkIt(event);" value="0">
                                </div>
                              </div>';
        echo '<div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Estimate Per Activity</label>
                                <div class="col-sm-6">
                                  <input type="text" class="form-control" id="estimate_per_activity" value="' . $estimate_per_activity . '" name="estimate_per_activity" onkeypress="return checkIt(event);" value="0">
                                </div>
                              </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Participants</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="participants" value="' . $participants . '" name="participants" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Days</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="daystimes" value="' . $daystimes . '" name="daystimes" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '</div>';
        echo '<div class="col-md-6">';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Meals</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="meals" value="' . $meals . '" name="meals" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Airfare</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="airfare" value="' . $airfare . '" name="airfare" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Local Transport	</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="local_transport" value="' . $local_transport . '" name="local_transport" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">M&IE</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="mie" name="mie" value="' . $mie . '" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Meeting Package</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="meeting_package" value="' . $meeting_package . '" name="meeting_package" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Printing</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="printing" value="' . $printing . '" name="printing" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Facilitator Fee</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="facilitator_fee" value="' . $facilitator_fee . '" name="facilitator_fee" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '<div class="form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Miscellaneous</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="miscellaneous" value="' . $miscellaneous . '" name="miscellaneous" onkeypress="return checkIt(event);" value="0">
            </div>
        </div>';
        echo '</div>';
        echo '<div class="col-md-12"><button type="button" class="btn btn-default ' . $url . '">Save</button></div>';
        echo '</form></div>';
    }

    function save()
    {
        $data['kode_kegiatan'] = $this->input->post("kode_kegiatan");
        $data['team'] = $this->input->post("team");
        $data['total_usd'] = $this->input->post("total_usd");
        $data['total_idr'] = $this->input->post("total_idr");
        $data['time_per_year'] = $this->input->post("time_per_year");
        $data['estimate_per_activity'] = $this->input->post("estimate_per_activity");
        $data['participants'] = $this->input->post("participants");
        $data['daystimes'] = $this->input->post("daystimes");
        $data['meals'] = $this->input->post("meals");
        $data['airfare'] = $this->input->post("airfare");
        $data['local_transport'] = $this->input->post("local_transport");
        $data['mie'] = $this->input->post("mie");
        $data['meeting_package'] = $this->input->post("meeting_package");
        $data['printing'] = $this->input->post("printing");
        $data['facilitator_fee'] = $this->input->post("facilitator_fee");
        $data['miscellaneous'] = $this->input->post("miscellaneous");
        if (empty($data['kode_kegiatan'])) {
            $err = "Please insert code activity";
            $klas = "#kode_kegiatan";
        } else {
            $tabel = "tb_detail_budget";
            $result = $this->Model_lib->insert($tabel, $data);
            $err = "s";
            $klas = "-";
        }
        $arr = array('err' => $err, 'klas' => $klas);
        echo json_encode($arr);
    }

    function proses_edit()
    {
        $data['id'] = $this->input->post("id");
        $data['id2'] = $this->input->post("id2");
        $data['kode_kegiatan'] = $this->input->post("kode_kegiatan");
        $data['activity'] = $this->input->post("activity");
        $data['team'] = $this->input->post("team");

        $data['local_transport'] = $this->input->post("local_transport");
        $data['mie'] = $this->input->post("mie");
        $data['meeting_package'] = $this->input->post("meeting_package");
        $data['printing'] = $this->input->post("printing");
        $data['facilitator_fee'] = $this->input->post("facilitator_fee");
        $data['miscellaneous'] = $this->input->post("miscellaneous");
        
        $data['total_usd'] = $this->input->post("total_usd");
        $data['total_idr'] = $this->input->post("total_idr");        
        if (empty($data['kode_kegiatan'])) {
            $err = "Please insert code activity";
            $klas = "#kode_kegiatan";
        } else {
            $tabel = "tb_detail_budget";
            $param = array(
                'kode_kegiatan' => $data['kode_kegiatan']
            );

            $result = $this->Model_lib->update($data, $tabel, $param);
            $err = "s";
            $klas = "-";
        }
        //modified
        $arr = array('err' => $err, 'klas' => $klas);
        echo json_encode($arr);
    }

    function delete()
    {
        $id = $this->input->post("id");

        $del = $this->db->query("delete from tb_detail_budget where id='" . $id . "'");
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
    
    
    public function simpan_1()
    {
        $file_cek = $this->input->post("file");

        if ($file_cek == 'undefined') {
            $err = "Masukkan file yang akan diupload";
            $klas = "#file";
        } else {
            $file = $_FILES['file']['name'];
            $fileExt = $this->get_file_extension($_FILES['file']['name']);
            $exp = "uploadexcel";
            $nama_file = $exp;

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '5000000'; // max file yang boleh di upload 1 MB
            $config['file_name'] = $nama_file . "." . strtolower($fileExt);
            $config['overwrite'] = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {
                $path = './uploads/uploadexcel.xlsx';
                if (file_exists($path)) {
                    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                    $excelreader = new PHPExcel_Reader_Excel2007();
                    $loadexcel = $excelreader->load('./uploads/uploadexcel.xlsx'); // Load file yang telah diupload ke folder excel
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    //$sudah = false;
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    foreach ($sheet as $row) {
                        // Cek $numrow apakah lebih dari 1
                        // Artinya karena baris pertama adalah nama-nama kolom
                        // Jadi dilewat saja, tidak usah diimport
                        if ($numrow > 1) {
                            // Kita push (add) array data ke variabel data
                            $data['kode_kegiatan'] = $row['A'];
                            $data['activity'] = $row['B'];
                            $data['team'] = $row['C'];
                            $data['total_usd'] = str_replace(".", "", $row['D']);
                            $data['total_idr'] = str_replace(".", "", $row['E']);
                            $data['time_per_year'] = str_replace(".", "", $row['F']);
                            $data['estimate_per_activity'] = str_replace(".", "", $row['G']);
                            $data['participants'] = str_replace(".", "",  $row['H']);
                            $data['daystimes'] =  str_replace(".", "",  $row['I']);
                            $data['meals'] = str_replace(".", "",  $row['J']);
                            $data['airfare'] = str_replace(".", "",  $row['K']);
                            $data['local_transport'] = str_replace(".", "",  $row['L']);
                            $data['mie'] = str_replace(".", "",  $row['M']);
                            $data['meeting_package'] =  str_replace(".", "",  $row['N']);
                            $data['printing'] = str_replace(".", "",  $row['O']);
                            $data['facilitator_fee'] = str_replace(".", "",  $row['P']);
                            $data['miscellaneous'] = str_replace(".", "",  $row['Q']);

                            $result = $this->Model_lib->insert("tb_detail_budget", $data);
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
    
    public function simpan_2()
    {
        $file_cek = $this->input->post("file");

        if ($file_cek == 'undefined') {
            $err = "Masukkan file yang akan diupload";
            $klas = "#file";
        } else {
            $file = $_FILES['file']['name'];
            $fileExt = $this->get_file_extension($_FILES['file']['name']);
            $exp = "uploadexcel";
            $nama_file = $exp;

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '5000000'; // max file yang boleh di upload 1 MB
            $config['file_name'] = $nama_file . "." . strtolower($fileExt);
            $config['overwrite'] = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file')) {
                $path = './uploads/uploadexcel.xlsx';
                if (file_exists($path)) {
                    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

                    $excelreader = new PHPExcel_Reader_Excel2007();
                    $loadexcel = $excelreader->load('./uploads/uploadexcel.xlsx'); // Load file yang telah diupload ke folder excel
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    //$sudah = false;
                    $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

                    $numrow = 1;
                    foreach ($sheet as $row) {
                        // Cek $numrow apakah lebih dari 1
                        // Artinya karena baris pertama adalah nama-nama kolom
                        // Jadi dilewat saja, tidak usah diimport
                        if ($numrow > 1) {
                            // Kita push (add) array data ke variabel data
                            $data['kode_kegiatan'] = $row['A'];
                            $data['activity'] = $row['B'];
                            $data['team'] = $row['C'];
                            $data['total_usd'] = str_replace(".", "", $row['D']);
                            $data['total_idr'] = str_replace(".", "", $row['E']);
                            $data['time_per_year'] = str_replace(".", "", $row['F']);
                            $data['estimate_per_activity'] = str_replace(".", "", $row['G']);
                            $data['participants'] = str_replace(".", "",  $row['H']);
                            $data['daystimes'] =  str_replace(".", "",  $row['I']);
                            $data['meals'] = str_replace(".", "",  $row['J']);
                            $data['airfare'] = str_replace(".", "",  $row['K']);
                            $data['local_transport'] = str_replace(".", "",  $row['L']);
                            $data['mie'] = str_replace(".", "",  $row['M']);
                            $data['meeting_package'] =  str_replace(".", "",  $row['N']);
                            $data['printing'] = str_replace(".", "",  $row['O']);
                            $data['facilitator_fee'] = str_replace(".", "",  $row['P']);
                            $data['miscellaneous'] = str_replace(".", "",  $row['Q']);

                            $result = $this->Model_lib->insert("tb_detail_budget", $data);
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
}
