
(function($){
    
    $.likeAction = function(settings) {
        
        var config = settings;
        
        var plugin = this;
        
            
        /*if (window.File && window.FileList && window.FileReader) {
            debugger;
            plugin.uploadInit();
        }*/


        
        /*plugin.uploadInit = function() {
            var fileselect = $id("fileselect");

            // file select
            fileselect.addEventListener("change", plugin.fileSelectHandler, false);

            // is XHR2 available?
            var xhr = new XMLHttpRequest();
            if (xhr.upload) {
                // file drop
                filedrag.addEventListener("dragover", FileDragHover, false);
                filedrag.addEventListener("dragleave", FileDragHover, false);
                filedrag.addEventListener("drop", FileSelectHandler, false);
                filedrag.style.display = "block";
            }

        
        }*/

        // file selection
        plugin.fileSelectHandler = function(e) {
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

        }       

        plugin.showLikes = function() {
            plugin.loadData();
        }
 
        plugin.loadData = function() {
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
                            $('.liked-info > span').tooltip();
                        }
                        if(config.postType == "r") {
                            $('li[id="post-'+config.postId+'"] .post-message span.post-like').remove();
                            if (data.view != "") {
                                $('li[id="post-'+config.postId+'"] .post-message').append(data.view);
                            }
                            
                            $('span.post-like').tooltip();                         
                        }
                        
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


