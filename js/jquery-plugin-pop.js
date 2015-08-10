//guoxun01@126.com
//实例化...................................
;(function($) {
    //guoxun@staff.sina.com.cn
    $.fn.popwindow = function(set) {
        var self = $(this);  
        var width = $(window).width();
        var height = $(document).height(); 
        var setting= {
            w:500,
            h:400,
            fixed:true,
            opacity:0.6,
            close:null,
            content:'nothing....'//可以是juqery对象
        }

        $.each(set, function(index, val) {
             setting[index] = val;
        });

        var windwidth = setting.content.width();
        var winheight = setting.content.height();
        //console.log(typeof setting.content);
        if(typeof setting.content==="object"){
            setting.content.show().css({
                'position': 'fixed',
                'left': width/2-windwidth/2,
                'top':$(window).height()/2-winheight/2,
                'z-index':1000000
            });
           // console.log(width+'  '+$(this).width());
        }

        var mask = $('<div id="homemask" style="width:100%;height:'+height+'px;background:#000;position:absolute;left:0;top:0;opacity:'+setting.opacity+';filter:alpha(opacity=50);z-index:999999"></div>');
        if($("#homemask").index()==-1)$('body').append(mask);
        $("#homemask").show();
        function close(){
            setting.content.hide();
            //blur.removeClass('blur');
            mask.hide();
            $('#homemask').hide();
        }

        setting.content.find('.close').click(function(event) {
             close();
        });

        //console.log(setting);
        return self;
    };
})(jQuery);
