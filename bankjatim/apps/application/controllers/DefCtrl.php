<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class defctrl extends CI_Controller {
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

        $this->auth = $this->session->userdata($this->config->item('app_name'));
        //memaksa keluar jika tidak melakukan login
        if(!isset($this->auth['data']['user_id'])) {
            header("Location: " . $this->host . "signin");
            die();
        } else {
            $this->smartyci->assign('auth', $this->auth);
            $this->smartyci->assign('token', $this->auth['token']);
        };
    }

    function index(){
        redirect('/'.$this->auth['data']['app']); 
    } 
}

?>