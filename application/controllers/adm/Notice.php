<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice extends CI_Controller {    
    
	public function __construct(){
       	parent::__construct();
        
        $this->load->model('/adm/noticeModel');
    }
    
    public function send()
    {
        $result = array('result' => false, 'msg' => "");
    
        $reNoticeId = 0;
        $noticeType = $_POST['noticeType'];
        $mbName = $_POST['mbName'];
        $password = $_POST['password'];        
        $title = $_POST['title'];
        $content = $_POST['content'];        
        
        $sendData = array(
            $reNoticeId,
            $noticeType,
            $mbName,
            $password,
            $title,
            $content
        );
        
        $result['result'] = $this->noticeModel->send($sendData);                
        
        if(empty($result['result'])){
            $result['msg'] = "등록실패";
        }
        
        die(json_encode($result));
    }
    
    public function sendAnswer()
    {
        $result = array('result' => false, 'msg' => "");
            
        $noticeId = $_POST['noticeId'];        
        $noticeInfo = $this->noticeModel->getNoticeInfo($noticeId); 
        
        $reNoticeId = $noticeId;
        $noticeType = $noticeInfo['noticeType'];
        $mbName = '관리자';
        $password = $noticeInfo['password'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        
        $sendData = array(
            $reNoticeId,
            $noticeType,
            $mbName,
            $password,
            $title,
            $content
        );
        
        $result['result'] = $this->noticeModel->reSend($sendData);                
        
        if(empty($result['result'])){
            $result['msg'] = "등록실패";
        }
        
        $result['noticeInfo'] = $noticeInfo;
        
        die(json_encode($result));
    }
    
    public function checkNoticePwd()
    {
        $result = array('result' => false, 'msg' => "");
        
        $noticeId = $_POST['noticeId'];
        $password = $_POST['password'];
        
        $info = $this->noticeModel->checkNoticePwd($noticeId, $password); 
        
        if(empty($info)){
            $result['msg'] = "비밀번호가 일치하지 않습니다.";
            die(json_encode($result));
        }
        
        $result['result'] = true;
        
        die(json_encode($result));
    }
}
