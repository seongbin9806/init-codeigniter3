const admin = {    
    toggleSideMenu: function(){
        let $sideMenu = $('#sideMenu'),
            $mainWrap = $('#mainWrap'),
            offCls = 'off';            
        
        if($sideMenu.hasClass(offCls)){
            util.setCookie('sideMenu', '');
        }else{
            util.setCookie('sideMenu', offCls);
        }
        
        $sideMenu.toggleClass(offCls);
    }
}

$(function(){
    $('.menuTab').click(function() {
        let $el = $(this),
            $arrow = $el.children('.arrow'),
            $target = $el.next();
                                
        if($target.hasClass('on')){
            $target.slideUp(300);
            
        }else{
            $target.slideDown(300);
        }
        
        $arrow.toggleClass('rotated-180');
        $target.toggleClass('on');
    });
});