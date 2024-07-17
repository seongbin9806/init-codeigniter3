<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $user = array();
    public $title = "";
    public $pageId = "";
    
	public function __construct(){
       	parent::__construct();
		
		$this->load->config('common');
        $this->user = $this->session->userdata('user');
    }
	
	public function index()
	{
        $viewData = array();
        
        $this->pageId = 'home';
        		        
        $this->load->view('/common/header');
		$this->load->view('/home', $viewData);
        $this->load->view('/common/footer');
	}
}
