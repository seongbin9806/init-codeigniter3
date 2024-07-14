<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {    
    
	public function __construct(){
       	parent::__construct();
    }        
    
    public function login()
    {
        $result = array('result' => false, 'msg' => "");
        
        $id = $_POST['id'];
        $password = $_POST['password'];
        
        if(!($id == 'admin' && $password == 'admin0808')){
            $result['msg'] = "아이디 혹은 비밀번호가 일치하지않습니다.";
            die(json_encode($result));
        }
                
        $userData = array(
            'id' => $id,
            'maName' => '최고관리자',
            'role' => 'admin'
        );
        
        $this->session->set_userdata('user', $userData);
        $result['result'] = true;
        
        die(json_encode($result));
    }
    
    public function logout()
    {
        session_start();
        session_destroy();
        
        header("Location: {$this->config->item('baseUrl')}/admin/login");
    }
}
