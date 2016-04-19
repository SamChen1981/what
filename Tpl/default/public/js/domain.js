$(document).ready(function(){
	check_login('qiye');
});

var qiye_url = "http://chuanbo.weiboyi.com";
var bozhu_url ="http://qudao.weiboyi.com";

function change_verify(type){
		$("#verify_image_"+type).attr("src", "index.php?m=blog&a=verify&md=" + Math.random());
}
function login_submit(type){
    var uname = $("#username_"+type).val();
    var passwd = $("#password_"+type).val();
    var verify = $("#verify_"+type).val();
    var remember = $("#remember_"+type).val();
    if (type=='qiye')   	
    {
    	log_url ='index.php?m=company&a=hlogin';
    	jump = 'index.php?m=company&a=myindex';
    }
    else{
    	log_url ='index.php?m=blog&a=hlogin';
    	jump = 'index.php?m=blog&a=myindex';
    }
    
    if(uname==''){
        alert("请输入正确的用户名！"); $("#username"+type).focus();
    }else if(!passwd || passwd.length < 4){
        alert("请输入长度大于4的登录密码！"); $("#password"+type).focus();
    }else if(!verify || verify.length != 4){
        alert("请输入4位数的验证码！"); $("#verify"+type).focus();
    }else{
        $.ajax(log_url, {
            type: "post",dataType: "json",
            data: {username: uname, password: passwd, verify: verify,remember: remember},
            beforeSend: function(){ $("#login-mark").show(); },
            success: function(request){
                if(request.status==1){
                    build_login(request.data);
                    location.href = jump;
                }else{
                    change_verify();
                    alert(request.info);
                }
                $("#login-mark").hide();
            }
        });
    }
}

/**切换**/
function change(site,o)
{
	if(site == "qiye")
	{
		$(o).addClass('a1_now');
		$('#login .a2').removeClass('a2_now');
		$('#bozhu_login').hide();
		$('#qiye_login').show();
		$("#password_qiye").val("");
		$('#captcha_qiye').val("");
		check_login('qiye');
	}else if(site =="bozhu"){
		$(o).addClass('a2_now')
		$('#login .a1').removeClass('a1_now');
		$('#bozhu_login').show();
		$('#qiye_login').hide();
		$("#password_bozhu").val("");
		$('#captcha_bozhu').val("");
		check_login('bozhu');
	}
}

function build_login(data){
    var html = '<ul><li>您好！<span style="color:#00a1e9;">{$_SESSION.contact}</span></li>';
    html+= '<li style="font-size:12px;color:#999;margin-top:5px;">上次登录时间：{$_SESSION.lasttime|date="Y-m-d H:i",###}</li>';
    html+= '<li style="font-size:12px;color:#999;">上次登录ＩＰ：{$_SESSION.lastip}</li>';
    html+= '</ul><div>';
    html+= '<ul class="form_menu bullet-5" style="margin-bottom:30px;">'
    html+= '<li><a href="{$company.account_info}">个人信息</a></li>';
    html+= '<li><a href="{$company.task}">我的活动</a></li>';
    html+= '<li><a href="{$company.dinner}">我的套餐</a></li>';
    html+= '<li><a href="{$company.bill_payoff}">财务明细</a></li>';
    html+= '<li><a href="{$company.logout}" style="color:red;">安全退出</a></li>';  
    html+= '</ul>'
    html+= '<a href="{$company.myindex}"><img src="http://www.weiqc.com/Public/images/home/goto.jpg" border="0"></a><br/>';
    html+= '';
    html+= '</div>';
    $("#login_sub").hide();
    $("#login-info").html(html).show();
}
function check_login(type)
{
    $.post("index.php?m=index&a=checkLogin",{type:type},function(request){
        if(request.status == 1){
        	if (type=='qiye')
        	{
        		tag = "qiye";
						tagOther="bozhu";
        	}else{
		        tag = "bozhu";
						tagOther="qiye";
					}
					$('#name_'+tag).html(request.data['realname']);
	        $('#login .a1').addClass('a1_now');
					$('#login .a2').removeClass('a2_now');
					$("#"+tag+"_login").hide();
					$("#"+tagOther+"_login").hide();
					$("#login_"+tag+"_ok").show();
					$("#login_"+tagOther+"_ok").hide();
        }else{
        	change_verify(type);
        }
    },"json");
}

