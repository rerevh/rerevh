<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . 'libraries/REST_Controller.php';
require_once("Main.php");

class career extends REST_Controller
{
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        parent::__construct();

        if (isset($_GET['token'])) {
            $data = main::isTokenExpired($_GET['token']);
            if ($data) {
                $this->clientAPP = $data[0]->app;
                $this->clientID = $data[0]->user_id;
                $this->clientGrp = $data[0]->usergrp_id;
                $this->userGrp = $data[0]->usergrp_name;
                if ($data[0]->user_id != 'kacang') {
                    if ($data[0]->menit > 120) {
                        $response['error'] = true;
                        $response['status'] = http_response_code();
                        $response['message'] = 'Token expired!';
                        $this->response($response);
                        die();
                    }
                }
            } else {
                $response['error'] = true;
                $response['status'] = http_response_code();
                $response['message'] = 'Token is not accepted!';
                $this->response($response);
                die();
            }
        } else {
            $response['error'] = true;
            $response['status'] = http_response_code();
            $response['message'] = 'Token is required!';
            $this->response($response);
            die();
        };
    }

    public function index_get()
    {
        $response['status'] = http_response_code();
        $response['error'] = false;
        $response['message'] = 'You are accessing API';
        $this->response($response);
    }

    //Start Rere
    function compmatrix_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $matrix = explode('_',$data['key']);
        $where = '(special="'.$data['matrix_type'].'" AND from_subskill_id="'.$matrix[0].'" AND to_subskill_id="'.$matrix[1].'")';
        echo $where;
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if (($keys[$i] == 'form_method') || ($keys[$i] == 'key') || ($keys[$i] == 'matrix_type')) {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where($where)
            ->update('compatibility_matrix', $data);
        if (!$res) {
            $errormsg = 'update compatibility_matrix ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === TRUE) {
                $errormsg = 'compatibility_matrix data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function get_jobiinfo($id) {
        $this->db->select('a.job_id, a.job_name, b.grade as job_grade, b.jobgrade as alnum_job_grade, c.skill_name as job_skill');
        $this->db->from('ref_job AS a');
        $this->db->join('ref_grade AS b', 'a.grade_id = b.grade_id', 'left');
        $this->db->join('vw_skill_job AS c', 'a.job_id = c.job_id', 'left');
        $this->db->where('a.job_id',$id);
        $query=$this->db->get();
        return $query->row_array();
    }

    function get_esselon($grade,$gap) {
        $this->db->select('jobgroup');
        $this->db->from('ref_grade');
        $this->db->where('grade',$grade);
        $query=$this->db->get();

        $this->db->select('grade');
        $this->db->from('ref_grade');
        $this->db->where('jobgroup',$query->row_array()['jobgroup']+0);
        $this->db->or_where('jobgroup',($gap == 'target') ? $query->row_array()['jobgroup']-1 : $query->row_array()['jobgroup']+1);
        $query2=$this->db->get();

        $i=0;
        $esselon_grade = '(';
        foreach ($query2->result_array() as $row) {
            $i++;
            $esselon_grade .= $row['grade'].',';
        }
        return substr($esselon_grade,0,strlen($esselon_grade)-1).')' ;
    }

    function get_incumbent($id,$type) {
        $this->db->select('a.person_name, a.person_number as person_nip, f.grade as person_grade, 
                           d.skill_name as person_skill, a.job_id, b.job_name, c.grade as job_grade, 
                           c.jobgrade as alnum_job_grade, e.skill_name as job_skill');
        $this->db->from('person AS a');
        $this->db->join('ref_job AS b', 'a.job_id = b.job_id', 'left');
        $this->db->join('ref_grade AS c', 'b.grade_id = c.grade_id', 'left');
        $this->db->join('vw_skill_person AS d', 'a.person_id = d.person_id', 'left');
        $this->db->join('vw_skill_job AS e', 'a.job_id = e.job_id', 'left');
        $this->db->join('ref_grade AS f', 'a.grade_id = f.grade_id', 'left');
        if ($type == 'person') {
            $this->db->where('a.person_id',$id);
            $query=$this->db->get();
            return $query->row_array();
        } else {
            $this->db->where('a.job_id',$id);
            $query=$this->db->get();
            return $query->result_array();
        }


    }

    function qu_compability($sgWhere,$findtype) {
        $this->db->select('skill_name, grade');
        $this->db->from('vw_skill_grade_'.$findtype);
        $this->db->where($sgWhere);
        $this->db->order_by('skill_name, grade');
        $query=$this->db->get();
        return   $query->num_rows() ;
    }

    function checkSg_compability($sg,$jg,$pg,$incl,$gtype,$findtype) {
        $sglist     = explode("|",$sg);
        $warningtxt = '';
        $warning    = false;
        for ($x = 0; $x <= count($sglist)-1; $x++) {
            $xc = '';
            $xc2 = '';
            $i=0;
            $start = (($gtype == 'feed') ? ((int)$jg-(int)$pg) : (  ($incl!=0) ?  ((int)$jg) : ((int)$jg+1) ));
            $gradeloop = $pg;
            for ( $y=$start; (($gtype == 'feed') ? ((($incl!=0) ? ($y <= (int)$jg) : ($y < (int)$jg))) :( $y<=(int)$jg+(int)$pg)); $y++) {
                $i++;
                $yg = ($gtype == 'feed') ? (($incl!=0) ? ($y+($gradeloop - $i)+1) : ($y+($gradeloop - $i))) : $y;
                $sgWhere = '(skill_name="'.trim($sglist[$x]).'") AND (grade='.$yg.')';

                if ($this->qu_compability($sgWhere,$findtype) != 0) {
                    $c = (($gtype == 'feed') ? (int)$jg-(int)$pg:(int)$jg+(int)$pg);

                    if ($c == $y) {
                        $warningtxt = trim($sglist[$x]).' is available';
                        $warning    = false;
                    } else {
                        $warningtxt = 'No match data for skill group '.trim($sglist[$x]).' in this processing. try to '.(($gtype == 'feed') ? 'decrease feeder':'inrease target').' grade to '.(($gtype == 'feed') ? ((int)$jg-(int)$yg):((int)$yg-(int)$jg) ).' level to get another result.';
                        $warning    = true;
                    }
                    break;
                }	else {
                    $warningtxt = 'No available data for skill group '.trim($sglist[$x]);
                    $warning    = true;

                    for ( (($gtype == 'feed') ? ($z =(int)$jg-3) : (  ($incl!=0) ?  ($z = (int)$jg) : ($z = (int)$jg+1) ));  (($gtype == 'feed') ? ((($incl!=0) ? ($z <= ((int)$jg)) : ($z < ((int)$jg)))) :( $z <=(int)$jg+3)); $z++) {
                        $zg = ($gtype == 'feed') ? (($incl!=0) ? ((int)$jg-(((int)$z+3)-(int)$jg)) : ((int)$jg-(((int)$z+4)-(int)$jg))) : $z;
                        $sgWhere2 = '(skill_name="'.trim($sglist[$x]).'") AND (grade='.$zg.')';

                        if ($this->qu_compability($sgWhere2,$findtype) != 0) {
                            $d = (($gtype == 'feed') ? (int)$jg-(int)$pg:(int)$jg+(int)$pg);
                            if ($d == $z) {
                                $warningtxt = trim($sglist[$x]).' is available';
                                $warning    = false;
                            } else {
                                $warningtxt = 'No match data for skill group '.trim($sglist[$x]).' in this processing. try to '.(($gtype == 'feed') ? 'decrease feeder':'inrease target').' grade to '.(($gtype == 'feed') ? ((int)$jg-(int)$zg):((int)$zg-(int)$jg) ).' level to get another result';
                                $warning    = true;
                            }
                            break;
                        }	else {
                            $warningtxt = 'No available data for skill group '.trim($sglist[$x]).' in this processing.';
                            $warning    = true;
                        }
                    }
                }
                $gradeloop = $gradeloop-1;
            }
        }
        $response['message'] = $warningtxt;
        $response['warning'] = $warning;
        return $response;
    }

    function findjob_get(){
        if (isset($_GET['q'])) {
            if (!empty($_GET['q'])) {
                $data = $_GET['q'];

                //$keys  = array_keys($data);
                //$arraySize = count($data);
                //  for( $i=0; $i < $arraySize; $i++ ) {
                //      echo 'Key :' . $keys[$i] . ' --->' . $data[$keys[$i]]."<br>" ;
                //}   ;die();

                if ( $data['method_selected'] == '0') {
                    //Find Job Process
                    $job_id = explode("_",$data['job_id'])[0];
                    $grade  = explode("_",$data['job_id'])[1];
                    $person_grade  = explode("_",$data['job_id'])[1];
                    $i =0;
                    foreach ($this->get_incumbent($job_id,'job') as $row) {
                        $i++;
                        $respx['find']['person_name']  = $row['person_name'];
                        $respx['find']['person_nip']   = $row['person_nip'];
                        $respx['find']['person_grade'] = $row['person_grade'];
                        $respx['find']['person_skill'] = $row['person_skill'];

                        $respx['find']['job_name']  = $row['job_name'];
                        $respx['find']['job_grade'] = $row['alnum_job_grade'];
                        $respx['find']['job_skill'] = $row['job_skill'];
                        $respx['find']['job_loc']   = '**';
                    }
                    if ($i != 1) {
                        $respx['find']['job_name']  = $this->get_jobiinfo($job_id)['job_name'];
                        $respx['find']['job_grade'] = $this->get_jobiinfo($job_id)['alnum_job_grade'];
                        $respx['find']['job_skill'] = $this->get_jobiinfo($job_id)['job_skill'];
                        $respx['find']['job_loc']  = '**';

                        $respx['find']['person_name']  = $i.' person in this position';
                        $respx['find']['person_grade'] = '**';
                        $respx['find']['person_skill'] = '**';
                        $respx['find']['person_nip']   = '**';
                    }
                } else {
                    //Find Person Process

                    $person_id = explode("_",$data['employee_id'])[0];
                    $job_id    = $this->get_incumbent($person_id,'person')['job_id'];
                    //$grade     = ($this->get_incumbent($person_id,'person')['job_grade'] != '') ? $this->get_incumbent($person_id,'person')['person_grade'] : 0;
                    $grade     = ($this->get_incumbent($person_id,'person')['job_grade'] != '') ? $this->get_incumbent($person_id,'person')['job_grade'] : $this->get_incumbent($person_id,'person')['person_grade'];
                    $person_grade     = ($this->get_incumbent($person_id,'person')['person_grade'] != '') ? $this->get_incumbent($person_id,'person')['person_grade'] : $this->get_incumbent($person_id,'person')['job_grade'];


                    $respx['find']['person_name']  = $this->get_incumbent($person_id,'person')['person_name'];
                    $respx['find']['person_grade'] = $this->get_incumbent($person_id,'person')['person_grade'];
                    $respx['find']['person_skill'] = $this->get_incumbent($person_id,'person')['person_skill'];
                    $respx['find']['person_nip']   = $this->get_incumbent($person_id,'person')['person_nip'];

                    $respx['find']['job_name']     = $this->get_incumbent($person_id,'person')['job_name'];
                    $respx['find']['job_grade']    = $this->get_incumbent($person_id,'person')['alnum_job_grade'];
                    $respx['find']['job_skill']    = $this->get_incumbent($person_id,'person')['job_skill'];
                    $respx['find']['job_loc']      = '**';
                }
                $tmt_grade = ($data['tmt_grade'] != '0') ? ' AND (tmt >= '.$data['tmt_grade'].')' : '';
                $performance_comp = explode("|",$data['performance_level'] );
                $performance_level = '';
                if ($data['performance_level'] != '-') {
                    for( $i=0; $i < count($performance_comp); $i++ ) {
                        $performance_level .= 'performance_level='.$performance_comp[$i]. ' or ';
                    };
                    $performance_level = ' AND ('.substr($performance_level,0,strlen($performance_level)-4).')';
                }

                $assessment_comp = explode("|",$data['assessment'] );
                $assessment = '';
                if ($data['assessment'] != '-') {
                    for( $i=0; $i < count($assessment_comp); $i++ ) {
                        $assessment .= 'assessment_level='.$assessment_comp[$i]. ' or ';
                    };
                    $assessment = ' AND (('.substr($assessment,0,strlen($assessment)-4).')  OR (special_case=1))';
                }

                $percent_compability ='';
                $percent_compability = $data['percent_compability'];
                switch (true) {
                    case ($_GET['r'] == 'j2jtarget'):
                        if ( $data['size_method_selected'] == '1') {
                            $whereGrade = 'job_grade in '.$this->get_esselon($grade,'target');
                        } else {
                            $whereGrade = ($data['grade_target'] !='0') ? (($data['include_on_target'] !='0') ? '((job_grade>='.$grade.') and (job_grade<='.($grade+$data['grade_target'].'))') :'((job_grade>'.$grade.') and (job_grade<='.($grade+$data['grade_target'].'))')) : '(job_grade='.$grade.')';
                        }
                        $sql  ='SELECT * FROM ( ';
                        $sql .='SELECT * FROM ( SELECT current_job_id, current_job_name,	current_job_grade, from_subskill_id, to_subskill_id, job_skill,	';
                        $sql .='                      count( to_subskill_id ), ( avg( maxindex )/ 4 * 100 ) AS compatibility,	target_job_id, target_job_name, target_job_grade, target_job_alnum_grade, target_subskill_id,	target_job_skill';
                        $sql .='	FROM';
                        $sql .='		(';
                        $sql .='		SELECT';
                        $sql .='			current_job_id,	current_job_name,	current_job_grade, from_subskill_id, to_subskill_id, job_skill, ';
                        $sql .='			max( compatibility ) AS maxindex, target_job_id, target_job_name,	target_job_grade, target_job_alnum_grade,target_subskill_id, target_job_skill FROM';
                        $sql .='			(';
                        $sql .='			SELECT';
                        $sql .='				current_job.*, target_job.*';
                        $sql .='			FROM';
                        $sql .='				(';
                        $sql .='				SELECT';
                        $sql .='					job_id as current_job_id, job_name as current_job_name, job_grade as current_job_grade, from_subskill_id, ';
                        $sql .='					to_subskill_id, job_skill, compatibility ';
                        $sql .='				FROM';
                        $sql .='					vw_compatibility_job';
                        $sql .='				WHERE job_id ='.$job_id.' AND special_case="0" ';
                        $sql .='				ORDER BY';
                        $sql .='					job_grade ,to_subskill_id,	compatibility ';
                        $sql .='				) current_job';
                        $sql .='				LEFT JOIN (';
                        $sql .='				SELECT';
                        $sql .='					job_id as target_job_id, job_name as target_job_name,	job_grade as target_job_grade, job_alnum_grade as target_job_alnum_grade, subskill_id as target_subskill_id, job_skill as target_job_skill ';
                        $sql .='				FROM';
                        $sql .='					vw_job_grade_skill_map ';
                        $sql .='				WHERE '.$whereGrade;
                        $sql .='				ORDER BY';
                        $sql .='					job_grade, subskill_id ';
                        $sql .='				) target_job ON current_job.from_subskill_id = target_job.target_subskill_id';
                        $sql .='			WHERE';
                        $sql .='				target_job.target_job_id IS NOT NULL ';
                        $sql .='			ORDER BY';
                        $sql .='				current_job.current_job_grade, target_job.target_job_grade ';
                        $sql .='			) step1';
                        $sql .='		GROUP BY';
                        $sql .='			current_job_id, to_subskill_id,	target_job_id ';
                        $sql .='		) setp2 ';
                        $sql .='	GROUP BY';
                        $sql .='		current_job_id, target_job_id, target_job_grade ORDER BY target_job_grade DESC ) a';
                        $sql .='    WHERE compatibility >='.$percent_compability.' and target_job_id !='.$job_id.' ORDER BY compatibility DESC';
                        $sql .=' ) withorder';
                        //-$respz['match'][] = $this->checkSg_compability($respx['find']['job_sg'],$grade,$data['grade_target'],'target','job');
                        $respz['match'][] = $this->checkSg_compability($respx['find']['job_skill'],$grade,$data['grade_target'],$data['include_on_target'],'target','job');
                        //echo $sql ;
                        break;
                    case ($_GET['r'] == 'j2jfeeder'):
                        if ( $data['size_method_selected'] == '1') {
                            $whereGrade = 'job_grade in '.$this->get_esselon($grade,'feeder');
                        } else {
                            $whereGrade = ($data['grade_feed'] !='0') ? (($data['include_on_feed'] !='0') ? '((job_grade>='.($grade-$data['grade_feed'].') and (job_grade<='.$grade.'))') :'((job_grade>='.($grade-$data['grade_feed'].') and (job_grade<'.$grade.'))')) : '(job_grade='.$grade.')';
                        }
                        $sql  ='SELECT * FROM ';
                        $sql .='	(	SELECT * FROM ';
                        $sql .='		( SELECT ';
                        $sql .='			current_job_id, current_job_name, current_job_grade, from_subskill_id,	to_subskill_id, job_skill, ';
                        $sql .='			count( to_subskill_id ), ( avg( maxindex )/ 4 * 100 ) AS compatibility,	feeder_job_id, feeder_job_name, ';
                        $sql .='			feeder_job_grade,	feeder_job_alnum_grade, feeder_subskill_id,	feeder_job_skill  ';
                        $sql .='		FROM ';
                        $sql .='			( ';
                        $sql .='			SELECT ';
                        $sql .='				current_job_id,	current_job_name,	current_job_grade, from_subskill_id, to_subskill_id, job_skill, ';
                        $sql .='				max( compatibility ) AS maxindex,	feeder_job_id, feeder_job_name,	feeder_job_grade, feeder_job_alnum_grade,	feeder_subskill_id, feeder_job_skill  ';
                        $sql .='			FROM ';
                        $sql .='				( SELECT ';
                        $sql .='					current_job.*, feeder_job.*  ';
                        $sql .='				FROM ';
                        $sql .='					( SELECT ';
                        $sql .='						job_id AS current_job_id, job_name AS current_job_name,	job_grade AS current_job_grade,  ';
                        $sql .='						from_subskill_id,  to_subskill_id, job_skill,	compatibility ';
                        $sql .='					FROM ';
                        $sql .='						vw_compatibility_job ';
                        $sql .='				WHERE job_id ='.$job_id.' AND special_case="0" ';
                        $sql .='					ORDER BY ';
                        $sql .='						job_grade,	to_subskill_id,	compatibility  ';
                        $sql .='					) current_job ';
                        $sql .='					LEFT JOIN (	';
                        $sql .='					SELECT ';
                        $sql .='						job_id AS feeder_job_id, job_name AS feeder_job_name,	job_grade AS feeder_job_grade, job_alnum_grade as feeder_job_alnum_grade, ';
                        $sql .='						subskill_id AS feeder_subskill_id,	job_skill AS feeder_job_skill  ';
                        $sql .='					FROM ';
                        $sql .='						vw_job_grade_skill_map ';
                        $sql .='				WHERE '.$whereGrade;
                        $sql .='					ORDER BY ';
                        $sql .='						job_grade, subskill_id  ';
                        $sql .='					) feeder_job ON feeder_job.feeder_subskill_id = current_job.from_subskill_id ';
                        $sql .='				WHERE ';
                        $sql .='					feeder_job.feeder_job_id IS NOT NULL   ';
                        $sql .='				ORDER BY ';
                        $sql .='					current_job.current_job_grade, feeder_job.feeder_job_grade ';
                        $sql .='				) step1 ';
                        $sql .='			GROUP BY ';
                        $sql .='				current_job_id, to_subskill_id,	feeder_job_id  ';
                        $sql .='			) setp2 ';
                        $sql .='		GROUP BY ';
                        $sql .='			current_job_id, feeder_job_id, feeder_job_grade ORDER BY feeder_job_grade DESC';
                        $sql .='		) a ';
                        $sql .='    WHERE compatibility >='.$percent_compability.' and feeder_job_id !='.$job_id.' ORDER BY compatibility DESC';
                        $sql .='	) withorder';
                        $respz['match'][] = $this->checkSg_compability($respx['find']['job_skill'],$grade,$data['grade_feed'],$data['include_on_feed'],'feed','job');
                        break;
                    case ($_GET['r'] == 'j2p'):
                        if ( $data['size_method_selected'] == '1') {
                            $whereGrade = 'person_grade in '.$this->get_esselon($person_grade,'feeder');
                        } else {
                            $whereGrade = ($data['grade_feed'] !='0') ? (($data['include_on_feed'] !='0') ? '((person_grade>='.($person_grade-$data['grade_feed'].') and (person_grade<='.$person_grade.'))') :'((person_grade>='.($person_grade-$data['grade_feed'].') and (person_grade<'.$person_grade.'))')) : '(person_grade='.$person_grade.')';
                        }
                        $sql  ='SELECT * FROM	( ';
                        $sql .='	SELECT * FROM	( ';
                        $sql .='		SELECT job_id, job_name, job_grade, alnum_job_grade, count( to_subskill_id ) AS skill_on_target, sum( maxindex ) AS matrix, ';
                        $sql .='			((( sum( maxindex )/ count( to_subskill_id ))/ 4 )* 100 ) AS compatibility, job_skill, person_id, ';
                        $sql .='			person_number, person_name, person_grade, person_skill, performance, talentbox, assessment, tmt, tmtgrade, ';
                        $sql .='			person_job_id, person_job_name, person_job_grade, person_alnum_job_grade, person_job_skill, notes ';
                        $sql .='		FROM	( ';
                        $sql .='			SELECT ';
                        $sql .='	      job_id, job_name, job_grade, alnum_job_grade, to_subskill_id, max( compatibility ) AS maxindex, job_skill, ';
                        $sql .='				person_id, person_number, person_name, person_grade, person_skill, performance, talentbox, assessment, tmt, tmtgrade, ';
                        $sql .='				person_job_id, person_job_name, person_job_grade,	person_alnum_job_grade, person_job_skill, notes	 ';
                        $sql .='			FROM ';
                        $sql .='				(	';
                        $sql .='				SELECT ';
                        $sql .='					current_job.*, target_person.* ';
                        $sql .='				FROM ';
                        $sql .='					( ';
                        $sql .='					SELECT ';
                        $sql .='						job_id, job_name,	job_grade, alnum_job_grade, from_subskill_id, to_subskill_id, job_skill, compatibility, special_case as job_special_case ';
                        $sql .='					FROM ';
                        $sql .='						vw_compatibility_job ';
                        $sql .='				  WHERE job_id ='.$job_id;
                        $sql .='					ORDER BY ';
                        $sql .='						from_subskill_id, to_subskill_id, compatibility ';
                        $sql .='					) current_job ';
                        $sql .='					LEFT JOIN (	 ';
                        $sql .='            SELECT ';
                        $sql .='   						person_id, person_number,	person_name, person_grade, person_skill, performance, talentbox, assessment, tmt, tmtgrade,';
                        $sql .='               person_subskill_id,	person_job_id,person_job_name,person_job_grade,	person_alnum_job_grade, person_job_skill, special_case as person_special_case, notes ';
                        $sql .='					FROM ';
                        $sql .='						vw_person ';
                        $sql .='				WHERE mp != "1" AND person_job_id !='.$job_id.$tmt_grade.$performance_level.$assessment.' AND '.$whereGrade. (($_GET['r'] == 'pf') ? ' and person_id !='.$person_id : '');
                        //$sql .='				WHERE person_job_id !='.$job_id.' AND '.$whereGrade. (($_GET['r'] == 'pf') ? ' and person_id !='.$person_id : '');
                        $sql .='					ORDER BY ';
                        $sql .='						person_grade DESC ';
                        $sql .='					) target_person ON (current_job.from_subskill_id = target_person.person_subskill_id) and (current_job.job_special_case = target_person.person_special_case)  ';
                        $sql .='				WHERE ';
                        $sql .='					target_person.person_name IS NOT NULL';
                        $sql .='					ORDER BY ';
                        $sql .='						target_person.person_grade DESC ';
                        $sql .='				) step1 ';
                        $sql .='			GROUP BY ';
                        $sql .='				to_subskill_id, person_id ';
                        $sql .='			ORDER BY ';
                        $sql .='				person_grade) step2 ';
                        $sql .='		GROUP BY ';
                        $sql .='			person_id ';
                        $sql .='					ORDER BY ';
                        $sql .='						person_grade DESC ';
                        $sql .='		) a ';
                        $sql .='    WHERE compatibility >='.$percent_compability.' ORDER BY compatibility DESC';
                        $sql .='	) withorder ';
                        $respz['match'][] = $this->checkSg_compability($respx['find']['job_skill'],$grade,$data['grade_feed'],$data['include_on_feed'],'feed','person');
                        break;
                    case ($_GET['r'] == 'p2jfeeder'):
                        if ( $data['size_method_selected'] == '1') {
                            $whereGrade = 'person_grade in '.$this->get_esselon($person_grade,'feeder');
                        } else {
                            $whereGrade = ($data['grade_feed'] !='0') ? (($data['include_on_feed'] !='0') ? '((person_grade>='.($person_grade-$data['grade_feed'].') and (person_grade<='.$person_grade.'))') :'((person_grade>='.($person_grade-$data['grade_feed'].') and (person_grade<'.$person_grade.'))')) : '(person_grade='.$person_grade.')';
                        }
                        $sql  ='SELECT * FROM ';
                        $sql .='	(	SELECT * FROM ';
                        $sql .='		( SELECT ';
                        $sql .='				job_id,	job_name,	job_grade, count( from_subskill_id ) AS skill_on_target, sum( maxindex ) AS matrix,  ';
                        $sql .='			((( sum( maxindex )/ count( from_subskill_id ))/ 4 )* 100 ) AS compatibility, job_skill,  ';
                        $sql .='				person_id, person_number,	person_name, person_grade, person_skill, ';
                        $sql .='				person_subskill_id, person_job_id, person_job_name, person_job_grade, person_alnum_job_grade, person_job_skill, tmt, notes ';
                        $sql .='		FROM ';
                        $sql .='			(	SELECT ';
                        $sql .='				job_id, job_name,	job_grade, from_subskill_id, to_subskill_id, max( compatibility ) AS maxindex, job_skill, ';
                        $sql .='				person_id, person_number,	person_name, person_grade, person_skill,	person_subskill_id,	';
                        $sql .='       person_job_id, person_job_name,	person_job_grade,	person_alnum_job_grade, person_job_skill,  tmt, notes ';
                        $sql .='			FROM ';
                        $sql .='				(	SELECT ';
                        $sql .='					target_job.*,	feeder_person.*  ';
                        $sql .='				FROM ';
                        $sql .='					(	SELECT ';
                        $sql .='						job_id,	job_name,	job_grade, from_subskill_id,	to_subskill_id,	job_skill, compatibility ';
                        $sql .='					FROM ';
                        $sql .='						vw_compatibility_job ';
                        $sql .='				WHERE job_id ='.$job_id.' AND special_case="0" ';
                        $sql .='					ORDER BY ';
                        $sql .='						from_subskill_id, to_subskill_id,	compatibility  ';
                        $sql .='					) target_job ';
                        $sql .='					LEFT JOIN (	 ';
                        $sql .='					SELECT ';
                        $sql .='						person_id, person_number,	person_name, person_grade, person_skill,  ';
                        $sql .='						person_subskill_id,	person_job_id,person_job_name,person_job_grade,	person_alnum_job_grade, person_job_skill, tmt, notes ';
                        $sql .='					FROM ';
                        $sql .='						vw_person ';
                        $sql .='				WHERE mp != "1" AND '.$whereGrade.$tmt_grade.$performance_level.$assessment. (($_GET['r'] == 'p2jfeeder') ? ' and person_id !='.$person_id.' and person_job_id !='.$job_id : ''); //$sql .='				WHERE '.$whereGrade.' and a.person_id !='.$person_id;
                        $sql .='					ORDER BY person_grade, person_subskill_id  	 ';
                        $sql .='					) feeder_person ON target_job.from_subskill_id = feeder_person.person_subskill_id   ';
                        $sql .='				WHERE ';
                        $sql .='					feeder_person.person_name IS NOT NULL 	 ';
                        $sql .='				) step1  ';
                        $sql .='			GROUP BY ';
                        $sql .='				job_skill, ';
                        $sql .='				person_id  ';
                        $sql .='			ORDER BY ';
                        $sql .='				person_grade 	 ';
                        $sql .='			) step2  ';
                        $sql .='		GROUP BY ';
                        $sql .='			person_id  ';
                        $sql .='					ORDER BY ';
                        $sql .='						person_grade DESC ';
                        $sql .='		) a  ';
                        $sql .='    WHERE compatibility >='.$percent_compability.' and person_id !='.$person_id.' ORDER BY compatibility DESC';
                        $sql .='	) withorder ';
                        $respz['match'][] = $this->checkSg_compability($respx['find']['job_skill'],$grade,$data['grade_feed'],$data['include_on_feed'],'feed','person');
                        break;
                    case ($_GET['r'] == 'p2jtarget') :
                        if ( $data['size_method_selected'] == '1') {
                            $whereGrade = 'job_grade in '.$this->get_esselon($grade,'target');
                        } else {
                            $whereGrade = ($data['grade_target'] !='0') ? (($data['include_on_target'] !='0') ? '((job_grade>='.$grade.') and (job_grade<='.($grade+$data['grade_target'].'))') :'((job_grade>'.$grade.') and (job_grade<='.($grade+$data['grade_target'].'))')) : '(job_grade='.$grade.')';
                        }
                        //$whereGrade = ($data['grade_target'] !='0') ? (($data['include_on_target'] !='0') ? '((person_grade>='.($person_grade.') and (person_grade<='.($person_grade+$data['grade_target']).'))') :'((person_grade>'.($person_grade.') and (person_grade<='.($person_grade+$data['grade_target']).'))')) : '(person_grade='.$person_grade.')';
                        // echo 're'.$whereGrade; die();
                        $sql  ='SELECT * FROM ( ';
                        $sql .='SELECT a.*, b.skill_name as job_skill FROM	( SELECT';
                        $sql .='		person_id, person_name,	person_grade,	person_job_id,	person_job_name, person_job_grade, person_subskill_id, person_skill, count( subskill_id ) AS no_skill_on_target,';
                        $sql .='		( avg( compatibility )/ 4 * 100 ) AS compatibility,	job_id, job_name,	job_grade, job_alnum_grade';
                        $sql .='	FROM';
                        $sql .='		(';
                        $sql .='		SELECT';
                        $sql .='			person_id, person_name,	person_grade,	person_job_id,	person_job_name, person_job_grade, person_subskill_id, person_skill, subskill_id, ';
                        $sql .='			max( compatibility ) AS compatibility, job_id,	job_name, job_grade, job_alnum_grade';
                        $sql .='		FROM';
                        $sql .='			(';
                        $sql .='			SELECT';
                        $sql .='				current_person.*,	job_target.*';
                        $sql .='			FROM';
                        $sql .='				(';
                        $sql .='				SELECT';
                        $sql .='					person_id, person_name, person_grade, person_subskill_id, to_subskill_id, compatibility,';
                        $sql .='					person_job_id, person_job_name, person_job_grade, person_skill ';
                        $sql .='				FROM';
                        $sql .='					vw_person_job_map ';
                        $sql .='				WHERE person_job_id ='.$job_id;
                        $sql .='				) current_person';
                        $sql .='				LEFT JOIN (';
                        $sql .='				SELECT';
                        $sql .='					job_id, job_name,	job_grade, job_alnum_grade, subskill_id ';
                        $sql .='				FROM';
                        $sql .='					vw_job_grade_skill_map ';
                        $sql .='				WHERE '.$whereGrade;
                        $sql .='				ORDER BY';
                        $sql .='					job_grade';
                        $sql .='				) job_target ON current_person.to_subskill_id = job_target.subskill_id';
                        $sql .='			WHERE';
                        $sql .='				job_target.job_id IS NOT NULL';
                        $sql .='			) step1';
                        if ($job_id == '0') {
                            $sql .='		GROUP BY job_id, person_id  ORDER BY job_grade ) step2 GROUP BY job_id, person_id ORDER BY job_grade DESC) a';
                        } else {
                            $sql .='		GROUP BY subskill_id, job_id, person_id  ORDER BY job_grade ) step2 GROUP BY job_id ORDER BY job_grade DESC) a';
                        }
                        $sql .='	  LEFT JOIN vw_skill_job b on a.job_id=b.job_id';
                        $sql .='   WHERE compatibility >='.$percent_compability.' and a.job_id !='.$job_id.' and a.person_id ='.$person_id.' ORDER BY compatibility DESC';
                        $sql .=' ) withorder';
                        $respz['match'][] = $this->checkSg_compability($respx['find']['person_skill'],$grade,$data['grade_target'],$data['include_on_target'],'target','job');
                        break;
                }

                $orderby = '';
                if (isset($_GET['ordBy'])) {
                    if (!empty($_GET['ordBy'])) {
                        $orderby .= ' order by '.$_GET['ordBy'].' '.$_GET['ordType'];
                    } else {
                        switch (true) {
                            case ($_GET['r'] == 'j2jtarget') || ($_GET['r'] == 'j2jfeeder'):
                                $orderby .= ' order by compatibility DESC ';
                                break;
                            default :
                                $orderby .= ' order by compatibility DESC, person_grade DESC ';
                        }
                    };
                };

                $num_results = 1;
                if (isset($_GET['p'])) {
                    $query = $this->db->query($sql);
                    $num_results = $query->num_rows();
                };

                $resp = main::excRequestSQL($sql.$orderby,true);
                $resp['recordsFiltered'] = $num_results;

                $images =  array_merge($resp, $respx, $respz);
                $this->response($images);
            };
        };
    }

    function compatibilitymapx_get()
    {
        $response['data'] = array();
        $resp2 = [];
        $whereMode = "1 = 1";
        if (isset($_GET['t'])) {
            if (!empty($_GET['t'])) {
                if ($_GET['t']=='1') {
                    $num_results = 1;
                    if (isset($_GET['p'])) {
                        $this->db->select('distinct(a.skill_id), b.skill_name')
                            ->from('skill_map AS a')
                            ->join('ref_skill AS b', 'a.skill_id = b.skill_id', 'left')
                            //->where($where_grade)
                            ->order_by('b.skill_name', 'ASC');
                        $num_results = $this->db->count_all_results();
                    };


                    $this->db->select('distinct(a.skill_id), b.skill_name')
                        ->from('skill_map AS a')
                        ->join('ref_skill AS b', 'a.skill_id = b.skill_id', 'left')
                        //->where($where_grade)
                        ->order_by('b.skill_name', 'ASC');
                } else if ($_GET['t']=='2') {
                    $num_results = 1;
                    if (isset($_GET['p'])) {
                        $this->db->select('a.subskill_id, b.subskill_name')
                            ->from('skill_map AS a')
                            ->join('ref_subskill AS b', 'a.subskill_id = b.subskill_id', 'left')
                            //->where($where_grade)
                            ->order_by('b.subskill_name', 'ASC');
                        $num_results = $this->db->count_all_results();
                    };


                    $this->db->select('a.subskill_id, b.subskill_name')
                        ->from('skill_map AS a')
                        ->join('ref_subskill AS b', 'a.subskill_id = b.subskill_id', 'left')
                        //->where($where_grade)
                        ->order_by('b.subskill_name', 'ASC');
                } else {
                    $where_skill = ($_GET['mt'] == '1') ? 'skill_id in ('.$_GET['q'].')':'subskill_id in ('.$_GET['q'].')';
                    $num_results = 1;
                    if (isset($_GET['p'])) {
                        $this->db->select('skill_id, skill_name, subskill_id, subskill_name')
                            ->from('vw_skill_subskill_map')
                            //->join('ref_subskill AS b', 'a.subskill_id = b.subskill_id', 'left')
                            ->where($where_skill);
                        //->order_by('subskill_name', 'ASC');
                        $num_results = $this->db->count_all_results();
                    };


                    $this->db->select('skill_id, skill_name, skill_node, subskill_id, subskill_name')
                        ->from('vw_skill_subskill_map')
                        // ->join('ref_subskill AS b', 'a.subskill_id = b.subskill_id', 'left')
                        ->where($where_skill)
                        ->order_by('skill_name', 'ASC');



                    $whereMatrix = ($_GET['mt'] == '1') ? '(from_js_id in ('.$_GET['q'].')) and (to_js_id in ('.$_GET['q'].'))':'(from_sjs_id in ('.$_GET['q'].')) and (to_sjs_id in ('.$_GET['q'].'))';
                    $sqlMatrix = 'select concat(from_sjs_id,"_",to_sjs_id) as matrix_id, compatibility_index from vw_compatibility_matrix where '.$whereMatrix.' order by from_sjs_id, to_sjs_id';
                    $resp2['matrix'] = main::excRequestSQL($sqlMatrix,true)['data'];
                }



            };
        };



        $resp  = main::excRequest();
        // $resp2 = main::excRequestSQL($sqlMatrix,true);
        $resp['recordsFiltered'] = $num_results;

        $this->response(array_merge($resp, $resp2));
    }

    function compatibilitymap_get()
    {
        $response['data'] = array();
        $resp2 = [];
        $whereMode = "1 = 1";
        if (isset($_GET['mt'])) {
            $where_skill = 'skill_id in ('.$_GET['q'].')';
            $num_results = 1;
            if (isset($_GET['p'])) {
                $this->db->select('skill_id, skill_name, subskill_id, subskill_name')
                    ->from('vw_skill_subskill_map')
                    ->where($where_skill);
                $num_results = $this->db->count_all_results();
            };

            $this->db->select('skill_id, skill_name, skill_node, subskill_id, subskill_name')
                ->from('vw_skill_subskill_map')
                ->where($where_skill)
                ->order_by('skill_name', 'ASC');

            $whereMatrix = '(from_js_id in ('.$_GET['q'].')) and (to_js_id in ('.$_GET['q'].'))';
            $sqlMatrix = 'select concat(from_sjs_id,"_",to_sjs_id) as matrix_id, compatibility_index from vw_compatibility_matrix where '.$whereMatrix.' and special="'.$_GET['mt'].'" order by from_sjs_id, to_sjs_id';
            $resp2['matrix'] = main::excRequestSQL($sqlMatrix,true)['data'];
        };

        $resp  = main::excRequest();
        // $resp2 = main::excRequestSQL($sqlMatrix,true);
        $resp['recordsFiltered'] = $num_results;
        $this->response(array_merge($resp, $resp2));
    }
    //End Rere

    //Start ALVIN
    //Start CRUD for Grade
    function grade_get()
    {
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(grade_id=" . $_GET['id'] . ")";
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "( grade LIKE '%" . trim($_GET['f']) . "%' ) OR ( jobgroup LIKE '%" . trim($_GET['f']) . "%' ) OR ( grade_name LIKE '%" . trim($_GET['f']) . "%' )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('grade_id,jobgrade,grade,jg.jobgroup_id AS c_jobgroup,jg.jobgroup_name AS jobgroup,grade_name,grade_code')
                ->from('ref_grade g, ref_jobgroup jg')
                ->where('g.jobgroup', 'jg.jobgroup_id', FALSE)
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select('grade_id,jobgrade,grade,jg.jobgroup_id AS c_jobgroup,jg.jobgroup_name AS jobgroup,grade_name,grade_code')
            ->from('ref_grade g, ref_jobgroup jg')
            ->where('g.jobgroup', 'jg.jobgroup_id', FALSE)
            ->where($whereID)
            ->where($whereFind);

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            }else{
                $this->db->order_by('grade DESC');
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function grade_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        $this->load->helper('string');

        if (!main::checkBeforePost('ref_grade', $data)) {
            $this->db->trans_begin();
            //save setting
            $db_debug = $this->db->db_debug;
            //disable debugging for queries
            $this->db->db_debug = FALSE;

            // insert into table pekerja
            $res = $this->db->insert('ref_grade', $data);
            if (!$res) {
                $errormsg = 'insert into ref_grade ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'ref_grade data save failed. ' . $this->db->error()['message'];
                }
            }
            //restore setting
            $this->db->db_debug = $db_debug;
            $this->db->trans_complete();

            $response['status'] = http_response_code();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }
        $this->response($response);
    }

    function grade_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $grade_id = $data['grade_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('grade_id', $grade_id)
            ->update('ref_grade', $data);
        if (!$res) {
            $errormsg = 'update ref_grade ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_grade data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function grade_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $grade_id = $_GET['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->delete('ref_grade', array('grade_id' => $grade_id));
        if (!$res) {
            $errormsg = 'delete ref_grade ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_grade data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for Grade

    //Start CRUD for Job
    function job_get()
    {
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(j.job_id=" . $_GET['id'] . ")";
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
            (j.job_name LIKE '%" . trim($_GET['f']) . "%') OR (g.jobgrade LIKE '%" . trim($_GET['f']) . "%') OR (g.grade LIKE '%" . trim($_GET['f']) . "%')
            )";
        };

        $whereOrgrisk = "1 = 1";
        if (isset($_GET['orisk'])) {
            if (!empty($_GET['orisk'])) {
                $whereOrgrisk = "(j.org_risk=" . $_GET['orisk'] . ")";
            };
        };

        $whereJobFamily = "1 = 1";
        if (isset($_GET['jfam'])) {
            if (!empty($_GET['jfam'])) {
                $whereJobFamily = "(ss.subskill_id=" . $_GET['jfam'] . ")";
            };
        };

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('j.job_id,j.job_name,CONCAT(g.jobgrade,\' | \',g.grade) AS job_grade,g.grade_id AS c_job_grade,g.grade AS job_grade_num,j.alnum_grade AS job_grade_aln,GROUP_CONCAT(s.skill_id SEPARATOR \', \') AS c_job_jf,GROUP_CONCAT(s.skill_name SEPARATOR \' | \') AS job_jf,GROUP_CONCAT(ss.subskill_id SEPARATOR \', \') AS c_job_sjf,GROUP_CONCAT(ss.subskill_name SEPARATOR \' | \') AS job_sjf')
                ->from('ref_grade g, ref_job j')
                ->join('jobskill_map jsm', 'jsm.job_id = j.job_id', 'LEFT')
                ->join('ref_subskill ss', 'ss.subskill_id = jsm.subskill_id', 'LEFT')
                ->join('skill_map sm', 'sm.subskill_id = jsm.subskill_id', 'LEFT')
                ->join('ref_skill s', 's.skill_id = sm.skill_id', 'LEFT')
                ->where('j.grade_id', 'g.grade_id', FALSE)
                ->group_by('job_id')
                ->where($whereID)
                ->where($whereOrgrisk)
                ->where($whereJobFamily)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select('j.job_id,j.job_name,g.jobgrade AS job_grade,g.grade_id AS c_job_grade,GROUP_CONCAT(s.skill_id SEPARATOR \', \') AS c_job_jf,GROUP_CONCAT(s.skill_name SEPARATOR \' | \') AS job_jf,GROUP_CONCAT(ss.subskill_id SEPARATOR \', \') AS c_job_sjf,GROUP_CONCAT(ss.subskill_name SEPARATOR \' | \') AS job_sjf')
            ->from('ref_grade g, ref_job j')
            ->join('jobskill_map jsm', 'jsm.job_id = j.job_id', 'LEFT')
            ->join('ref_subskill ss', 'ss.subskill_id = jsm.subskill_id', 'LEFT')
            ->join('skill_map sm', 'sm.subskill_id = jsm.subskill_id', 'LEFT')
            ->join('ref_skill s', 's.skill_id = sm.skill_id', 'LEFT')
            ->where('j.grade_id', 'g.grade_id', FALSE)
            ->group_by('job_id')
            ->where($whereID)
            ->where($whereOrgrisk)
            ->where($whereJobFamily)
            ->where($whereFind);

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            } else {
                $this->db->order_by('job_grade DESC');
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function job_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        $dataSubskill['job_id'] = '';
        $dataSubskill['subskill_id'] = array();

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'job_sjf') > 0) {
                array_push($dataSubskill['subskill_id'], $data[$keys[$i]]);
            } else {
                if ($keys[$i] == 'job_grade') {
                    $dataJob['grade_id'] = $data[$keys[$i]];
                } else {
                    $dataJob[$keys[$i]] = $data[$keys[$i]];
                }
            }
        }

        $this->load->helper('string');

        if (!main::checkBeforePost('ref_job', $dataJob)) {
            $this->db->trans_begin();
            //save setting
            $db_debug = $this->db->db_debug;
            //disable debugging for queries
            $this->db->db_debug = FALSE;

            // insert into table pekerja
            $res = $this->db->insert('ref_job', $dataJob);
            if (!$res) {
                $errormsg = 'insert into ref_job ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'job data save failed. ' . $this->db->error()['message'];
                } else {
                    $dataSubskill['job_id'] = $this->db->insert_id();
                    foreach ($dataSubskill['subskill_id'] as $subskillArr) {
                        $dataSubskill['subskill_id'] = $subskillArr;
                        $res = $this->db->insert('jobskill_map', $dataSubskill);
                        if (!$res) {
                            $errormsg = 'insert into jobskill_map ' . $this->db->error()['message'];
                        } else {
                            if ($this->db->trans_status() === FALSE) {
                                $errormsg = 'jobskill_map data save failed. ' . $this->db->error()['message'];
                            }
                        }
                    }
                }
            }
            //restore setting
            $this->db->db_debug = $db_debug;
            $this->db->trans_complete();

            $response['status'] = http_response_code();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }
        $this->response($response);
    }

    function job_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $job_id = $data['job_id'];
        $keys = array_keys($data);
        $arraySize = count($data);
        $dataSubskill['subskill_id'] = array();

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'job_sjf') > 0) {
                // $sjf = explode('_',$keys[$i]);
                // echo print_r($jf[1]) . '<br>';
                // echo $keys[$i] . '<br>';
                array_push($dataSubskill['subskill_id'], $data[$keys[$i]]);
            } else {
                if ($keys[$i] == 'job_grade') {
                    $dataJob['grade_id'] = $data[$keys[$i]];
                } else {
                    $dataJob[$keys[$i]] = $data[$keys[$i]];
                }
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('job_id', $job_id)
            ->update('ref_job', $dataJob);
        if (!$res) {
            $errormsg = 'update ref_job ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_job data save failed. ' . $this->db->error()['message'];
            } else {
                $res = $this->db->delete('jobskill_map', array('job_id' => $job_id));
                if (!$res) {
                    $errormsg = 'delete job ' . $this->db->error()['message'];
                } else {
                    if ($this->db->trans_status() === FALSE) {
                        $errormsg = 'job data delete failed. ' . $this->db->error()['message'];
                    } else {
                        $dataSubskill['job_id'] = $job_id;
                        // $dataCompetency['employee_id'] = $this->db->insert_id();
                        foreach ($dataSubskill['subskill_id'] as $subskillArr) {
                            $dataSubskill['subskill_id'] = $subskillArr;
                            $res = $this->db->insert('jobskill_map', $dataSubskill);
                            if (!$res) {
                                $errormsg = 'insert into jobskill_map ' . $this->db->error()['message'];
                            } else {
                                if ($this->db->trans_status() === FALSE) {
                                    $errormsg = 'jobskill_map data save failed. ' . $this->db->error()['message'];
                                }
                            }
                        }
                    }
                }
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function job_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $job_id = $_GET['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->delete('ref_job', array('job_id' => $job_id));
        if (!$res) {
            $errormsg = 'update job ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'job data save failed. ' . $this->db->error()['message'];
            }
        }
        $res = $this->db->delete('jobskill_map', array('job_id' => $job_id));
        if (!$res) {
            $errormsg = 'delete job ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'job data delete failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for Job

    //Start CRUD for Skill
    function skill_get()
    {
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(skill_id=" . $_GET['id'] . ")";
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
              skill LIKE '%" . trim($_GET['f']) . "%'
          )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('skill_id')
                ->from('ref_skill')
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select("skill_id,skill_name,skill_code")
            ->from('ref_skill')
            ->where($whereID)
            ->where($whereFind);

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function skill_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        // $data['skill_code'] = "S" . rand(1000, 9999);

        $this->load->helper('string');

        if (!main::checkBeforePost('ref_skill', $data)) {
            $this->db->trans_begin();
            //save setting
            $db_debug = $this->db->db_debug;
            //disable debugging for queries
            $this->db->db_debug = FALSE;

            // insert into table pekerja
            $res = $this->db->insert('ref_skill', $data);
            if (!$res) {
                $errormsg = 'insert into ref_skill ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'ref_skill data save failed. ' . $this->db->error()['message'];
                }
            }
            //restore setting
            $this->db->db_debug = $db_debug;
            $this->db->trans_complete();

            $response['status'] = http_response_code();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }
        $this->response($response);
    }

    function skill_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $skill_id = $data['skill_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], '_select') > 0) {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('skill_id', $skill_id)
            ->update('ref_skill', $data);
        if (!$res) {
            $errormsg = 'update ref_skill ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_skill data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function skill_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $skill_id = $_GET['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('skill_id', $skill_id)
            ->delete('ref_skill', $data);
        if (!$res) {
            $errormsg = 'update ref_skill ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_skill data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for Skill

    //Start CRUD for Sub Skill
    function subskill_get()
    {
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(subskill_id=" . $_GET['id'] . ")";
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
              subskill LIKE '%" . trim($_GET['f']) . "%'
          )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('subskill_id')
                ->from('ref_subskill')
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select("subskill_id,subskill_name,subskill_code")
            ->from('ref_subskill')
            ->where($whereID)
            ->where($whereFind);

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function subskill_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        // $data['subskill_code'] = "U" . rand(1000, 9999);

        $this->load->helper('string');

        if (!main::checkBeforePost('ref_subskill', $data)) {
            $this->db->trans_begin();
            //save setting
            $db_debug = $this->db->db_debug;
            //disable debugging for queries
            $this->db->db_debug = FALSE;

            // insert into table pekerja
            $res = $this->db->insert('ref_subskill', $data);
            if (!$res) {
                $errormsg = 'insert into ref_subskill ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'ref_subskill data save failed. ' . $this->db->error()['message'];
                }
            }
            //restore setting
            $this->db->db_debug = $db_debug;
            $this->db->trans_complete();

            $response['status'] = http_response_code();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }
        $this->response($response);
    }

    function subskill_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $subskill_id = $data['subskill_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], '_select') > 0) {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('subskill_id', $subskill_id)
            ->update('ref_subskill', $data);
        if (!$res) {
            $errormsg = 'update ref_subskill ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_subskill data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function subskill_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $subskill_id = $_GET['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('subskill_id', $subskill_id)
            ->delete('ref_subskill', $data);
        if (!$res) {
            $errormsg = 'update ref_subskill ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'ref_subskill data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for Sub Skill

    //Start CRUD for SkillMap
    function skilldata_get()
    {
        $queryCount = 0;
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(sm.subskill_id= (" . $_GET['id'] . "))";
            }
        }
        $whereFind = "1 = 1";

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('sm.skillmap_id,sm.skill_id,s.skill_name,sm.subskill_id,ss.subskill_name')
                ->from('skill_map sm')
                ->join('ref_skill s', 's.skill_id = sm.skill_id', 'LEFT')
                ->join('ref_subskill ss', 'ss.subskill_id = sm.subskill_id', 'LEFT')
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select('sm.skillmap_id,sm.skill_id,s.skill_name,sm.subskill_id,ss.subskill_name')
            ->from('skill_map sm')
            ->join('ref_skill s', 's.skill_id = sm.skill_id', 'LEFT')
            ->join('ref_subskill ss', 'ss.subskill_id = sm.subskill_id', 'LEFT')
            ->where($whereID)
            ->where($whereFind);


        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function skillmap_get()
    {
        $queryCount = 0;
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $subQuery = "(SELECT skill_id from skill_map WHERE skillmap_id = " . $_GET['id'] . ")";
                $whereID = "(s.skill_id= (" . $subQuery . "))";
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
              skillmap LIKE '%" . trim($_GET['f']) . "%'
          )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('skillmap_id')
                ->from('skill_map')
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select("
            sm.skillmap_id,
            s.skill_name, 
            s.skill_id,
            GROUP_CONCAT(ss.subskill_name SEPARATOR ' | ') AS subskill_name, 
            GROUP_CONCAT(ss.subskill_ID SEPARATOR ' | ') AS subskill_id")
            ->from("skill_map sm,ref_skill s,ref_subskill ss")
            ->where("sm.skill_id = s.skill_id ")
            ->where("sm.subskill_id = ss.subskill_id ")
            ->where($whereID)
            ->group_by('s.skill_id')
            ->where($whereFind);


        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            } else {
                $this->db->order_by("skill_id", $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function skillmap_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $data['subskill_id'] = array();
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'subskill') > 0) {
                array_push($data['subskill_id'], $data[$keys[$i]]);
                unset($data[$keys[$i]]);
            } else {
                $data['skill_id'] = $data[$keys[$i]];
                unset($data[$keys[$i]]);
            }
        }

        $this->load->helper('string');

        foreach ($data['subskill_id'] as $subskillArr) {
            $data['subskill_id'] = $subskillArr;
            if (!main::checkBeforePost('skill_map', $data)) {
                $this->db->trans_begin();
                //save setting
                $db_debug = $this->db->db_debug;
                //disable debugging for queries
                $this->db->db_debug = FALSE;

                // insert into table pekerja
                $res = $this->db->insert('skill_map', $data);
                if (!$res) {
                    $errormsg = 'insert into skill_map ' . $this->db->error()['message'];
                } else {
                    if ($this->db->trans_status() === FALSE) {
                        $errormsg = 'skill_map data save failed. ' . $this->db->error()['message'];
                    }
                }
                //restore setting
                $this->db->db_debug = $db_debug;
                $this->db->trans_complete();

                $response['status'] = http_response_code();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();

                    $response['error'] = true;
                    $response['message'] = $errormsg;
                } else {
                    $this->db->trans_commit();
                    $response['error'] = false;
                    $response['message'] = 'success';
                }
            } else {
                $response['status'] = 200;
                $response['error'] = false;
                $response['message'] = 'Data Duplicate!';
            }
        }

        $this->response($response);
    }

    function skillmap_put()
    {
        parse_str(file_get_contents("php://input"), $data);
//        $skillmap_id = $data['skillmap_id'];
        $keys = array_keys($data);
        $arraySize = count($data);
        $data['subskill_id'] = array();

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'subskill') > 0) {
                array_push($data['subskill_id'], $data[$keys[$i]]);
                unset($data[$keys[$i]]);
            } else {
                $data['skill_id'] = $data[$keys[$i]];
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->delete('skill_map', array('skill_id' => $data['skill_id']));
        if (!$res) {
            $errormsg = 'delete skill_map ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'skill_map data save failed. ' . $this->db->error()['message'];
            }
        }
        foreach ($data['subskill_id'] as $subskill_id) {
            $data['subskill_id'] = $subskill_id;
            $res = $this->db->insert('skill_map', $data);
            if (!$res) {
                $errormsg = 'insert into skill_map ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'skill_map data save failed. ' . $this->db->error()['message'];
                }
            }

            //restore setting
            $this->db->db_debug = $db_debug;

            $this->db->trans_complete();

            $response['status'] = http_response_code();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        }

        $this->response($response);
    }

    function skillmap_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $skill_id = $data['skill_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('skill_id', $skill_id)
            ->delete('skill_map');
        if (!$res) {
            $errormsg = 'delete skill_map ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'skill_map data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for SkillMap

    //Start CRUD for Compatibility
    function compatibility_get()
    {
        $response['data'] = array();
        $queryCount = 0;

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(id=" . $_GET['id'] . ")";
                $this->db->select('id,from_skill_id,to_skill_id,compatibility_index ')
                    ->from('compatibility_matrix')
                    ->where($whereID);
                $queryCount = 1;
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
              skill_name LIKE '%" . trim($_GET['f']) . "%'
          )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('id')
                ->from('compatibility_matrix')
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        if ($queryCount === 0) {
            $this->db->select('id,skill_name AS compatibility_skill,ssf.subskill_name AS compatibility_from,sst.subskill_name AS compatibility_to,compatibility_index ')
                ->from('compatibility_matrix,ref_skill s,ref_subskill ssf,ref_subskill sst,skill_map sm')
                ->where('ssf.subskill_id = from_skill_id ')
                ->where('sst.subskill_id = to_skill_id ')
                ->where('from_skill_id = sm.subskill_id ')
                ->where('sm.skill_id = s.skill_id ')
                ->where($whereID)
                ->where($whereFind);
        }

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function compatibility_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        $this->load->helper('string');

        if (!main::checkBeforePost('compatibility_matrix', $data)) {
            $this->db->trans_begin();
            //save setting
            $db_debug = $this->db->db_debug;
            //disable debugging for queries
            $this->db->db_debug = FALSE;

            // insert into table pekerja
            $res = $this->db->insert('compatibility_matrix', $data);
            if (!$res) {
                $errormsg = 'insert into compatibility_matrix ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'compatibility_matrix data save failed. ' . $this->db->error()['message'];
                };
            }
            //restore setting
            $this->db->db_debug = $db_debug;
            $this->db->trans_complete();

            $response['status'] = http_response_code();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }
        $this->response($response);
    }

    function compatibility_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        // $id = $data['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $id = $this->db->select('id')
            ->where(array('from_subskill_id' => $data['from_subskill_id'],'to_subskill_id' => $data['to_subskill_id'],'special' => $data['special']))
            ->get('`compatibility_matrix`')->row(0)->id;

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('id', $id)
            ->update('compatibility_matrix', $data);
        if (!$res) {
            $errormsg = 'update compatibility_matrix ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'compatibility_matrix data save failed. ' . $this->db->error()['message'];
            };
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function compatibility_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $id = $data['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('id', $id)
            ->delete('compatibility_matrix', $data);
        if (!$res) {
            $errormsg = 'update compatibility_matrix ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'compatibility_matrix data save failed. ' . $this->db->error()['message'];
            };
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for Compatibility

    //Start CRUD for Employee
    function employee_get()
    {
        $response['data'] = array();
        $detail = 0;

        $whereID = "1 = 1";
        if (!empty($_GET['id'])) {
            $whereID = "(p.person_id=" . $_GET['id'] . ")";
            $detail = 1;
        }

        $whereFind = "1 = 1";
        if (isset($_GET['f'])) {
            if (!empty($_GET['f'])) {
                $whereFind = "(( person_number LIKE '%" . trim($_GET['f']) . "%' ) OR ( person_name LIKE '%" . trim($_GET['f']) . "%' ) OR ( g.grade LIKE '%" . trim($_GET['f']) . "%' ) OR ( ps.skill_name LIKE '%" . trim($_GET['f']) . "%' ) OR ( j.job_name LIKE '%" . trim($_GET['f']) . "%' ))";
            };
        };

        $whereFlexiibility = "1 = 1";
        if (isset($_GET['x'])) {
            if (!empty($_GET['x'])) {
                $whereFlexiibility = "(mp='" . $_GET['x'] . "')";
            };
        };

        $whereRetention = "1 = 1";
        if (isset($_GET['r'])) {
            if (!empty($_GET['r'])) {
                $whereRetention = "(assesment='" . $_GET['r'] . "')";
            };
        };

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('p.person_id,p.person_number,p.person_name,g.grade AS person_grade,GROUP_CONCAT(DISTINCT ps.skill_name SEPARATOR \' | \') AS person_jf,cass.value AS c_assessment,cass.text AS assessment,p.job_id,j.job_name,p.mp')
                ->from('ref_grade g, person p')
                ->join('ref_job j', 'j.job_id = p.job_id', 'LEFT')
                ->join('personskill_map psm', 'psm.person_id = p.person_id', 'LEFT')
                ->join('skill_map smp', 'smp.subskill_id = psm.subskill_id', 'LEFT')
                ->join('ref_skill ps', 'ps.skill_id = smp.skill_id', 'LEFT')
                ->join('ref_code cass', 'cass.value = p.assessment AND cass.GROUP = \'assessment\'', 'LEFT')
                ->where('p.grade_id', 'g.grade_id', FALSE)
                ->where($whereID)
                ->where($whereFlexiibility)
                ->where($whereRetention)
                ->group_by('p.person_id')
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        if ($detail == 1) {
            $this->db->select('
                p.person_id,
                p.person_number,
                p.person_name,
                p.grade_id AS person_grade,
                g.grade AS person_grade_num,
                GROUP_CONCAT(DISTINCT ps.skill_name SEPARATOR \' | \') AS person_jf,
                GROUP_CONCAT(DISTINCT pss.subskill_name SEPARATOR \' | \')  AS person_sjf,
                GROUP_CONCAT(DISTINCT pss.subskill_id SEPARATOR \' | \') AS person_sjf_id,
                cgender.value AS c_gender,
                cgender.text AS gender,
                DATE_FORMAT(p.tgl_lahir,\'%d-%m-%Y\') AS tgl_lahir,
                cagama.value AS c_agama,
                cagama.text AS agama,
                cpen.value AS c_pendidikan,
                cpen.text AS pendidikan,
                DATE_FORMAT(p.tgl_masuk,\'%d-%m-%Y\') AS tgl_masuk,
                p.email,
                p.talentbox,
                p.performance_year1,
                p.performance_year2,
                cass.value AS c_assessment,
                cass.text AS assessment,
                DATE_FORMAT(p.tmtgrade,\'%d-%m-%Y\') AS tmtgrade,
                p.job_id,
                cgol.value as c_penggolongan,
                cgol.text as penggolongan,
                casp.value as c_aspirasi,
                casp.text as aspirasi,
                p.pos1,
                p.pos2,
                p.pos3,
                p.loc1,
                p.loc2,
                p.loc3,
                p.mp,
                p.top_talent,
                p.notes,
                cflex.value as c_flexibility,
                cflex.text as flexibility,
                cret.value as c_retention,
                cret.text as retention')
                ->from('ref_grade g, person p')
                ->join('personskill_map psm', 'psm.person_id = p.person_id', 'LEFT')
                ->join('ref_subskill pss', 'pss.subskill_id = psm.subskill_id', 'LEFT')
                ->join('skill_map smp', 'smp.subskill_id = psm.subskill_id', 'LEFT')
                ->join('ref_skill ps', 'ps.skill_id = smp.skill_id', 'LEFT')
                ->join('ref_code cgender', 'cgender.value = p.gender AND cgender.GROUP = \'gender\'', 'LEFT')
                ->join('ref_code cagama', 'cagama.value = p.agama AND cagama.GROUP = \'agama\'', 'LEFT')
                ->join('ref_code cpen', 'cpen.value = p.pendidikan AND cpen.GROUP = \'pendidikan\'', 'LEFT')
                ->join('ref_code cgol', 'cgol.value = p.penggolongan AND cgol.GROUP = \'penggolongan\'', 'LEFT')
                ->join('ref_code casp', 'casp.value = p.aspirasi AND casp.GROUP = \'caspirasi\'', 'LEFT')
                ->join('ref_code cass', 'cass.value = p.assessment AND cass.GROUP = \'assessment\'', 'LEFT')
                ->join('ref_code cflex', 'cflex.value = p.flexibility AND cflex.GROUP = \'flexibility\'', 'LEFT')
                ->join('ref_code cret', 'cret.value = p.retention AND cret.GROUP = \'retention\'', 'LEFT')
                ->where('p.grade_id', 'g.grade_id', FALSE)
                ->where($whereID)
                ->where($whereFlexiibility)
                ->where($whereRetention)
                ->group_by('p.person_id')
                ->where($whereFind);
        } else {
            $this->db->select('p.person_id,p.person_number,p.person_name,g.grade AS person_grade,GROUP_CONCAT(DISTINCT ps.skill_name SEPARATOR \' | \') AS person_jf,cass.value AS c_assessment,cass.text AS assessment,p.job_id,j.job_name,p.mp')
                ->from('ref_grade g, person p')
                ->join('ref_job j', 'j.job_id = p.job_id', 'LEFT')
                ->join('personskill_map psm', 'psm.person_id = p.person_id', 'LEFT')
                ->join('skill_map smp', 'smp.subskill_id = psm.subskill_id', 'LEFT')
                ->join('ref_skill ps', 'ps.skill_id = smp.skill_id', 'LEFT')
                ->join('ref_code cass', 'cass.value = p.assessment AND cass.GROUP = \'assessment\'', 'LEFT')
                ->where('p.grade_id', 'g.grade_id', FALSE)
                ->where($whereID)
                ->where($whereFlexiibility)
                ->where($whereRetention)
                ->group_by('p.person_id')
                ->where($whereFind);
        }

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            } else {
                $this->db->order_by('g.grade DESC, p.person_number ASC');
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;
        if ($detail == 1){
            $year1 = $resp['data'][0]->performance_year1;
            $year2 = $resp['data'][0]->performance_year2;
            if ((($year1 !== 0 || $year1 !== NULL) && ($year2 !== 0 || $year2 !== NULL))){
                $resp['data'][0]->performance_level = (string) (($year1+$year2)/2);
            }else{
                $resp['data'][0]->performance_level = $year2;
            }
        }

        $this->response($resp);
    }

    function employee_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        $dataSubskill['person_id'] = '';
        $dataSubskill['subskill_id'] = array();


        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'person_sjf') > 0) {
                // $sjf = explode('_',$keys[$i]);
                // echo print_r($jf[1]) . '<br>';
                // echo $keys[$i] . '<br>';
                array_push($dataSubskill['subskill_id'], $data[$keys[$i]]);
            } else {
                switch ($keys[$i]) {
                    case 'performance_level':
                        $dataEmployee['performance'] = $data[$keys[$i]];
                        break;
                    case 'code_gender':
                        $dataEmployee['gender'] = $data[$keys[$i]];
                        break;
                    case 'person_grade':
                        $dataEmployee['grade_id'] = $data[$keys[$i]];
                        break;
                    default:
                        $dataEmployee[$keys[$i]] = $data[$keys[$i]];
                }
            }
        }

        /*echo print_r($dataEmployee) . '<br>';
        echo 'kacang</br>';
        echo print_r($dataSubskill) . '<br>';
        echo 'kacang</br>';
        echo print_r($dataCompetency) . '<br>';
        die();*/

        /*for ($i = 0; $i < $arraySize; $i++) {
            if (is_array($data[$keys[$i]])){
                if ($keys[$i] == 'subskill_id'){
                    $dataSubskill[$keys[$i]] = $data[$keys[$i]];
                }else{
                    $dataCompetency[$keys[$i]] = $data[$keys[$i]];
                }
            }else{
                $dataEmployee[$keys[$i]] = $data[$keys[$i]];
            }
        }*/

        // $dataEmployee['employee_code'] = "Y" . rand(1000, 9999);

        $this->load->helper('string');

        /*echo print_r($dataEmployee) . '<br>';
        echo print_r($dataSubskill) . '<br>';
        echo print_r($dataCompetency) . '<br>';
        die();*/
        if (!main::checkBeforePost('person', $dataEmployee)) {
            $this->db->trans_begin();
            //save setting
            $db_debug = $this->db->db_debug;
            //disable debugging for queries
            $this->db->db_debug = FALSE;

            // insert into table employee
            $res = $this->db->insert('person', $dataEmployee);
            if (!$res) {
                $errormsg = 'insert into person ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'employee data save failed. ' . $this->db->error()['message'];
                } else {
                    $dataSubskill['person_id'] = $this->db->insert_id();
                    // $dataCompetency['employee_id'] = $this->db->insert_id();
                    foreach ($dataSubskill['subskill_id'] as $subskillArr) {
                        $dataSubskill['subskill_id'] = $subskillArr;
                        $res = $this->db->insert('personskill_map', $dataSubskill);
                        if (!$res) {
                            $errormsg = 'insert into personskill_map ' . $this->db->error()['message'];
                        } else {
                            if ($this->db->trans_status() === FALSE) {
                                $errormsg = 'personskill_map data save failed. ' . $this->db->error()['message'];
                            }
                        }
                    }
                }
            }
            //restore setting
            $this->db->db_debug = $db_debug;
            $this->db->trans_complete();

            $response['status'] = http_response_code();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }


        $this->response($response);
    }

    function employee_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $person_id = $data['person_id'];
        $keys = array_keys($data);
        $arraySize = count($data);
        $dataSubskill['subskill_id'] = array();

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } elseif (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                unset($data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'person_sjf') > 0) {
                // $sjf = explode('_',$keys[$i]);
                // echo print_r($jf[1]) . '<br>';
                /*echo $keys[$i] . '<br>';
                echo $data[$keys[$i]] . '<br>';*/
                array_push($dataSubskill['subskill_id'], $data[$keys[$i]]);
            } elseif (substr_count($keys[$i], 'job_') > 0) {
                $checkJob = explode('_', $keys[$i]);
                if ($checkJob[1] == 'id') {
                    $dataEmployee['job_id'] = $data[$keys[$i]];
                }
            } else {
                switch ($keys[$i]) {
                    case 'performance_level':
                        $dataEmployee['performance'] = $data[$keys[$i]];
                        break;
                    case 'code_gender':
                        $dataEmployee['gender'] = $data[$keys[$i]];
                        break;
                    case 'person_grade':
                        $dataEmployee['grade_id'] = $data[$keys[$i]];
                        break;
                    default:
                        $dataEmployee[$keys[$i]] = $data[$keys[$i]];
                }
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('person_id', $person_id)
            ->update('person', $dataEmployee);
        if (!$res) {
            $errormsg = 'update employee ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'employee data save failed. ' . $this->db->error()['message'];
            } else {
                $res = $this->db->delete('personskill_map', array('person_id' => $person_id));
                if (!$res) {
                    $errormsg = 'delete employee ' . $this->db->error()['message'];
                } else {
                    if ($this->db->trans_status() === FALSE) {
                        $errormsg = 'employee data delete failed. ' . $this->db->error()['message'];
                    } else {
                        $dataSubskill['person_id'] = $person_id;
                        // $dataCompetency['employee_id'] = $this->db->insert_id();
                        foreach ($dataSubskill['subskill_id'] as $subskillArr) {
                            $dataSubskill['subskill_id'] = $subskillArr;
                            $res = $this->db->insert('personskill_map', $dataSubskill);
                            if (!$res) {
                                $errormsg = 'insert into personskill_map ' . $this->db->error()['message'];
                            } else {
                                if ($this->db->trans_status() === FALSE) {
                                    $errormsg = 'personskill_map data save failed. ' . $this->db->error()['message'];
                                }
                            }
                        }
                    }
                }
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function employee_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $person_id = $_GET['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->delete('person', array('person_id' => $person_id));
        if (!$res) {
            $errormsg = 'update employee ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'employee data save failed. ' . $this->db->error()['message'];
            }
        }
        $res = $this->db->delete('personskill_map', array('person_id' => $person_id));
        if (!$res) {
            $errormsg = 'delete employee ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'employee data delete failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //EndCRUD for Employee

    //Start CRUD for JobSkillMap
    function jobskillmap_get()
    {
        $queryCount = 0;
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(job_id= (" . $_GET['id'] . "))";
                $this->db->select("jsm.*,ss.subskill_name")
                    ->from("jobskill_map jsm,ref_subskill ss")
                    ->where('jsm.subskill_id = ss.subskill_id')
                    ->where($whereID);
                $queryCount = 1;
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
              job_name LIKE '%" . trim($_GET['f']) . "%'
          )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select("jobskillmap_id,job_name AS job_id,subskill_name AS subskill_id")
                ->from("jobskill_map jsm,ref_job j,ref_subskill ss")
                ->where("jsm.job_id = j.job_id")
                ->where("jsm.subskill_id = ss.subskill_id")
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        if ($queryCount === 0) {
            $this->db->select("jobskillmap_id,job_name AS job_id,subskill_name AS subskill_id")
                ->from("jobskill_map jsm,ref_job j,ref_subskill ss")
                ->where("jsm.job_id = j.job_id")
                ->where("jsm.subskill_id = ss.subskill_id")
                ->where($whereID)
                ->where($whereFind);
        }


        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            } else {
                $this->db->order_by("job_id", $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function jobskillmap_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        $this->load->helper('string');

        foreach ($data['subskill_id'] as $subskillArr) {
            $data['subskill_id'] = $subskillArr;
            if (!main::checkBeforePost('jobskill_map', $data)) {
                $this->db->trans_begin();
                //save setting
                $db_debug = $this->db->db_debug;
                //disable debugging for queries
                $this->db->db_debug = FALSE;

                // insert into table pekerja
                $res = $this->db->insert('jobskill_map', $data);
                if (!$res) {
                    $errormsg = 'insert into jobskill_map ' . $this->db->error()['message'];
                } else {
                    if ($this->db->trans_status() === FALSE) {
                        $errormsg = 'jobskill_map data save failed. ' . $this->db->error()['message'];
                    }
                }
                //restore setting
                $this->db->db_debug = $db_debug;
                $this->db->trans_complete();

                $response['status'] = http_response_code();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();

                    $response['error'] = true;
                    $response['message'] = $errormsg;
                } else {
                    $this->db->trans_commit();
                    $response['error'] = false;
                    $response['message'] = 'success';
                }
            } else {
                $response['status'] = 200;
                $response['error'] = false;
                $response['message'] = 'Data Duplicate!';
            }
        }

        $this->response($response);
    }

    function jobskillmap_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $job_id = $data['job_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('job_id', $job_id)->delete('jobskill_map');
        if (!$res) {
            $errormsg = 'delete jobskill_map ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'jobskill_map data save failed. ' . $this->db->error()['message'];
            }
        }
        foreach ($data['subskill_id'] as $subskill_id) {
            $data['subskill_id'] = $subskill_id;
            $res = $this->db->insert('jobskill_map', $data);
            if (!$res) {
                $errormsg = 'insert into jobskill_map ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'jobskill_map data save failed. ' . $this->db->error()['message'];
                }
            }

            //restore setting
            $this->db->db_debug = $db_debug;

            $this->db->trans_complete();

            $response['status'] = http_response_code();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        }

        $this->response($response);
    }

    function jobskillmap_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $job_id = $data['job_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('job_id', $job_id)
            ->delete('jobskill_map');
        if (!$res) {
            $errormsg = 'delete jobskill_map ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'jobskill_map data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for JobSkillMap

    //Start CRUD for PersonSkillMap
    function personskillmap_get()
    {
        $queryCount = 0;
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(employee_id= (" . $_GET['id'] . "))";
                $this->db->select("psm.*,ss.subskill_name")
                    ->from("personskill_map psm,ref_subskill ss")
                    ->where('psm.subskill_id = ss.subskill_id')
                    ->where($whereID);
                $queryCount = 1;
            }
        }

        $whereFind = "1 = 1";
        if (!empty($_GET['f'])) {
            $whereFind = "(
              employee_name LIKE '%" . trim($_GET['f']) . "%'
          )";
        }

        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select("personskillmap_id,employee_name AS employee_id,subskill_name AS subskill_id")
                ->from("personskill_map psm,employee e,ref_subskill ss")
                ->where("psm.employee_id = e.employee_id")
                ->where("psm.subskill_id = ss.subskill_id")
                ->where($whereID)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        if ($queryCount === 0) {
            $this->db->select("personskillmap_id,employee_name AS employee_id,subskill_name AS subskill_id")
                ->from("personskill_map psm,employee e,ref_subskill ss")
                ->where("psm.employee_id = e.employee_id")
                ->where("psm.subskill_id = ss.subskill_id")
                ->where($whereID)
                ->where($whereFind);
        }


        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            } else {
                $this->db->order_by("employee_id", $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function personskillmap_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        $this->load->helper('string');

        foreach ($data['subskill_id'] as $subskillArr) {
            $data['subskill_id'] = $subskillArr;
            if (!main::checkBeforePost('personskill_map', $data)) {
                $this->db->trans_begin();
                //save setting
                $db_debug = $this->db->db_debug;
                //disable debugging for queries
                $this->db->db_debug = FALSE;

                // insert into table pekerja
                $res = $this->db->insert('personskill_map', $data);
                if (!$res) {
                    $errormsg = 'insert into personskill_map ' . $this->db->error()['message'];
                } else {
                    if ($this->db->trans_status() === FALSE) {
                        $errormsg = 'personskill_map data save failed. ' . $this->db->error()['message'];
                    }
                }
                //restore setting
                $this->db->db_debug = $db_debug;
                $this->db->trans_complete();

                $response['status'] = http_response_code();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();

                    $response['error'] = true;
                    $response['message'] = $errormsg;
                } else {
                    $this->db->trans_commit();
                    $response['error'] = false;
                    $response['message'] = 'success';
                }
            } else {
                $response['status'] = 200;
                $response['error'] = false;
                $response['message'] = 'Data Duplicate!';
            }
        }

        $this->response($response);
    }

    function personskillmap_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $employee_id = $data['employee_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('employee_id', $employee_id)->delete('personskill_map');
        if (!$res) {
            $errormsg = 'delete personskill_map ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'personskill_map data save failed. ' . $this->db->error()['message'];
            }
        }
        foreach ($data['subskill_id'] as $subskill_id) {
            $data['subskill_id'] = $subskill_id;
            $res = $this->db->insert('personskill_map', $data);
            if (!$res) {
                $errormsg = 'insert into personskill_map ' . $this->db->error()['message'];
            } else {
                if ($this->db->trans_status() === FALSE) {
                    $errormsg = 'personskill_map data save failed. ' . $this->db->error()['message'];
                }
            }

            //restore setting
            $this->db->db_debug = $db_debug;

            $this->db->trans_complete();

            $response['status'] = http_response_code();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                $response['error'] = true;
                $response['message'] = $errormsg;
            } else {
                $this->db->trans_commit();
                $response['error'] = false;
                $response['message'] = 'success';
            }
        }

        $this->response($response);
    }

    function personskillmap_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $employee_id = $data['employee_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('employee_id', $employee_id)
            ->delete('personskill_map');
        if (!$res) {
            $errormsg = 'delete personskill_map ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'personskill_map data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for SkillMap

    //Start CRUD for User Management
    function users_get()
    {
        $response['data'] = array();

        $whereID = "1 = 1";
        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $whereID = "(u.user_id='" . $_GET['id'] . "')";
            }
        }

        $whereFind = "1 = 1";
        if (isset($_GET['f'])) {
            if (!empty($_GET['f'])) {
                $whereFind = "( user_id LIKE '%" . trim($_GET['f']) . "%' ) OR ( nama LIKE '%" . trim($_GET['f']) . "%' ) OR ( email LIKE '%" . trim($_GET['f']) . "%' )";
            };
        };

        $whereStatus = "1 = 1";
        if (isset($_GET['s'])) {
            if (!empty($_GET['s'])) {
                $whereStatus = "(act_sts='" . $_GET['s'] . "')";
            };
        };


        $num_results = 1;
        if (isset($_GET['p'])) {
            $this->db->select('u.user_id')
                ->from('users u')
                ->join('ref_usergrp rug', 'u.usergrp_id = rug.usergrp_id', 'LEFT')
                ->where($whereID)
                ->where($whereStatus)
                ->where($whereFind);
            $num_results = $this->db->count_all_results();
        }

        $this->db->select('u.user_id,u.email,u.nama,rug.usergrp_id, rug.usergrp_name, u.actsts')
            ->from('users u')
            ->join('ref_usergrp rug', 'u.usergrp_id = rug.usergrp_id', 'LEFT')
            ->where($whereID)
            ->where($whereStatus)
            ->where($whereFind);

        if (isset($_GET['p'])) {
            $offset = ($_GET['l'] * $_GET['p']) - $_GET['l'];
            $this->db->limit($_GET['l'], $offset);
        }

        if (isset($_GET['ordBy'])) {
            if (!empty($_GET['ordBy'])) {
                $this->db->order_by($_GET['ordBy'], $_GET['ordType']);
            }
        }

        $resp = main::excRequest();
        $resp['recordsFiltered'] = $num_results;

        $this->response($resp);
    }

    function users_post()
    {
        $response['data'] = array();
        $data = $this->input->post();
        $keys = array_keys($data);
        $arraySize = count($data);
        $createdDate = date("Y-m-d H:i:s");


        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            } else {
                if (($data[$keys[$i]] == '') || ($data[$keys[$i]] == '99')) {
                    unset($data[$keys[$i]]);
                }
            }
        }

        $this->load->helper('string');

        if ($data['pword'] == $data['pword_check']) {
            unset($data['pword_check']);
            $data['pword'] = md5($data['pword']);
            $data['app'] = 'career';
            if (!main::checkBeforePost('users', $data)) {
                $this->db->trans_begin();
                //save setting
                $db_debug = $this->db->db_debug;
                //disable debugging for queries
                $this->db->db_debug = FALSE;

                // insert into table pekerja
                $res = $this->db->insert('users', $data);
                if (!$res) {
                    $errormsg = 'insert into users ' . $this->db->error()['message'];
                } else {
                    if ($this->db->trans_status() === FALSE) {
                        $errormsg = 'users data save failed. ' . $this->db->error()['message'];
                    }
                }
                //restore setting
                $this->db->db_debug = $db_debug;
                $this->db->trans_complete();

                $response['status'] = http_response_code();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();

                    $response['error'] = true;
                    $response['message'] = $errormsg;
                } else {
                    $this->db->trans_commit();
                    $response['error'] = false;
                    $response['message'] = 'success';
                }
            }
        } else {
            $response['status'] = 200;
            $response['error'] = false;
            $response['message'] = 'Data Duplicate!';
        }
        $this->response($response);
    }

    function users_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $user_id = $data['user_id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        unset($data['pword_check']);
        $data['pword'] = md5($data['pword']);

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('user_id', $user_id)
            ->update('users', $data);
        if (!$res) {
            $errormsg = 'update users ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'users data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }

    function users_delete()
    {
        parse_str(file_get_contents("php://input"), $data);
        $user_id = $_GET['id'];
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->where('user_id', $user_id)
            ->delete('users', $data);
        if (!$res) {
            $errormsg = 'delete users ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'users data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End CRUD for User Management

    //Start Parameter
    function parameter_get()
    {
        $response['data'] = array();
        $this->db->from("ref_parameter");

        $resp = main::excRequest();

        $this->response($resp);
    }

    function parameter_put()
    {
        parse_str(file_get_contents("php://input"), $data);
        $keys = array_keys($data);
        $arraySize = count($data);

        for ($i = 0; $i < $arraySize; $i++) {
            if ($keys[$i] == 'form_method') {
                unset($data[$keys[$i]]);
            }
        }

        $this->db->trans_begin();
        //save setting
        $db_debug = $this->db->db_debug;
        //disable debugging for queries
        $this->db->db_debug = FALSE;
        $res = $this->db->update('ref_parameter', $data);
        if (!$res) {
            $errormsg = 'update parameter ' . $this->db->error()['message'];
        } else {
            if ($this->db->trans_status() === FALSE) {
                $errormsg = 'users data save failed. ' . $this->db->error()['message'];
            }
        }

        //restore setting
        $this->db->db_debug = $db_debug;
        $this->db->trans_complete();

        $response['status'] = http_response_code();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();

            $response['error'] = true;
            $response['message'] = $errormsg;
        } else {
            $this->db->trans_commit();
            $response['error'] = false;
            $response['message'] = 'success';
        }

        $this->response($response);
    }
    //End Parameter
    //End ALVIN
}
