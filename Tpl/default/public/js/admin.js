
/*
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
    window.onload=HelloSunyang;
    function followersAdd() {
        now=document.getElementById('follows_num').innerHTML;
        now=Number(now);
        document.getElementById('follows_num').innerHTML=now;
    }
*/