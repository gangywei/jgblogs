$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.del_lab').bind('click',function(){
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
    $('.rev_lab').bind('click',function(){
        var id = $(this).parent().attr('data-id');
        var th = $(this).parent().parent();
        var title = th.children('td.data-title').html();
        var content = th.children('td.data-content').html();
        $('#label h4').html('修改标签');
        $('#mod_title').val(title);
        $('#mod_content').val(content);
        var form = $('#model_from');
        form.attr('action',form.attr('action')+'/'+id);
        form.removeAttr('method');
    });
});