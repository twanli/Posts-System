
(function($){
    
    $.postAction = function() {
        
        //var config = settings;
        
        var plugin = this;
       var allFiles = [];
        
        
        /*plugin.init = function() {
            if (config.like == null || config.postId == null || 
                config.sessionUserId == null || config.postType == null) {
                return false;
            }
        }*/
        
        /*plugin.uploadInit = function() {
            var fileselect = document.getElementById("fileselect");
            
            // file select
            fileselect.addEventListener("change", 
            plugin.fileSelectHandler, false);           
        }*/
        
        /*plugin.fileSelectHandler = function(e) {
            //debugger;
            // cancel event and hover styling
            //FileDragHover(e);

            // fetch FileList object
            var files = e.target.files || e.dataTransfer.files;

            // process all File objects
            for (var i = 0, f; f = files[i]; i++) {
                plugin.parseFile(f);
                allFiles.push(f);
                //plugin.uploadFile(f);
            }

        }*/
        
        plugin.fileSize  = function(size) {
            var BYTE = 1;
            var KB = 1024;
            var MB = 1048576;
            var GB = 1073741824;
            
            if (size == BYTE) {
                return "<strong>1</strong> Byte";
            } else if (size < KB) {
                return "<strong>" + size + "</strong> Bytes";
            } else if (size == KB) {
                return "<strong>1</strong> KByte";
            } else if (size < MB) {
                return "<strong>" + Math.round(size/KB) + "</strong> KBytes";
            } else if (size == MB) {
                return "<strong>1</strong> MByte";
            } else if (size < GB) {
                return "<strong>" + Math.round(size/MB) + "</strong> MBytes";
            } else if (size == GB) {
                return "<strong>1</strong> GByte";
            }
        }
                // output file information
        plugin.parseFile = function(file, postType) {
            var typ = file.type;
            if ((file.type.indexOf("image") == 0 && file.type != "image/bmp")
                || (file.type.indexOf("text") == 0) 
                || file.type == "application/pdf") {
                
                if(file.type == "image/jpeg") {
                    var fileInfo = "<p class='jpg'>";
                }                
                if(file.type == "image/gif") {
                    var fileInfo = "<p class='gif'>";
                }                
                if(file.type == "image/png") {
                    var fileInfo = "<p class='png'>";
                }
                if(file.type == "application/pdf") {
                    var fileInfo = "<p class='pdf'>";
                }
                if(file.type.indexOf("text") == 0) {
                    var fileInfo = "<p class='txt'>";
                }
                
                fileInfo += file.name + "<br />" +
                            "size: " + plugin.fileSize(file.size) +
                            "</p>"
                if(postType == "n") {
                    var filesAttach = $("#post-files-attach");    
                    filesAttach.css('border', 'none');
                } 
                if(postType == "r") {
                    var filesAttach = $("#reply-files-attach");                    
                        
                }
                var actualHTML = filesAttach.html();
                filesAttach.html(fileInfo + actualHTML);
                
                if (file.type.indexOf("image") == 0) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                
                        var imgDisplay = '<p><img src="' + 
                                e.target.result + '" /></p>';
                        
                        //var imgAttach = document.getElementById("post-img-attach");

                        
                        if(postType == "n") {
                            var imgAttach = $("#post-img-attach");    
                        } 
                        if(postType == "r") {
                            var imgAttach = $("#reply-img-attach");    
                        }
                        var actualImg = imgAttach.html();
                        imgAttach.html(imgDisplay + actualImg);    
                    }
                    reader.readAsDataURL(file);
                }    
            }
              /* )  
             || file.type == "image/png"
                || file.type == "image/gif" || file.type == "text/plain"
                
                )
            Output(
                "<p>File information: <strong>" + file.name +
                "</strong> type: <strong>" + file.type +
                "</strong> size: <strong>" + file.size +
                "</strong> bytes</p>"
            );

            // display an image
            if (file.type.indexOf("image") == 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    Output(
                        "<p><strong>" + file.name + ":</strong><br />" +
                        '<img src="' + e.target.result + '" /></p>'
                    );
                }
                reader.readAsDataURL(file);
            }

            // display text
            if (file.type.indexOf("text") == 0) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    Output(
                        "<p><strong>" + file.name + ":</strong></p><pre>" +
                        e.target.result.replace(/</g, "&lt;").replace(/>/g, "&gt;") +
                        "</pre>"
                    );
                }
                reader.readAsText(file);
            }*/

        }

        // upload JPEG files
        plugin.uploadFiles = function(files, postId) {
            
            
            var postForm = document.getElementById("post-form");
            
            
                for (var i = 0, f; f = files[i]; i++) {
 
                    var xhr = new XMLHttpRequest();
                    if (xhr.upload) {
                        xhr.open("POST", postForm.action+"?id="+postId, true);
                        xhr.setRequestHeader("X-FILENAME", f.name);
                        xhr.send(f);
                    }
                }
            
        }
        
        plugin.uploadFile = function(file) {
            var postForm = document.getElementById("post-form");
            
            var xhr = new XMLHttpRequest();
                    
            if (xhr.upload) {
                xhr.open("POST", postForm.action, true);
                xhr.setRequestHeader("X-FILENAME", file.name);
                //xhr.send(file);
            }
        
        } 
        
        plugin.init = function() {
            plugin.initializeTooltip();
            plugin.initializeFancyBox();
            plugin.initializeAccordion();
            plugin.initializePostsScroll();
        }
        
        plugin.addPost = function(formData, postType) {
            
            $.ajax({
                type: 'POST',
                url: "http://zf2.localhost/post/add",
                data: formData,                
                processData: false, // Don't process the files
                contentType: false,
                dataType: "json",
                error : function() {
                    alert('An error happened');
                },
                success: function(data){
                    if(postType == "n") {
                        if (!data.error) {
                            $(".post-message-form span.post-error").remove();
                            
                            $.tmpload('loadPost', 'tmpl/post.tmpl');
                            $.when(
                                $.tmpload('loadPost'),
                                data                                
                            ).then( function(tmpl, data) {                                
                                $.tmpl(tmpl, data).prependTo('.post-message-container ul');
                            });
                                                   
                        } else {
                            
                            if(!$(".post-message-form span.post-error").length) {
                                $(".post-message-form").append(
                                    "<span class='post-error'>" 
                                        + data.message + "</span>"
                                );                                
                            }                        
                        }
                    } else {
                        if (!data.error) {

                            if(!$("li[id='post-"+data.postParentId+"'] > ul.children").length) {
                                $("li[id='post-"+data.postParentId+"']").append(
                                    "<ul class='children'></ul>"
                                );
                            }
                            
                            $("li[id='post-"+data.postReplyId+"'] > span.post-error").remove();
                            $("li[id='post-"+data.postReplyId+"'] > form").remove();

                            $.tmpload('loadPost', 'tmpl/post.tmpl');
                            $.when(
                                $.tmpload('loadPost'),
                                data                                
                            ).then( function(tmpl, data) {                                
                                $.tmpl(tmpl, data).appendTo("li[id='post-"+data.postParentId+"'] > ul.children");
                            });
                            
                           /* $("li[id='post-"+data.postParentId+"'] > ul.children").append(
                                data.view
                            );*/
                            
                        } else {
                            console.log(data.postReplyId);
                            if(!$("li[id='post-"+data.postReplyId+"'] > span.post-error").length) {
                                $("li[id='post-"+data.postReplyId+"'] > form").after(
                                    "<span class='post-error'>" 
                                        + data.message + "</span>"
                                );                                
                            }                        
                        }
                    } 

                }});
        }
        
        plugin.editPost = function(postId, msg) {
            $.ajax({
                type: 'POST',
                url: "http://zf2.localhost/post/edit",
                data: {postId: postId, msg: msg},                
                dataType: "json",
                error : function() {
                    alert('An error happened');
                },
                success: function(data){
                        if (!data.error) {
                            var txtArea = $("li[id='"+postId+"'] textarea");
                            $("li[id='"+postId+"'] span.post-error").remove();
                            $("li[id='"+postId+"'] button[name='edit-button']").remove();
                            
                            var divMsg = $("<div class='message'></div>");
                            divMsg.text(data.message);
                            txtArea.replaceWith(divMsg);
                        } else {
                            
                            if(!$(".message-body span.post-error").length) {
                                var errMsg = $("<span class='post-error'>" 
                                        + data.message + "</span>");
                                $("li[id='"+postId+"'] button[name='edit-button']").after(errMsg);
                                
                            }                        
                        }
                }});
        
        }
        
        plugin.initializeTooltip = function () {
            $('.liked-info > span').tooltip();
            $('span.post-like').tooltip();        
        }
        plugin.initializeFancyBox = function () {
            $('.fancybox').fancybox();
        }
        plugin.initializeAccordion = function () {
            $('.message-body').hide();
            $('a[rel="edit-post"]').hide();
            $(document).on('click', '.message-head', function(e) {
                $(this).nextAll('.message-body').slideToggle('slow');
                $(this).nextAll('.message-body').toggleClass('active');
                
                $(this).next('a[rel="edit-post"]').toggle();
                e.preventDefault();
            });    
            

        }
        
        plugin.initializePostsScroll = function() {
            var track_load = 0; //total loaded record group(s)
            var loading  = false; //to prevents multipal ajax loads
            var total_groups = 0; //inicialize - get the count by ajax
            
            $.ajax({
                type: 'POST',
                url: "http://zf2.localhost/post/getGroupsCount",
                dataType: "json",

                success: function(data){
                    total_groups = data.totalGroups;
                }});            
            $('.post-message-container>ul').load("http://zf2.localhost/post/autoload", {'group_no':track_load}, function() {
                track_load++;
                /*$('.message-body').hide();
                $('a[rel="edit-post"]').hide();*/
            });
            $(window).scroll(function() { //detect page scroll
        
                if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
                {
                    
                    if(track_load <= total_groups && loading==false) //there's more data to load
                    {
                        loading = true; //prevent further ajax loading
                        $('.animation_image').show(); //show loading image
                        
                        //load data from the server using a HTTP POST request
                        var ur = track_load;
                        $.post('http://zf2.localhost/post/autoload',{'group_no': track_load}, function(data){
                                            
                            $(".post-message-container>ul").append(data); //append received data into the element

                            //hide loading image
                            /*if(track_load == total_groups) {
                                $('.animation_image').hide(); //hide loading image once data is received    
                            }*/
                            $('.animation_image').hide();
                            
                            track_load++; //loaded group increment
                            loading = false;
                            /*$('.message-body').hide();
                            $('a[rel="edit-post"]').hide(); */
                        
                        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
                            
                            alert(thrownError); //alert with HTTP error
                            $('.animation_image').hide(); //hide loading image
                            loading = false;
                        
                        });
                        
                    }                    

                }            
            });

           
    }
           
        plugin.loadLikes = function(config) {
            //alert('test');
            $.ajax({
                type: 'POST',
                url: "http://zf2.localhost/like",
                data: {
                       like: config.like,                       
                       postId: config.postId,
                       sessionUserId: config.sessionUserId,
                       postType: config.postType
                },
                error : function() {
                    alert('An error happened');
                },
                success: function(data){
                    if (!data.error) {
                        if(config.postType == "n") {
                            $('li[id="post-'+config.postId+'"] .liked').html(data.view);
                            
                        }
                        if(config.postType == "r") {
                            $('li[id="post-'+config.postId+'"] .post-message span.post-like').remove();
                            if (data.view != "") {
                                $('li[id="post-'+config.postId+'"] .post-message').append(data.view);
                            }
                        }
                        
                        plugin.initializeTooltip();
                        
                        if(config.like == true) {
                            config.linkPostLike.text("Unlike");
                            config.linkPostLike.attr("rel","unlike");                            
                        } else {
                            config.linkPostLike.text("Like");
                            config.linkPostLike.attr("rel","like");                            
                        }
                    }                        
                }
            });
        }
        


        // Init plugin
        plugin.init();
 
        return this;
    };
    
})(jQuery);


