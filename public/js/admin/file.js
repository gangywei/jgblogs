$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.del_file').bind('click',function(){
        var id = $(this).parent().attr('data-id');
        var src = $('#hidsrc').attr('href');
        var tr = $(this).parents('tr');
        $.ajax({
            async: true,
            type:'delete',
            url: src+'/'+id,
            contentType:'json',
            success: function(data){
                if(data.res=='success'){
                    tr.remove();
                }else{
                    layer.msg(data.res, {icon: 5});
                }
            }
        });
    });

    //清空文档内容
    $('#adduser').bind('click',function(){
        $('#mod_title').val("");
        $('#mod_content').val("");
    });

    $('.rev_file').bind('click',function(){
        var id = $(this).parent().attr('data-id');
        var th = $(this).parent().parent();
        var title = th.children('td.data-title').html();
        var content = th.children('td.data-content').html();
        $('#label h4').html('修改弹出框');
        $('#mod_title').val(title);
        $('#mod_content').val(content);
        var form = $('#model_from');
        form.attr('action',form.attr('action')+'/'+id);
        form.removeAttr('method');
    });

    $('.up_limt').bind('click',function(){
            var user = $('#user_id');
            var id = $(this).parent().attr('data-id');
            user.prop('value',id);
            //修改模态框role显示
            var role_id = [];
            $(this).parent().prevAll('#zizid').children('span').each(function(index,data){
                role_id[index] = $(this).attr('data-id');
            });
            $('.ui-choose>li').each(function(){
                if(role_id.indexOf($(this).attr('data-value'))>=0){
                    $(this).addClass('selected');
                }
            });
    });
});