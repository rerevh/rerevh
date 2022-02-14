<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

require APPPATH . 'libraries/REST_Controller.php';
require_once("Main.php");

class action extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

        parent::__construct();

        if(isset($_GET['token'])){
            $data = main::isTokenExpired($_GET['token']);
            if($data){
                $this->clientAPP = $data[0]->app;
                $this->clientID = $data[0]->user_id;
                $this->clientGrp = $data[0]->usergrp_id;
                $this->userGrp = $data[0]->usergrp_name;
                if($data[0]->menit > 120){
                    $response['error'] = true;
                    $response['status'] = http_response_code();
                    $response['message'] = 'Token expired!';
                    $this->response($response);
                    die();
                };
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

    public function index_get(){
        $response['status'] = http_response_code();
        $response['error'] = false;
        $response['message'] = 'You are accessing API';

        $this->response($response);
    }
     
    function imageUpload_get(){
        $response['status'] = 200;
        $response['message'] = 'success';
        $response['error'] = false;
        $response['recordsFiltered'] = 1;

        $response['data'] = array(); 
        $path = "docs/".$_GET['folder']."/".$_GET['idMetaData']."/"; 
        if(is_dir($path)){ 
            $files = array_diff(scandir($path), array('.', '..')); 
            $newFiles = [];
            foreach ($files as $kk => $vv) {
                $y = explode('-', $vv);
                $newFiles[$y[0]] = $vv;
            };
            $files = $newFiles;

            $response['data'][0]['pic_path'] = $this->config->item('base_url').$path;
            $response['data'][0]['pictures'] = $files;
        } else {
            $response['data'][0]['pic_path'] = '';
            $response['data'][0]['pictures'] = '';        	
        };
        $this->response($response);
    }  
               
}
?>