/**
*获取用户提交的登录信息
*/
function getLoginInfo(site)
{
	var username = "";
	var password = "";
	var captcha = "";
	var sendData = "";
	if(site == "qiye")
	{
		username = $("#username_qiye").val();
		password = $("#password_qiye").val();
		captcha  = $("#captcha_qiye").val();
	}else if(site == 'bozhu')
	{
		username = $("#username_bozhu").val();
		password = $("#password_bozhu").val();
		captcha  = $("#captcha_bozhu").val();
	}
	sendData = {'username':username,'password':password,'captcha':captcha};
	return sendData;
}
/**
*跨域登录
*/
function crossDomainLogin(site)
{
	var sendData = "";
	var loginUrl = "";
	var toUrl = "";
	if(!loginCheck(site))
	{
		return false;
	}
	sendData = getLoginInfo(site);//整理要传输的数据
	createAndSaveCookie(site);//生成cookie
	if(site == 'qiye')
	{
		loginUrl = qiye_url+"/hwauth/index/domainlogin";
		toUrl = qiye_url;
	}else if(site == 'bozhu')
	{
		loginUrl = bozhu_url+"/auth/index/domainlogin";
		toUrl = bozhu_url;
	}else{
		//alert('Error');
		return false;
	}
	$.ajax({
		type: 'GET',			//传递方式
		async:false,			//使用同步请求
		url: loginUrl,			//请求url
		dataType: "jsonp",		//选择返回值类型
		jsonp:"callback",		//规定发送/接收参数，默认为callback
		data: sendData,
		timeout:30000,			//设置请求超时时间
		error:function(jqXHR, textStatus, errorThrown){
			 //alert("Error");
			 return false;
		},
		success:function(msg) {
			if (msg.ones == true) {
				    $("#captcha_"+site).val("");
					window.location.href=toUrl;
			} else {
				//alert(msg.message);
				getCaptcha(site);
			}
		}
	});
}
/***
* 退出
**/
function  crossDomainLogout(site)
{
	var loginUrl ="";
	var tag ="";
	var tagOther ="";
if(site == 'qiye')
{
	loginUrl = qiye_url+"/hwauth/index/crossdomainlogout";
	tag ="qiye";
	tagOther="bozhu";
}else if(site == 'bozhu')
{
	loginUrl = bozhu_url+"/auth/index/crossdomainlogout";
	tag = "bozhu";
	tagOther="qiye";
}else{
	//alert("Error");
	return false;
}
	$.ajax({
		type: 'GET',			//传递方式
		async:false,			//使用同步请求
		url: loginUrl,			//请求url
		dataType: "jsonp",		//选择返回值类型
		jsonp:"callback",		//规定发送/接收参数，默认为callback
		timeout:30000,			//设置请求超时时间
		error:function(jqXHR, textStatus, errorThrown){
			if (jqXHR.status) {
				getCaptcha(site);
				$("#"+tag+"_login").show();
				$("#password_"+tag).val("");
				$("#captcha_"+tag).val("");
				$("#"+tagOther+"_login").hide();
				$("#login_qiye_ok").hide();
				$("#login_bozhu_ok").hide();
			} else {
				alert("退出失败");
			}
		},
		success : function(msg) {
			if (msg.ones == true) {
				getCaptcha(site);
				$("#"+tag+"_login").show();
				$("#password_"+tag).val("");
				$("#captcha_"+tag).val("");
				$("#"+tagOther+"_login").hide();
				$("#login_qiye_ok").hide();
				$("#login_bozhu_ok").hide();
			} else {
				alert("退出失败");
			}
		}
	});
}
/***
* 判断A是否登录
**/
function dump_obj(myObject) { 
	  var s = ""; 
	  for (var property in myObject) { 
	   s = s + "\n "+property +": " + myObject[property] ; 
	  }
	  alert(s); 
	}  
