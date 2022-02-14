<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class main extends CI_Controller {
    function __construct() {        
        parent::__construct();
    }

    static function isTokenExpired($token){
        $main =& get_instance();
        $skr = date("Y-m-d H:i:s"); 
        //tdk menggunakan fungsi GETDATE(), krn GETDATE()(mssql) dan date()(PHP) resultnya tdk selalu sama.
        $main->db->select("TIMESTAMPDIFF(MINUTE,a.login_time, '$skr') AS menit, a.app, a.nama, a.user_id, a.usergrp_id, b.usergrp_name, a.email")
                    ->from('users a')
                    ->join('ref_usergrp b', 'a.usergrp_id = b.usergrp_id', 'left')
                    ->where('token', $token);

        $data = $main->db->get()->result();
        if($data){
            /*if($data[0]->menit > 200){
                //expired 
                $main->session->sess_destroy();
                
                $response['error'] = true;
                $response['status'] = 440;
                $response['message'] = 'Token expired!';
                $response['data'] = array();
                $response['recordsTotal'] = 0;
                $response['recordsFiltered'] = 0; 
                $response['length'] = 0; 
                $main->response($response);
                die();
            } else */return $data;
        } else return array();
    }

    static function isRecordExist($field,$table,$where){  
    	      $main =& get_instance(); 
            $main->db->select($field)
                ->from($table)
                ->where($field, $where);  
                
            return ($main->db->count_all_results() == 0) ? false : true;       	
    }	 
    
    static function checkBeforePost($table,$data){  
    	$where = [];   	
      $keys  = array_keys($data);   	
      for( $i=0; $i < count($data); $i++ ) {
        if (($keys[$i] == 'user_id') || ($keys[$i] == 'created_by') || ($keys[$i] == 'created_at') || ($keys[$i] == 'created_from')) {          
          unset($data[$keys[$i]]);
        } ; 
      };
      $where = $data ;
    	$main =& get_instance(); 
            $main->db->select()
                 ->from($table)
                 ->where($where);      	
    	//$main->db->get_where($table,$where);

      return ($main->db->count_all_results() == 0) ? false : true;       	
    }	      
    
    static function excRequest(){
        $main =& get_instance();
        $response['status'] = http_response_code();
        if($query = $main->db->get()){
            //$response['status'] = http_response_code();
            $response['message'] = 'success';
            $response['error'] = false;
            $response['data'] = $query->result();
            $response['recordsTotal'] = $query->num_rows();
            $response['recordsFiltered'] = $query->num_rows(); 
            $response['length'] = $query->num_rows(); 
        } else {
            //$response['status'] = http_response_code();
            $response['message'] = 'failure';
            $response['error'] = true;
        };
        return $response;
    }

    static function excRequestSQL($sql, $select=true){
        $main =& get_instance();
        $response['status'] = http_response_code();
        if($query = $main->db->query($sql)){
            //$response['status'] = http_response_code();
            $response['message'] = 'success';
            $response['error'] = false;
            if($select) {
                $response['data'] = $query->result();
                $response['recordsTotal'] = $query->num_rows();
                $response['recordsFiltered'] = $query->num_rows(); 
                $response['length'] = $query->num_rows(); 
            };
        } else {
            //$response['status'] = http_response_code();
            $response['message'] = 'failure';
            $response['error'] = true;
        };
        return $response;
    }

    static function normalizeDate($dmY){
        $dmY_arr = explode('-', $dmY);
        return $dmY_arr[2].'-'.$dmY_arr[1].'-'.$dmY_arr[0];
    }

}

?>