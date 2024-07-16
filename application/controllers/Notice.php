<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {

    public $user;
    public $title;
    public $pageId;
    
    /* notice */
    public $noticeTypeItem;
    public $initType;
    
	public function __construct(){
       	parent::__construct();
        
        $this->user = $this->session->userdata('user');        
        $this->load->model('/adm/noticeModel');
        
        $this->noticeTypeItem = $this->config->item('noticeType');
        $this->initType = $this->noticeTypeItem['contact']['type'];                
    }
	
	public function index()
	{        
        $noticeType = empty($_GET['type'])? $this->initType : $_GET['type'];                
        
        $page = empty($_GET['page'])? 1 : $_GET['page'];
        $pagingCount = 10;
        $searchType = empty($_GET['searchType'])? '' : $_GET['searchType'];
        $searchTxt = empty($_GET['searchTxt'])? '' : $_GET['searchTxt'];
        
        if(!isset($this->noticeTypeItem[$noticeType])){
            header("Location: {$this->config->item('baseUrl')}/notice");
            exit;
        }
        
        $this->title = $this->noticeTypeItem[$noticeType]['title'];
        $this->pageId = $this->noticeTypeItem[$noticeType]['type'];        
        $viewData = array();
        
        /* 게시글 정보 가져오기 */
        $noticeInfo = $this->noticeModel->getNoticeListAndCnt($page, $pagingCount, $noticeType, $searchType, $searchTxt);                        
        
        /* 답변글 체크 */
        for ($index = 0; $index < count($noticeInfo['list']); $index++) {
            $notice = $noticeInfo['list'][$index];
            $info = $this->noticeModel->getReNoticeInfo($notice['noticeId']);

            if (!empty($info)) {
                $info['regDate'] = substr($info['regDate'], 2, 8);
                array_splice($noticeInfo['list'], $index + 1, 0, [$info]);
                $index++; // 추가된 요소를 건너뛰기 위해 인덱스 증가
            }
        }
        
        $viewData['pageData'] = array(
            'totalCnt' => $noticeInfo['totalCnt'],
            'page' => $page,
            'pagingCount' => $pagingCount,
            'noticeType' => $this->noticeTypeItem[$noticeType]['type']
        );
        
        $viewData['searchData'] = array(
            'searchType' => $searchType,
            'searchTxt' => $searchTxt
        );
                
        $viewData['list'] = $noticeInfo['list'];
        		        
        $this->load->view('/common/header');
		$this->load->view('/notice/list', $viewData);
        $this->load->view('/common/footer');
	}
    
    public function send()
    {
        $viewData = array();
        
        $noticeType = $this->uri->segment(3, $this->initType);
        
        if(!isset($this->noticeTypeItem[$noticeType])){
            header("Location: {$this->config->item('baseUrl')}/notice");
            exit;
        }
        
        $this->title = $this->noticeTypeItem[$noticeType]['title'].' 작성';
        $this->pageId = $noticeType;
        
        $viewData['noticeType'] = $noticeType;
        
		$this->load->view('/common/header');
		$this->load->view('/notice/send', $viewData);
		$this->load->view('/common/footer');
    }
    
    public function view()
    {
        $viewData = array();
        
        $noticeId = $_POST['noticeId'];
        $password = $_POST['password'];        
        
        if(empty($this->user)){
            $checkInfo = $this->noticeModel->checkNoticeAuth($noticeId, $password);        
        
            if(empty($checkInfo)){
                header("Location: {$this->config->item('baseUrl')}/notice");            
                exit;
            }
        }
        
        $noticeInfo = $this->noticeModel->getNoticeInfo($noticeId);
        
        /* 답변 체크여부 */
        $noticeInfo['isAnswer'] = false;
        if(!empty($this->user) && $this->user['role'] == 'admin' && $noticeInfo['reNoticeId'] == 0){
            $info = $this->noticeModel->getReNoticeInfo($noticeId);
            
            if(!empty($info)){
                $noticeInfo['isAnswer'] = true;
            }
        }
        
        $noticeInfo['regDate'] = substr($noticeInfo['regDate'], 2, 14);        
        $viewData['noticeInfo'] = $noticeInfo;
                
        $this->title = $this->noticeTypeItem[$noticeInfo['noticeType']]['title'].' 확인';
        $this->pageId = $noticeInfo['noticeType'];
        
		$this->load->view('/common/header');
		$this->load->view('/notice/view', $viewData);
		$this->load->view('/common/footer');
    }
}
