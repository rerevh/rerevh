<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class signin  extends CI_Controller {
    function __construct() {        
        parent::__construct();
        $this->load->library('smartyci');

        $this->host = $this->config->item('base_url');
        $this->smartyci->assign('host', $this->host);
        $this->smartyci->assign('app_title', $this->config->item('app_title'));
        $this->smartyci->assign('app_name', $this->config->item('app_name'));
        $this->smartyci->assign('dev_year', $this->config->item('dev_year'));
        $this->smartyci->assign('developer', $this->config->item('developer'));
        $this->smartyci->assign('provider', $this->config->item('provider'));
        $this->smartyci->assign('provider_site', $this->config->item('provider_site'));
        $this->smartyci->assign('API_host', $this->config->item('API_host'));
    }

    function index(){
        $this->smartyci->display('login.html');
    } 

    function resetPassword(){ 
        $this->smartyci->display('resetPassword.html'); 
    } 
   
    function saveLoginData(){
        $data = $this->input->post();
        $this->session->set_userdata($this->config->item('app_name'), $data);
        echo json_encode(Array(
            'msg' => 'done'
        ));
    }

    function clearLoginData(){
        $this->session->unset_userdata($this->config->item('app_name'));
        $this->session->sess_destroy();
        echo json_encode(Array(
            'msg' => 'done'
        ));
    }


    function testReadSession($sessionNm){
        $data = $this->session->get_userdata($sessionNm);
        echo '<pre>';
        print_r($data);
    }

}

?>