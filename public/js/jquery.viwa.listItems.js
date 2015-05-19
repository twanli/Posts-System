
(function($){
    
    $.listItems = function(settings) {
        
        var config = {
            'data_src'      : [], // Array of objects, if stored within global js object : {id:1, name:'John',age:25, etc.}
            'request'       : {'url':'', 'params':{}, 'type':'get'},
            'wrapper'       : null, // Wrap element of holder
            'holder'        : null, // Hold element where items will be displayed
            'jstemplate'    : '',   // jsTemplate to parse single item data
            'more_button_id' : null,
            'no_result'     : null,
            'loader'        : null,
            'offset'        : 0,
            'limit'         : 5
        };
        
        if (settings){$.extend(config, settings);}
        
        var plugin = this;
        
        var data = [];
        var total_count = config.data_src.length;
        var more_button = null;
        
        plugin.init = function() {
        
            if (config.wrapper == null || config.holder == null || config.more_button_id == null || config.no_result == null) {
                return false;
            }
            
            more_button = $('#' + config.more_button_id);
            more_button.find('a').css({display:'block', margin:'0 auto'}); //fix css
            more_button.find('a').click(function() {
                plugin.show();
            });
            
        }

        plugin.template = function() {
            var html = window[config.jstemplate](data);
            config.holder.append(html);
        }
 
        plugin.show = function() {
            plugin.loadData();
        }
 
        plugin.list = function() {

            if (total_count == 0) {
                plugin.noResult();
                return this;    
            }

            plugin.template();

            if (total_count > config.offset + config.limit) {
                
                more_button.show();
                config.offset += config.limit;
                  
            } else {
                more_button.hide();    
            }
                
        }
        
        plugin.noResult = function() {
            config.no_result.show();    
        }
        
        plugin.loadData = function() {
            
            if (config.data_src.length > 0) {
                
                data = config.data_src.slice(config.offset, config.offset + config.limit);  
                
                plugin.list();
                      
            } else {

                $.extend(config.request.params, {'offset':config.offset});
                
                $.ajax({
                    type: config.request.type,
                    url: config.request.url,
                    data: config.request.params,
                    dataType: 'json',
                    async: true,
                    headers: {
                        key : data_key
                    },
                    beforeSend:function(){
                       config.loader.show();
                    },
                    error:function(){
                        config.loader.hide(); 
                        showErrorBox("Error");
                    },
                    success: function (result) {
                        
                        if (result.error) {
                            
                            config.loader.hide();  
                            showErrorBox("Error");
                              
                        } else {
                            
                            total_count = result.total;
                            data = result.data; 
                            
                            plugin.list();
                            
                            config.loader.hide();   
                        }
                    }
                });

            }
            
        }

        // Init plugin
        plugin.init();
 
        return this;
    };
    
})(jQuery);


