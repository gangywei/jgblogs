$(document).ready(function(){
    //控制侧边栏的显示与隐藏
    $(".sidr-class-widget").bind('click',function(){
        var ul = $(this).find('ul');
        if(ul.css('display')=='none')
            ul.css('display','block');
        else
            ul.css('display','none');
    });
});