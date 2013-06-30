$(document).ready(function() {
                
    $('.reply').live('click', function(e){
        e.preventDefault();

        $reply_id = $(this).attr('data-id');
        $author = $(this).prev('a').text();
        $text = $(this).parent().parent().find('p small').text();

        $('#reply-to-snippet').remove();

        $('<div id="reply-to-snippet" class="input-prepend input-append">\
            <p>\
            <label for="reply-preview">Reply To</label>\
            <span class="add-on">@'+$author+'</span>\
            <input class="span4" name="reply-preview" id="reply-preview" type="text" placeholder="'+$text+'" disabled /> \
            <span class="add-on" style="color:red" id="remove-reply-to"><a href="#">x</a></span>\
            <input type="hidden" id="reply-to" name="reply-to" value="'+$reply_id+'" />\
            </p></div>'
         ).
        prependTo('#comment-form');
        
         $('html, body').animate({
             scrollTop: $("#comment-form").offset().top
         }, 1500);

    });

    $('#remove-reply-to a').live('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();
    });

});

