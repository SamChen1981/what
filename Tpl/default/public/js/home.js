function change_verify(){
    $("#verify_image").attr("src", "{$verify}&md=" + Math.random());
}
function login_submit(){
    var uname = $("#username").val();
    var passwd = $("#password").val();
    var verify = $("#verify").val();
    var remember = $("#remember").val();
    if(!reg.string.test(uname)){
        alert("请输入正确的用户名！"); $("#username").focus();
    }else if(!passwd || passwd.length < 4){
        alert("请输入长度大于4的登录密码！"); $("#password").focus();
    }else if(!verify || verify.length != 4){
        alert("请输入4位数的验证码！"); $("#verify").focus();
    }else{
        $.ajax("/Member/signup", {
            type: "post",dataType: "json",
            data: {username: uname, password: passwd, verify: verify,remember: remember},
            beforeSend: function(){ $("#login-mark").show(); },
            success: function(request){
                if(request.status==1){
                    build_login(request.data);
                    location.href = request.data.jumpUrl+'?sessionid='+ request.data.sessionid;
                }else{
                    change_verify();
                    alert(request.info);
                }
                $("#login-mark").hide();
            }
        });
    }
}
function build_login(data){
    var html = '<ul><li>'+ data.hello + '<span style="color:#00a1e9;">'+(data.contact?data.contact:data.username) +'</span></li>';
    html+= '<li style="font-size:12px;color:#999;margin-top:5px;">上次登录时间：'+ data.lasttime +'</li>';
    html+= '<li style="font-size:12px;color:#999;">上次登录ＩＰ：'+ data.lastip +'</li>';
    html+= '</ul><div>';
    html+= '<ul class="form_menu bullet-5" style="margin-bottom:30px;">'
    html+= '<li><a href="'+data.poster_host+'/Account/info.html">个人信息</a></li>';
    html+= '<li><a href="'+data.poster_host+'/Task/lists.html">我的活动</a></li>';
    html+= '<li><a href="'+data.poster_host+'/Dinner/lists.html">我的套餐</a></li>';
    html+= '<li><a href="'+data.poster_host+'/Bill/payoff.html">财务明细</a></li>';
    html+= '<li><a href="/Member/logout.html" style="color:red;">安全退出</a></li>';  
    html+= '</ul>'
    html+= '<a href="'+ data.jumpUrl +'?sessionid='+ data.sessionid +'"><img src="/Public/images/home/goto.jpg" border="0"></a><br/>';
    html+= '';
    html+= '</div>';
    $("#login-info").html(html).show();
}
$(function(){
    $.post("/Member/checkLogin",{},function(request){
        if(request.status == 1){
            build_login(request.data);
        }
    },"json");
});

