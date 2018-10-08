$(document).ready(function(){

    $('#s_email').bind('click',function(){
        var email = $('#email').val();
        if(email==""){
            layer.msg('邮箱地址为空', {icon: 5});
        }else{
            $.ajax({
                async:true,
                url: "s_email",
                contentType:'json',
                data: 'email='+email,
                success: function(){
                    showtime(60);
                }
            });
        }
    });

});
//邮箱倒计时发送
function showtime(t){
    $('#s_email').prop('disabled',true);
    for(i=1;i<=t;i++) {
        window.setTimeout("update_p(" + i + ","+t+")",i * 1000);
    }
}
function update_p(num,t) {
    if(num == t) {
        $('#s_email').text(" 重新发送 ");
        $('#s_email').prop('disabled',false);
    }
    else {
        printnr = t-num;
        $('#s_email').text(printnr);
    }
}
