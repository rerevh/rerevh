<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

require APPPATH . 'libraries/REST_Controller.php';
require_once("Main.php");

class pub extends REST_Controller{
// constructor
    function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        parent::__construct();
    }

    function index_get(){
        $response['status'] = http_response_code();
        $response['error'] = false;
        $response['message'] = 'You are accessing API';
        $this->response($response);
    }
    
    function reference_get(){       
       $ref = explode("_",$_GET['ref']);    
       
       switch ($ref[0]) {
          case "employee":
            if(isset($_GET['sorted'])){
                if(!empty($_GET['sorted']))
                    $sort = 'employee_name';
                else $sort = 'employee_id';
            } else $sort = 'employee_name';

            $response['data'] = array(); 
            $fieldselect = 'employee_id as id ,CONCAT(employee_name," ","[",employee_no,"]")  as text';
            $this->db->select($fieldselect)
                ->from($ref)
                ->order_by($sort);             
            break;
          case "jobgrade":
            $response['data'] = array();
            $this->db->select('g.grade_id as id, g.jobgrade AS text')
              ->from('ref_grade g')
              ->group_by('g.jobgrade')
              ->order_by('g.grade_id', 'ASC');
            break;
          case "persongrade":
               $response['data'] = array();
               $this->db->select('g.grade_id as id, g.grade AS text')
                   ->from('ref_grade g')
                   ->group_by('g.grade')
                   ->order_by('g.grade_id', 'ASC');
               break;
          case "grade":
            $table = ($ref[1]=='person') ? $ref[1] : 'ref_'.$ref[1]; 
            if(isset($_GET['sorted'])){
                if(!empty($_GET['sorted']))
                    $sort = $ref[1].'_id';
                else $sort = $ref[1].'_name';
            } else $sort = $ref[1].'_id';

            $response['data'] = array(); 
            $fieldselect = 'CONCAT('.$ref[1].'_id'.",'_'".',g.grade) as id, RTRIM('.$ref[1].'_name) as text';
            $this->db->select($fieldselect)
                ->from($table)
                ->from('ref_grade g')
                ->where($table.'.grade_id','g.grade_id', FALSE)
                ->order_by($sort);             
            break;            
          case "code":
            if(isset($_GET['sorted'])){
                if(!empty($_GET['sorted']))
                    $sort = $_GET['sorted'];
                else $sort = 'value';
            } else $sort = 'value';
           
            $fieldselect = 'value as id, RTRIM(text) as text';
            $this->db->select($fieldselect)
                ->from('ref_code')
                ->where('group', $ref[1])
                ->where('flag', 'T')
                ->group_by('text')
                ->order_by($sort);                
            break;            
          default:       
            if(isset($_GET['sorted'])){
                if(!empty($_GET['sorted']))
                    $sort = $ref[0].'_name';
                else $sort = $ref[0].'_id';
            } else $sort = $ref[0].'_id';

            $response['data'] = array(); 
            $fieldselect = 'DISTINCT('.$ref[0].'_id) as id, RTRIM('.$ref[0].'_name) as text';
            $this->db->select($fieldselect)
                ->from('ref_'.$ref[0])
                ->order_by($sort);                                       
        };   
                
        
                
        $this->response(main::excRequest());
    }
       
    function fillReference_get(){    
    	  $response['data'] = array(); 

        $whereForm = "1 = 1";
        if(isset($_GET['form_name'])){
            if(!empty($_GET['form_name'])){
                $whereForm = "(form_name = '".$_GET['form_name']."')";
            };
        };
        
        $wherePreload = "1 = 1";
        if(isset($_GET['preload'])){
            if(!empty($_GET['preload'])){
                $wherePreload = "(preload = '".$_GET['preload']."')";
            };
        };             	 
    	    
        $this->db->select("form_name, form_object ,table, filter, target, value, colset") 
            ->from('form_references')
            ->where($whereForm)
            ->where($wherePreload)
            ->order_by('id', 'ASC');

        $this->response(main::excRequest());        
    }
    
    
    function transpose_get() {
       $this->db->select('person_number');
       $this->db->from('person'); 
       $query=$this->db->get();  
       
       $i=0;$j=1;
       foreach ($query->result_array() as $row) {
          $i++; 
         if  ($i <= 5) {
          	$resp[$j]['person_no_'.$i]  = $row['person_number']; 
          } else {
          	$i=1;
          	$j++; 
          	$resp[$j]['person_no_'.$i]  = $row['person_number']; 
          }                    
       } 	   
               
       $resp['error'] = true;
       $resp['status'] = http_response_code();
       $resp['message'] = 'Successs';                  
	      
	     $this->response($resp);
    }       

}
?>