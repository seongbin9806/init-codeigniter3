<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public $user;
    public $isLoginPage = false;
    
	public function __construct(){
       	parent::__construct();
        
        $this->load->helper('auth');        
        $this->user = $this->session->userdata('user');            
                
        AdminAuth();
    }
    
    public function index()
    {
        $viewData = array();
                
		$this->load->view('/admin/common/header');
		$this->load->view('/admin/home', $viewData);
		$this->load->view('/admin/common/footer');
    }
	
	public function login()
	{
        $viewData = array();
        
        $this->isLoginPage = true;
        
		$this->load->view('/admin/common/header');
		$this->load->view('/admin/login', $viewData);
		$this->load->view('/admin/common/footer');
	}
}
