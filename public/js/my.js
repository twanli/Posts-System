$(document).ready(function() {
    var postAction = $.postAction();
    var postTypes = {normal: "n", reply: "r"}
    
    var allFiles = [];
    
    function dragDropFiles(event)
    {
        event.preventDefault();

        var i = 0,
            files = event.dataTransfer.files,
            len = files.length;

        for (var i = 0, f; f = files[i]; i++) {
            postAction.parseFile(f, "n");
            allFiles.push(f);            
        }        
    }
    
    function prepareDownload(e, postType) {
        var files = e.target.files || e.dataTransfer.files;
        
        for (var i = 0, f; f = files[i]; i++) {
            postAction.parseFile(f, postType);
            allFiles.push(f);            
        }
    }
    $(document).on('change', 'form[name="post"] input[type="file"]', 
        function(e) {
        prepareDownload(e, postTypes.normal);
    });
    $(document).on('change', 'form[name="post-reply-form"] input[type="file"]', 
        
        function(e) {

        prepareDownload(e, postTypes.reply);
    });
    
    var targetPost  = document.getElementById("post-files-attach");
    targetPost.addEventListener("dragover", function(event) {
        event.preventDefault();
    }, false);
    targetPost.addEventListener("drop", dragDropFiles, false);

        // cancel default actions
    /*if (window.File && window.FileList && window.FileReader) {
        var fileselect = document.getElementById("fileselect");

        // file select
        fileselect.addEventListener("change", 
        fileSelectHandler, false);   
                //postAction.initializeTooltip();
    }*/
        // file selection
    /*function FileSelectHandler(e) {
        debugger;
        // cancel event and hover styling
        //FileDragHover(e);

        // fetch FileList object
        var files = e.target.files || e.dataTransfer.files;

        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            ParseFile(f);
            UploadFile(f);
        }

    }*/
    
    //postAction.initializeTooltip();    

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
    
    $(document).on('click', 'a[rel="edit-post"]', function(){            
        var msgDiv = $(this).closest("li").find("> .post-message>.message-body>.message");            
            var content = msgDiv.html();
            var button = 
                $("<div class='row'><div class='col-sm-12'><button type='submit' name='edit-button' class='btn btn-default'>Confirm Edit</button></div></div>");
            msgDiv.after(button);
            
            var editableText = 
                $("<textarea>"+$.trim(content)+"</textarea>");
           
            msgDiv.replaceWith(editableText);
            editableText.focus();
        }    
    );
    
    $(document).on('click', 'button[name="edit-button"]', function(e) {
        var postId = $(this).closest("li").attr("id");
        var msg = $(this).closest("li").find("textarea").val();
        
        postAction.editPost(postId, msg);
        
    });
    
    
    $('.post-message-form form').submit(
        function(e){

            e.preventDefault();
            var message = $('#post_message').val();
            
            var formData = new FormData();
            $.each(allFiles, function(key, value)
            {
                formData.append(key, value);
            });
            formData.append('message', message);
            allFiles = [];

            postAction.addPost(formData, postTypes.normal);//{
                //'message'       : message

            //});
        }
    );

    $(document).on('click', '.post-message a.post-reply', function(e) {
    e.preventDefault();
    var postParentId = $(this).closest(".post-message-container>ul>li")
                    .attr("id");
    var postReplyId = $(this).closest("li").attr("id");
    var replyTo = $("li[id='"+postReplyId+"']>.post-message span.author").html();
        
    var form =
    "<form method='POST' name='post-reply-form' class='form-horizontal' role='form'>"
    +"<span>Replying to " + replyTo + "</span>" 
    +"<div class='form-group'>"+
    "<input type='hidden' name='post-parent-id' value='" + postParentId + "'/>"+ 
    "<input type='hidden' name='post-reply-id' value='" + postReplyId + "'/>"+
    "<textarea name='post-reply' class='form-control' rows='5'"+ 
    "placeholder='Write a reply ...'></textarea></div>"+
    "<div class='row action-buttons'><div class='col-sm-2'>"+
    "<button type='submit' name='add-button' class='btn btn-default'>"+
    "Add Post</button></div><div class='col-sm-5'>"+
    "<label for='fileselect'>Attach files:</label></div><div class='col-sm-5'>"+
    "<input type='file' name='fileselect[]' id='fileselect' multiple='multiple'>"
    +"</div></div>"
    +"<div class='row file-attachments'>"
    +"<div id='reply-img-attach' class='col-sm-7'></div>"
    +"<div id='reply-files-attach' class='col-sm-5'><span>You can drag & drop files here ..</span></div>"
    +"</div>"
    +"</form>";
    
    $(this).closest("li").find("> .post-message").after(form);
    }); 
    //debugger;
    //document.querySelector('body').
    //var targetReply = document.getElementById("reply-files-attach");
    /*document.querySelector('#reply-files-attach').addEventListener("dragover", function(event) {
        event.preventDefault();
    }, false);
    document.querySelector('#reply-files-attach').addEventListener("drop", dragDropFiles, false);*/
    
    
    $(document).on('dragover', '#reply-files-attach', function(event) {
        event.stopPropagation();
        event.preventDefault();
    }); 
    $(document).on('drop', '#reply-files-attach', function(event) {
        event.preventDefault();

        var i = 0,
            files = event.originalEvent.dataTransfer.files,
            len = files.length;

        for (var i = 0, f; f = files[i]; i++) {
            postAction.parseFile(f, "r");
            allFiles.push(f);            
        }
    });
    
    $(document).on('submit', 'form[name="post-reply-form"]', function(e) {
            e.preventDefault();
            
            var message = $('textarea[name="post-reply"]').val();
            var postParentId = $('input[name="post-parent-id"]').val();
            var postReplyId = $('input[name="post-reply-id"]').val();

            
            var formDataReply = new FormData();
            $.each(allFiles, function(key, value)
            {
                formDataReply.append(key, value);
            });
            formDataReply.append('message', message);
            formDataReply.append('postParentId', postParentId);
            formDataReply.append('postReplyId', postReplyId);
            
            allFiles = [];

            postAction.addPost(formDataReply, postTypes.reply);            

            /*postAction.addPost({
                'message'       : message,                
                'postParentId'  : postParentId,
                'postReplyId'   : postReplyId
            });*/
            /*$.ajax({
                type: 'POST',
                url: "http://zf2.localhost/post/add",
                data: {parentId: postParentId, 
                        replyId: postReplyId, 
                        message: message},
                error : function() {
                    alert('An error happened');
                },
                success: function(data){
                    if (!data.error) {
                        if(!$("li[id='"+postParentId+"'] > ul.children").length) {
                            $("li[id='"+postParentId+"']").append(
                                "<ul class='children'></ul>"
                            );
                        }
                        
                        $("li[id='"+postReplyId+"'] > span.post-error").remove();
                        $("li[id='"+postReplyId+"'] > form").remove();
                        
                        $("li[id='"+postParentId+"'] > ul.children").append(
                            data.view
                        );
                        
                    } else {
                        if(!$("li[id='"+postReplyId+"'] > span.post-error").length) {
                            $("li[id='"+postReplyId+"'] > form").after(
                                "<span class='post-error'>" 
                                    + data.message + "</span>"
                            );                                
                        }                        
                    }
                }});*/ 
    });
    
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