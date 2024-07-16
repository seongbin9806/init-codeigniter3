<?

/* 파일 업로드 */
function cmmFileUpload($files, $width = 0) {            
    // Gumlet ImageResize 라이브러리 로드
    require_once(APPPATH . 'third_party/php-image-resize-master/ImageResize.php');    
    
    $fileArr = array();
    $filesLength = count($files['name']);      
    $folderDir = "assets/upload";

    // 모든 파일을 순회하면서 업로드 처리
    for($index = 0; $index < $filesLength; $index++) {
        $uploadsDir = FCPATH . $folderDir; // 업로드 경로
        $originalFileName = $files['name'][$index]; // 원본 파일 이름

        // 파일 확장자 추출
        $parts = explode('.', $originalFileName);
        $ext = array_pop($parts);

        // 유니크한 파일 이름 생성
        $num = sprintf("%06d", rand(0, 9999));
        $fileName = strtotime("Now") . '_' . $num . '_' . $index . '.' . $ext;
        $filePath = $uploadsDir . '/' . $fileName;

        // 파일 이동 및 업로드 성공 시
        if(move_uploaded_file($files['tmp_name'][$index], $filePath)) {                        
            $fileType = explode('/', $files['type'][$index])[0]; // 파일 타입 (image, video 등)

            // 이미지 파일일 경우 크기 조정
            if($fileType == 'image') {                
                $resizeImg = new \Gumlet\ImageResize($filePath);
                
                if($width) {
                    $resizeImg->resizeToWidth($width);   
                }
                
                $resizeImg->save($filePath);
            }
            
            // 업로드된 파일 정보를 배열에 저장
            $fileArr[] = array(
                'ext' => $ext,
                'fileType' => $fileType,
                'fileName' => $fileName,
                'originalFileName' => $originalFileName
            );
        }
    }
    
    return $fileArr; // 업로드된 파일 정보 배열 반환
}

function getTableNumber($page, $pagingCount, $count){
    return number_format(($page - 1) * $pagingCount + $count + 1);
}

function getPageLimit($page, $pagingCount){
    return ((int)$page - 1) * $pagingCount;
}

function getMaxPage($totalCount, $pagingCount){        
    $maxPage = ceil($totalCount / $pagingCount);
    if($maxPage == 0) $maxPage = 1;
    
    return $maxPage;
}

function getPrevPage($page){
    if($page == 1) return $page;
    
    return ($page - 1);
}

function getNextPage($page, $maxPage){
    if($page == $maxPage) return $page;
    
    return ($page + 1);
}

function getCenterPage($page, $maxPage){
    
    $maxCenterCnt = 5; // 버튼 페이징 갯수        
    $betweenCnt = floor($maxCenterCnt / 2);
    $initPage = ($page - $betweenCnt);
    $conditionPage = ($page + $betweenCnt);
    
    if($initPage <= 0) $conditionPage = $maxCenterCnt;
    if($conditionPage > $maxPage) $initPage -= ($conditionPage - $maxPage);
    
    $pageArr = array();
            
    for($p = $initPage; $p <= $conditionPage; $p++){ 
        if($p <= 0 || $p > $maxPage) continue;            
        $pageArr[] = (int)$p;
    }
    
    return $pageArr;
}
    
function getQueryString($queryString){
    $queryArr = explode('&', $queryString);

    $resultQuery = array();
    for($i=0; $i<count($queryArr); $i++){            
        if(explode('=', $queryArr[$i])[0] == 'page') continue;
        
        $resultQuery[] = $queryArr[$i];
    }

    $resultString = implode('&', $resultQuery);
    if($resultString){
        return '&'.$resultString;
    }
    
    return '';
}

function combinePage($page, $queryString){
    return '?page='.$page.$queryString;
}