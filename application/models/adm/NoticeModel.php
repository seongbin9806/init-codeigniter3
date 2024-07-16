<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NoticeModel extends CI_Model {
        
    public function __construct(){
        parent::__construct();
    }
    
    function send($data){
        $sql = "
            INSERT INTO
                notice
			 SET
                `reNoticeId` = ?,
                `noticeType` = ?,
                `mbName` = ?,
                `password` = password(?),                
                `title` = ?,
                `content` = ?,
                `regDate` = NOW();
        ";
        
        return $this->db->query($sql, $data);
    }
    
    function reSend($data){
        $sql = "
            INSERT INTO
                notice
			 SET
                `reNoticeId` = ?,
                `noticeType` = ?,
                `mbName` = ?,
                `password` = ?,
                `title` = ?,
                `content` = ?,
                `regDate` = NOW();
        ";
        
        return $this->db->query($sql, $data);
    }
    
    function checkNoticePwd($noticeId, $password){
        $sql = "
             SELECT
                 noticeId
             FROM
                 notice
             WHERE
                 noticeId = ? AND
                 password = password(?);
        ";
        
        $data = array(
            $noticeId,
            $password
        );
        
        $query = $this->db->query($sql, $data);
        return $query->row_array();        
    }
    
    function getNoticeListAndCnt($page, $pagingCount, $noticeType, $searchType, $searchTxt){
        
        $searchSql = " reNoticeId = 0 AND noticeType = '{$noticeType}' AND ";
        
        if(!empty($searchType) && !empty($searchTxt)){
            $searchSql .= "{$searchType} LIKE '%{$searchTxt}%' AND ";
        }
        
        $limit = getPageLimit($page, $pagingCount);
        
        $sql = "
             SELECT
                 *
             FROM
                 notice
             WHERE
                 $searchSql
                 isUse = 'Y'
             ORDER BY
                noticeId DESC
             LIMIT
                $limit, $pagingCount;
        ";
        
        $query = $this->db->query($sql);
        $list = $query->result_array();
		
		for($i=0; $i<count($list); $i++){
			$row = $list[$i];            
            $row['regDate'] = substr($row['regDate'], 2, 8);
            
			$list[$i] = $row;
		}
        
        /* 리스트 갯수 */
        $sql = "
             SELECT
                 COUNT(*) AS cnt    
             FROM
                 notice
            WHERE
                 $searchSql               
                 isUse = 'Y';
        ";
        
        $query = $this->db->query($sql);
        $totalCnt = $query->row_array()['cnt'];
        
        return [
            'list' => $list,
            'totalCnt' => $totalCnt
        ];
    }
    
    function getNoticeInfo($noticeId){        
        $sql = "
             SELECT
                 *
             FROM
                 notice
            WHERE
                 noticeId = ?;
        ";
        
        $query = $this->db->query($sql, array($noticeId));
        return $query->row_array();
    }
    
    function getReNoticeInfo($noticeId){        
        $sql = "
             SELECT
                 *
             FROM
                 notice
            WHERE
                 reNoticeId = ?;
        ";
        
        $query = $this->db->query($sql, array($noticeId));
        return $query->row_array();
    }
    
    function checkNoticeAuth($noticeId, $password){
         $sql = "
             SELECT
                 noticeId
             FROM
                 notice
             WHERE
                 `noticeId` = ? AND
                 `password` = password(?);
        ";
        
        $data = array(
            $noticeId,
            $password
        );
        
        $query = $this->db->query($sql, $data);        
        return $query->row_array();
    }
}