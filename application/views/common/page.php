<!--
    totalCnt
    page
    pagingCount
-->

<?
    $maxPage = getMaxPage($totalCnt, $pagingCount);
    $prevPage = getPrevPage($page);
    $nextPage = getNextPage($page, $maxPage);
    $pageArr = getCenterPage($page, $maxPage);        
    $queryString = getQueryString($_SERVER['QUERY_STRING']);
    $combinPage = combinePage($page, $queryString);
?>
<div id="page">
    <? if($page != 1){ ?>
        <a href="<?=combinePage($prevPage, $queryString)?>" class="link">«</a>
    <? } ?>
    
    <? foreach($pageArr as $key => $fomatPage){ ?>
        <a href="<?=combinePage($fomatPage, $queryString)?>" class="link <?=$fomatPage == $page? 'active' : ''?>"><?=$fomatPage?></a>
    <? } ?>    
    
    <? if($page != $maxPage){ ?>
        <a href="<?=combinePage($maxPage, $queryString)?>" class="link">»</a>
    <? } ?>
</div>