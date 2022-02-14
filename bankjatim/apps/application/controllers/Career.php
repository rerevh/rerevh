<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class career extends CI_Controller {
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

        $this->smartyci->assign('content', '');
    }

    function index(){ 
        $this->smartyci->assign('modul_title', 'Dashboard');
        $this->smartyci->assign('modul_desc', 'Quick Information');
        $this->smartyci->assign('modul', 'home'); //menjalankan halaman default secara manual
        $this->smartyci->display('index.html');
    } 

    function sModule($mod='home'){
        if ($this->auth['data']['usergrp_id'] == 1){
            $menu_name = '';
            foreach ($this->auth['data']['menu'] as $k => $v) {
                if($v['target'] == $mod) {
                    $menu_name = $v['mn_name'];
                    $menu_desc = $v['mn_desc'];
                }
            };
            $this->smartyci->assign('act', '');
            $this->smartyci->assign('modul_title', $menu_name);
            $this->smartyci->assign('modul_desc', $menu_desc);
            $this->smartyci->assign('modul', $mod);
            $this->smartyci->assign('content', "$mod.html");
            $this->smartyci->display('index.html');
        }else{
            $this->smartyci->assign('act', '');
            $this->smartyci->assign('modul', $mod);
            $this->smartyci->assign('content', "$mod.html");
            $this->smartyci->display('index.html');
        }
    }      

    function view($mod){
        $this->smartyci->assign('modul', $mod);
        $this->smartyci->assign('act', 'view');
        $this->smartyci->display('index.html');
    }           
}

?>