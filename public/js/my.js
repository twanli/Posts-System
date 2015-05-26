$(document).ready(function() {
    
    
    jQuery.fn.highlight = function (str, className) {
        var regex = new RegExp(str, "gi");
        return this.each(function () {
            var content = $(this).html();
            content = content.replace(regex, function(matched) {
                return "<span class=\"" + className + "\">" + matched + "</span>";
            });
            $(this).html(content);
        });
    };
    
    var searchTxt = $.trim($("form#search input[type='text']").val());
    if(searchTxt.length>0)
    {
        $("table td.text-data").highlight(searchTxt, "highlight");
    }
    
    $('a[rel="delete"]').click(
        function(){
              if (!confirm("Are you sure?")) {
                return false;
            }
        }    
    );    

    /************************/
    /* POST MANIPULATION    */ 
    /* SECTION              */
    /************************/

    var postAction = $.postAction();
    var postTypes = {normal: "n", reply: "r"}
    

        
    //Upload files for post
    $(document).on('change', 'form[name="post"] input[type="file"]', 
        function(e) {
        postAction.prepareDownload(e, postTypes.normal);
    });
    $(document).on('change', 'form[name="post-reply-form"] input[type="file"]', 
        function(e) {
        postAction.prepareDownload(e, postTypes.reply);
    });
    
    /*Drag and Drop*/
    var targetPost  = document.getElementById("post-files-attach");
    if(targetPost != null) {
        targetPost.addEventListener("dragover", function(event) {
            event.preventDefault();
        }, false);
        targetPost.addEventListener("drop", postAction.dragDropFiles, false);        
    }
    $(document).on('dragover', '#reply-files-attach', function(event) {
        event.stopPropagation();
        event.preventDefault();
    }); 
    $(document).on('drop', '#reply-files-attach', function(event) {
        event.preventDefault();
        postAction.dragDropFilesDeleg(event);
    });

    //Main post added
    $('.post-message-form form').submit(
        function(e){
            e.preventDefault();

            var message = $('#post_message').val();
            var data = {message: message}
                        
            postAction.addPost(data, postTypes.normal);
        }
    );
    //Reply Post added 
    $(document).on('submit', 'form[name="post-reply-form"]', function(e) {
        e.preventDefault();

        var message = $('textarea[name="post-reply"]').val();
        var postParentId = $('input[name="post-parent-id"]').val();
        var postReplyId = $('input[name="post-reply-id"]').val();

        var data = {
            message : message,
            postParentId : postParentId,
            postReplyId  : postReplyId    
        }
        postAction.addPost(data, postTypes.reply);            
    });
       
    //Editing Post
    $(document).on('click', 'a[rel="edit-post"]', function(){            
        var msgDiv = $(this).closest("li").find("> .post-message>.message-body>.message");
        postAction.editPostPrepare(msgDiv);
    });
    $(document).on('click', 'button[name="edit-button"]', function(e) {
        var postId = $(this).closest("li").attr("id");
        var msg = $(this).closest("li").find("textarea").val();
        
        postAction.editPost(postId, msg);
        
    });
    
    //Generate Reply Form
    $(document).on('click', '.post-message a.post-reply', function(e) {
        debugger;
        e.preventDefault();
        var postParentId = $(this).closest(".post-message-container>ul>li")
                        .attr("id");
        var postReplyId = $(this).closest("li").attr("id");
        var replyTo = $("li[id='"+postReplyId+"']>.post-message span.author").html();
        var data = {
            postParentId : postParentId,
            postReplyId  : postReplyId,
            replyTo : replyTo
        }
        var msgElem = $(this).closest("li").find("> .post-message")
        $.tmpload('replyForm', 'tmpl/reply-form.tmpl');
        $.when(
            $.tmpload('replyForm'),
            data                                
        ).then( function(tmpl, data) {                                
            $.tmpl(tmpl, data).insertAfter(msgElem);
        });        

    }); 

    //Like-Unlike Post
    $(document).on('click', 'a.post-like', function() {
            var like = 0;
            if ($(this).attr("rel") == "like") {
                like = 1;
            } else {
                like = 0;
            }
            var postId = $(this).data('postid');
            var sessionUserId = $(this).data('userid');
            var postType = $(this).data('posttype');
            
            var linkPostLike = $(this); 
            
            postAction.loadLikes({
                'like'          : like,
                'linkPostLike'  : linkPostLike, 
                'postId'        : postId, 
                'sessionUserId' : sessionUserId, 
                'postType'      : postType
            });             
            }    
    );

   
});