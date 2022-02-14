<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

require APPPATH . 'libraries/REST_Controller.php';
require_once("Main.php");

class signin extends REST_Controller{
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

    function login_post(){ 
        $this->load->helper('string');
        $response['data'] = array(); 

        $this->db->select("a.user_id, a.email, a.pword, a.nama, a.usergrp_id, b.usergrp_name, LOWER(b.app) app, c.nama_app, '' resetPword, b.usergrp_desc")
            ->from('users AS a')
            ->join('ref_usergrp AS b', 'a.usergrp_id = b.usergrp_id', 'left')
            ->join('ref_apps AS c', 'LOWER(a.app) = LOWER(c.app)', 'left')
            ->where("(a.email = '".$this->input->post('usernm')."' OR a.user_id = '".$this->input->post('usernm')."')")
            ->where('a.actsts', true);
        $data = $this->db->get()->result();

        if(count($data) > 0){
            if(md5($this->input->post('pword')) == $data[0]->pword){
                $response['data'][0] = $data[0];
                unset($response['data'][0]->pword);
                $token = random_string('alnum', 100);
                
                //update user login activity begin
                $data = array(
                    'token' => $token,
                    'device_reg' => $_SERVER['REMOTE_ADDR'],
                    'login_time' => date("Y-m-d H:i:s")
                );  
                $this->db->trans_begin();
                $this->db->where('user_id', $this->input->post('usernm'));
                $this->db->update('users', $data);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                };
                //update user login activity end
                $response['data'][0]->menu = $this->getMenu($response['data'][0]->app, $response['data'][0]->usergrp_id);

                $resp_msg = 'accepted';
                $resp_err = false;
            } else {
            	  $token = '';
            	  $resp_msg = 'incorrect username or password.';
            	  $resp_err = true;
            };
        } else {
        	  $token = '';
        	  $resp_msg = 'incorrect username or password.';
        	  $resp_err = true;
        };
        
        $response['token']   = $token;
        $response['status']  = http_response_code();
        $response['message'] = $resp_msg;
        $response['error']   = $resp_err;
        
        $this->response($response);
    }    
    
    function getMenu($app, $grpID){
        $this->db->select('c.mn_name parent, c.mn_icon icon_parent, b.mn_name, b.mn_desc, b.mn_icon, a.target, d.grp_cat_desc AS catg')
        ->from('menu_grp AS a')
        ->join('menu AS b', 'b.mn_id = a.mn_id', 'left')
        ->join('menu AS c', 'c.mn_id = b.mn_id_parent', 'left')
        ->join('menu_grp_catagory AS d', 'd.grp_cat_id = b.mn_catg', 'left')  
        ->where('a.usergrp_id', $grpID)
        ->where('b.mn_id IS NOT NULL', null)
        ->where('b.mn_sts', 1)
        ->order_by('d.grp_cat_order', 'ASC')   
        //->order_by('b.mn_id_parent', 'ASC')
        ->order_by('a.smn_order', 'ASC');

        $data = main::excRequest();
       // echo $this->db->last_query(); die();
        return $data['data'];
    }    

    function chgPwd_put(){
        if(isset($_GET['token'])){
            $data = main::isTokenExpired($_GET['token']);
            $this->clientID = $data[0]->user_id;
            if($data[0]->menit > 120){
                $response['status'] = http_response_code();
                $response['message'] = 'Token expired!';
                $response['error'] = true;
                $this->response($response);
                die();
            };
        } else {
            $response['status'] = http_response_code();
            $response['message'] = 'Token is required!';
            $response['error'] = true;
            $this->response($response);
            die();
        };

        $response['data'] = array(); 
        parse_str(file_get_contents("php://input"), $data);
        
        //mengganti password
        $this->db->trans_begin();
        $this->db->where('user_id', $this->clientID);
        $data = array('pword' => md5($data['pword'])); 
        $this->db->update('users', $data);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $response['status'] = http_response_code();
            $response['message'] = 'failure';
            $response['error'] = true;
        } else {
            $this->db->trans_commit();
            $response['status'] = http_response_code();
            $response['message'] = 'success';
            $response['error'] = false;
        };

        $this->response($response);
    }
}
?>