function isDomainInfoA()
{
	var loginUrl = qiye_url+"/hwauth/index/iscrossdomain";
	var tag = "qiye";
	var tagOther ="bozhu";
	$.ajax({
		type: 'GET',			//传递方式
		async:true,			//使用同步请求
		url: loginUrl,			//请求url
		dataType: "jsonp",		//选择返回值类型
		jsonp:"callback",		//规定发送/接收参数，默认为callback
		timeout:30000,			//设置请求超时时间
		error:function(jqXHR, textStatus, errorThrown){
			 //alert("Error");
			 //return false;
		},
		success:function(msg) {
			if (msg.ones == true) {
				getDomainInfo(tag);
				$('#login .a1').addClass('a1_now');
				$('#login .a2').removeClass('a2_now');
				$("#"+tag+"_login").hide();
				$("#"+tagOther+"_login").hide();
				$("#login_"+tag+"_ok").show();
				$("#login_"+tagOther+"_ok").hide();
			} else {
				getCaptcha(tag);
				isDomainInfoC();
			}
		}
	});
}
/***
* 判断B是否登录
**/
function isDomainInfoC()
{
	var loginUrl = bozhu_url+"/auth/index/iscrossdomain";
	var tag = "bozhu";
	var tagOther ="qiye";
	$.ajax({
		type: 'GET',			//传递方式
		async:true,			//使用同步请求
		url: loginUrl,			//请求url
		dataType: "jsonp",		//选择返回值类型
		jsonp:"callback",		//规定发送/接收参数，默认为callback
		timeout:30000,			//设置请求超时时间
		error:function(jqXHR, textStatus, errorThrown){
			 //alert("Error");
			 //return false;
		},
		success:function(msg) {
			if (msg.ones == true) {
				getDomainInfo(tag);
				$('#login .a2').addClass('a2_now');
				$('#login .a1').removeClass('a1_now');
				$("#"+tag+"_login").hide();
				$("#"+tagOther+"_login").hide();
				$("#login_"+tag+"_ok").show();
				$("#login_"+tagOther+"_ok").hide();
			} else {
				getCaptcha(tag);
				return false;
			}
		}
	});
}
/***
* 获取登录信息(用户名)
**/
function getDomainInfo(site)
{
	var loginUrl = "";
	var tag ="";
	if(site == 'qiye')
	{
		loginUrl = qiye_url+"/hwauth/index/getloginname";
		tag ="qiye";
	}else if(site == 'bozhu')
	{
		loginUrl = bozhu_url+"/auth/index/getloginname";
		tag ="bozhu";
	}else{
		//alert('Error');
		return false;
	}
	$.ajax({
		type: 'GET',			//传递方式
		async:false,			//使用同步请求
		url: loginUrl,			//请求url
		dataType: "jsonp",		//选择返回值类型
		jsonp:"callback",		//规定发送/接收参数，默认为callback
		timeout:30000,			//设置请求超时时间
		error:function(jqXHR, textStatus, errorThrown){
			 //alert("Error");
			 return false;
		},
		success : function(msg) {
			if (msg.ones == true) {
				$("#name_"+tag).html(msg.name);
			} else {

			}
		}
	});
}


/*切换页面调用获取判断是否登录**/
function isDomainInfoOther(site)
{
	var loginUrl = "";
	var tag = "";
	var tagOther = "";
	if(site == 'qiye')
	{
		loginUrl = qiye_url+"/hwauth/index/iscrossdomain";
		tag = "qiye";
		tagOther ="bozhu";
	}else if(site == 'bozhu')
	{
		loginUrl = bozhu_url+"/auth/index/iscrossdomain";
		tag ="bozhu";
		tagOther ="qiye";
	}else{
		//alert('Error');
		return false;
	}
	$.ajax({
		type: 'GET',			//传递方式
		async:false,			//使用同步请求
		url: loginUrl,			//请求url
		dataType: "jsonp",		//选择返回值类型
		jsonp:"callback",		//规定发送/接收参数，默认为callback
		timeout:30000,			//设置请求超时时间
		error:function(jqXHR, textStatus, errorThrown){
			 //alert("Error");
			 //return false;
		},
		success:function(msg) {
			if (msg.ones == true) {
				getDomainInfo(site);
				$("#"+tag+"_login").hide();
				$("#"+tagOther+"_login").hide();
				$("#login_"+tag+"_ok").show();
				$("#login_"+tagOther+"_ok").hide();
			} else {
				getCaptcha(site);
				$("#"+tag+"_login").show();
				$("#"+tagOther+"_login").hide();
				$("#login_"+tag+"_ok").hide();
				$("#login_"+tagOther+"_ok").hide();
				return false;
			}
		}
	});
}

