$(document).ready(function(){
    encrypt = new JSEncrypt();
    decrypt = new JSEncrypt();
    encrypt.setPublicKey('-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBi' +
        'QKBgQDr4DBkOEEXd/ez9FlU2RRgE0MH27dR6oCGzGyi3x3HVhpOYiCnuCdG9YkIyzzdqgIJbtFhYe' +
        'QKqA08v2HYBaUasQhKGFUDsU7y6dFXa8VOHqkBZGyygwKsplh4gZUJl5VjJoZUptce+9koug5pQq5p' +
        'f9woFYeGTzcQ3SUdUf9BAQIDAQAB-----END PUBLIC KEY-----');
    decrypt.setPrivateKey('-----BEGIN PUBLIC KEY-----MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBi' +
        'QKBgQDr4DBkOEEXd/ez9FlU2RRgE0MH27dR6oCGzGyi3x3HVhpOYiCnuCdG9YkIyzzdqgIJbtFhYe' +
        'QKqA08v2HYBaUasQhKGFUDsU7y6dFXa8VOHqkBZGyygwKsplh4gZUJl5VjJoZUptce+9koug5pQq5p' +
        'f9woFYeGTzcQ3SUdUf9BAQIDAQAB-----END PUBLIC KEY-----');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#login').bind('click',function(){
        var regex = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        var email = $('#email').val();
        if(email==''){
            layer.msg('请输入邮箱');
            return;
        }else if(!regex.test(email)){
            layer.msg('邮箱不合法');
            return;
        }
        var passwd = $('#passwd').val();
        if(passwd==''){
            layer.msg('请输入密码');
            return;
        }
        var repass = $('#repass').find('.icheckbox_square-blue').attr('aria-checked');
        passwd = encrypt.encrypt(passwd);
        var ajax_data = {
            email: email,
            password: passwd,
            remember: repass
        };
        var ajax_url = '/login';
        $.ajax({
            url: ajax_url,
            type: 'post',
            data: JSON.stringify(ajax_data),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            success: function (data) {
                if(data.res==true)
                    location.href = '/blog';
                else{
                    layer.msg(data.res);
                }
            },
            error: function (xhr) {
                layer.alert('抱歉！出错！联系 contact@cnblogs.com', {icon: 6});
            }
        });
    });
});