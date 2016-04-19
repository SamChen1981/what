// JavaScript Document
$(document).ready(function(){
//停留在页面固定位置
   $(window).scroll(function(){
		  s_height = document.documentElement.scrollTop;  //获取滚动条的高度
		  if ($.browser.msie && ($.browser.version == "6.0") && !$.support.style) {
          $('.fk').css('top',60+s_height);//判断浏览器的脚本
           }
		  if ($.browser.msie && ($.browser.version == "8.0") && !$.support.style) {
          $('.fk').css('position','fix');//判断浏览器的脚本
           }

		})
//停留在页面固定位置
//返回顶部js

	$('.fk_btn').click(function(){
		
		$.blockUI({ message:$('#liuyan'),css: {border:'2px solid #ffb400',left:'30%',top:'30%',cursor:'default',width:'377px',height:'295px'}});
	})
	$('#text').keyup(function(){
		var input_num = $('#text').val().length;
		var num =parseInt($('#num').text());
		if(input_num < num){
			$('#num').text(num-input_num);
			$('.liuyan_p2').hide();
			$('.liuyan_p1').show();
			}
			else{
			 $('#num2').text(input_num-num);
			 $('.liuyan_p1').hide();
			 $('.liuyan_p2').show();
			};
	 });
	$('.tj_btn').click(function(){
	  re=phone();
	  if($('#phone').val().length == 0 || re==false){
		 $('#tip1').hide();
		 $('#tip').show();
		  return false;
		}
	  else{
		  $.unblockUI();
		  $('.tj_succ').css('display','block');
		  setTimeout(
				 function(){$('.tj_succ').css('display','none');},1000)
		  }
	});
	     $('#phone').blur(function(){
			 re=phone();
		 if($('#phone').val().length == 0 || re==false){
		 $('#tip1').hide();
		 $('#tip').show();
         return false
		  }
		  else{
			 $('#tip').hide();
			 $('#tip1').hide();
		  }
		 });

	  if($('#phone').val().length != 0){
		  $('#tip').hide();   
		 }
});

function phone(){
	  // 判断手机号
	  var mphone = /^(13[0-9]|15[0|1|2|3|5|6|7|8|9]|18[0|2|3|5|6|7|8|9]|14[7])\d{8}$/;
	  // 判断固定电话
	  var phone = /^((0?\d{3}-)?\d{5,10}\/?)*((0?\d{3}-)?\d{5,8}\/?)*((0?\d{3}-)?\d{3,4}\/?)$/;
	  var contactCellPhone = document.getElementById("phone").value;

	  if(!phone.test(contactCellPhone) || !mphone.test(contactCellPhone)){
		  var result = false;
	  }else{
		  var result = true;
	  }
	  return result;
}


//成功案例弹出

$('.anli_list li').mouseover(
	function(){
		var i = $(this).position();
        i.top = i.top;
        i.left = i.left+160;
		$(this).next('.brief').css('top',i.top).css('left',i.left).show();							 
	 }
	)
$('.anli_list li').mouseleave(
	function(){
		$(this).next('.brief').hide();	
	 }
	)