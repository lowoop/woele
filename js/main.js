

//初始化弹出登陆框
$('#login').click(function(){
	$(this).popwindow({content:$(".setover")});
});


//单选
$('.radselect').click(function(){
	$(this).toggleClass('active');
	$('.stopdiv').toggle();//显示未营业餐厅
});


//登陆信息显示
$('.loginuser').hover(function(){
	$(this).addClass('loginhover');
},function(){
	$(this).removeClass('loginhover');
});
//菜品选择
$(".listcontent .left .cp span").click(function(event) {
	$(this).toggleClass('cur').siblings().removeClass("cur");
});
/*返回顶部*/
$('.top').click(function(event) {
	$('html,body').animate({scrollTop:0}, 400)
});

//公共函数
function email(value){
    return /^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/.test(value);
}
function tips(s,tip){
    if(tip){
        $(s).after('<span class="valiclass"> <img src="img/error.png" /> '+tip+'</span>');
    }else{
        $(s).after('<span class="valiclass"> <img src="img/ok.png" /></span>');
    }
}

function numeric(value){
             return /^[0-9]+$/.test(value);
        }
function numeric3(value){
             return /^[0-9]{3}$/.test(value);
        }
function formatAddress(result)
{
	var obj = {};
	$.each(result,function(i,value){
		obj[value['types'][0]] = value['short_name'];
	});
	return obj;
}
$('.enter').keydown(function(e){
    if(e.keyCode==13){
        console.log($(this).find(".enterkey"));
        $(this).find(".enterkey").click();
    }
});