/**
* A端注册页面
**/
function gotoUrl(type)
{
	if (type=='qiye')
		var url ="index.php?m=company&a=register";
	else
		var url ="index.php?m=blog&a=register";
	window.open(url);
}
/**C端注册页面*/
function gotoCUrl()
{
	var url ="http://www.weiboyi.com/bozhu_woyaozhuanqian.html";
	window.open(url);
}
/**
* 登录验证
*/
function loginCheck(site)
{
	if(site == "qiye")
	{
		var username_qiye = $("#username_qiye").val();
		var password_qiye = $("#password_qiye").val();
		var captcha_qiye = $("#captcha_qiye").val();
		if(username_qiye == "")
		{
			alert("用户名不允许为空");
			return false;
		}
		/*if(username_qiye.length<6 || username_qiye.length>22)
		{
			alert("用户名长度应为6-22位");
			return false;
		}*/
		if(!checkSpecicalCharacter(username_qiye))
		{
			alert("用户名必须只能包含字母和数字");
			return false;
		}

		if(password_qiye == "")
		{
			alert("密码不允许为空");
			return false;
		}

		if(captcha_qiye == "")
		{
			alert("验证码不允许为空");
			return false;
		}
		if(!checkSpecicalCharacter(captcha_qiye))
		{
			alert("验证码不正确");
			return false;
		}
	}else if(site == "bozhu"){
		var username_bozhu = $("#username_bozhu").val();
		var password_bozhu = $("#password_bozhu").val();
		var captcha_bozhu = $("#captcha_bozhu").val();
		if(username_bozhu == "")
		{
			alert("用户名不允许为空");
			return false;
		}
		/*if(username_bozhu.length<6 || username_bozhu.length>22)
		{
			alert("用户名长度应为6-22位");
			return false;
		}*/
		if(!checkSpecicalCharacter(username_bozhu))
		{
			alert("用户名必须只能包含字母和数字");
			return false;
		}

		if(password_bozhu == "")
		{
			alert("密码不允许为空");
			return false;
		}

		if(captcha_bozhu == "")
		{
			alert("验证码不允许为空");
			return false;
		}
		if(!checkSpecicalCharacter(captcha_bozhu))
		{
			alert("验证码不正确");
			return false;
		}
	}else{
		alert("Error");
		return false;
	}
	return true;
}
/**验证特殊符号*/
function checkSpecicalCharacter(str)
{
	 var  regExp = /^[0-9A-Za-z]+$/i;
     if(regExp.test(str))
     {
         return true;
     }else
     {
        return false;
	 }
}
/**保留cookie***/
function createAndSaveCookie(site)
{
	if(site == "qiye")
	{
		if($("#save_qiye").attr("checked"))
		{
			setCookie("username_qiye",$("#username_qiye").val(),24,"/");
            setCookie("password_qiye",$("#password_qiye").val(),24,"/");
			setCookie("save_qiye",1,24,"/");
		}else{
			deleteCookie('username_qiye',"/");
			deleteCookie('password_qiye',"/");
			deleteCookie('save_qiye',"/");
		}
	}else if(site == "bozhu")
	{
		if($("#save_bozhu").attr("checked"))
		{
			setCookie("username_bozhu",$("#username_bozhu").val(),24,"/");
			setCookie("save_bozhu",1,24,"/");
		}else{

			deleteCookie('username_bozhu',"/");
			deleteCookie('save_bozhu',"/");
		}
	}
}


//title
function createXMLHttp(){

		var request;
		var browser=navigator.appName;

		if(browser=="Microsoft Internet Explorer"){
			request=new ActiveXObject("Microsoft.XMLHttp");
			return request;
		}else{
			request=new XMLHttpRequest();
			return request;
		}
	}

	var xhr=createXMLHttp();

	function HelloSunyang(){

		var url="/auto_infor/source.json";

		xhr.open("GET",url,true);

		xhr.onreadystatechange=getHello;

		xhr.send(null);

	}

	function getHello(){
		if(xhr.readyState==4){
			var helloStr = xhr.responseText;
            if(Math.random()>0.5){
//            document.getElementById('success_anli').innerHTML='<div class="xoxo"><img src="img/zouxiu.jpg" /><div class="xoxo_right fl"><h2>走秀网</h2><p style="margin-bottom:5px;">各款手袋在丰富的夏日生活里大显身手，明亮艳色是绝对主打，复古风仍在延续，桶形波士顿包令你有型有款。。。</p><span class="wu">2分钟前</span><a href="#"><span>转播</span></a><a href="#" class="back"><span>对话</span></a></div>         </div>         <div class="zhuanfa"><img src="img/fa.jpg" /></div>         <div class="pic" style="overflow:hidden">            <img src="img/mb2.jpg" class="tutu"/><img src="img/mb8.jpg" /><img src="img/mb11.jpg" /><img src="img/mb22.jpg" /><img src="img/mb30.jpg" /><img src="img/mb14.jpg" /><span>真实粉丝数：<br/>200000000人</span></div>';
            }
            json=eval('('+helloStr+')');
            document.getElementById('account_num').innerHTML=json.account_num;
            document.getElementById('follows_num').innerHTML=json.followers_num;
            document.getElementById('company_num').innerHTML=json.company_num;
            document.getElementById('order_num').innerHTML=json.order_num;
            setInterval("followersAdd()",1000);

		}
	}
//    window.onload=HelloSunyang;
    function followersAdd() {
        now=document.getElementById('follows_num').innerHTML;
        now=Number(now);
        document.getElementById('follows_num').innerHTML=now;
    }
	$(function(){
		HelloSunyang();
		})