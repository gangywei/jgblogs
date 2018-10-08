// Generated by CoffeeScript 1.8.0
(function() {
  $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var author_dom, content_dom, email_dom, site_dom;
      author_dom = $('#new_comment_form input[name="author"]');
      email_dom = $('#new_comment_form input[name="email"]');
      site_dom = $('#new_comment_form input[name="site"]');
      content_dom = $('#new_comment_form textarea');
      $(".new_comment").click(function() {
          $(".comment_trigger").hide();
          $(".new_comment textarea").css("height", "auto");
          $(".comment_triggered").fadeIn("slow");
          event.stopPropagation();
          if (author_dom.length) {
            author_dom.val(author_dom.val() || Cookies.get('comment_author') || '');
          }
          if (email_dom.length) {
            email_dom.val(email_dom.val() || Cookies.get('comment_email') || '');
          }
          if (site_dom.length) {
            return site_dom.val(site_dom.val() || Cookies.get('comment_site') || '');
          }
        });
      return $('.comment_submit_button').click(function() {
          var author, content, data_to_post, email, site;
          author = author_dom.val() || '';
          email = email_dom.val() || '';
          site = site_dom.val() || '';
          content = content_dom.val();
          data_to_post = {
              name: author,
              email: email,
              site: site,
              contents: content,
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          };
          if (content.length < 0) {
              content_dom.focus();
              return false;
          }
          if (!email && email_dom.length) {
              content_dom.focus();
              return false;
          }
          if (author) {
              Cookies.set('comment_site', author, {
                  expires: 9999
              });
          }
          if (email) {
              Cookies.set('comment_site', email, {
                  expires: 9999
              });
          }
          if (site) {
              Cookies.set('comment_site', site, {
                  expires: 9999
              });
          }
          $.ajax({
              url: $('#new_comment_form').attr('action'),
              type: 'post',
              data: data_to_post,
              success: function(data) {
                  var new_comment_dom;
                  if (data.error) {
                      console.log('file');
                  } else {
                      if (typeof data === 'string') {
                          content_dom.val('');
                          $('.comments').append(data);
                          //动画特效
                          new_comment_dom = $('.comments .comment').last();
                          $('.comments .comment').last();
                          $('html, body').animate({
                        scrollTop: new_comment_dom.offset().top
                      }, 500, 'swing', function() {
                              return new_comment_dom.fadeIn(150).fadeOut(150).fadeIn(150);
                          });
                      }
                  }
              },
              fail: function(data) {
                  return console.log('failed');
              }
          });
          return false;
        });
  });

}).call(this);
$(document).ready(function() {
    $('.comment').bind("mouseover",function(){
        $(this).find('.respond').css('display','block');
    });
    $('.comment').bind("mouseout",function(){
        $(this).find('.respond').css('display','none');
    });
    $('a.respond').bind('click',function(){
        var word = $('#new_comment_form');
        var action = $('#hidurl').attr('src');
        var blong = $(this).attr('data-rid');
        //得到回复的URL
        if(!blong)
            blong = $(this).attr('data-id');
        action+='?r_id='+$(this).attr('data-id')+"&bl_id="+blong;
        word.attr('action',action);
        $(this).parents('.comment').after(word);
        $('#reword').css('display','block');
    });
    $('#reword').bind('click',function(){
        $('.doc_comments_wrapper').append($('#new_comment_form'));
        $(this).css('display','none');
        $(".comment_trigger").show();
        $(".comment_triggered").css('display','none');
    });
    $('.ident input').bind('click',function(){
        event.stopPropagation();
    })
    $('body').bind('click',function(){
        if($(".comment_triggered").css('display')=='block'){
            $(".comment_trigger").show();
            $(".comment_triggered").css('display','none');
        }
    });
});
