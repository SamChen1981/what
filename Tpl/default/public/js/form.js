var reg = {
    url: /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,
    email: /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
    string: /^[\u4e00-\u9fa5|\xe0-\xef|\x80-\xbf|a-z|A-Z0-9\-\_]+$/,
    phone: /^1[3|4|5|8][0-9]{9}$/,
    chinese: /^[\u4e00-\u9fa5|\xe0-\xef|\x80-\xbf]+$/,
    number: /^\d+$/,
    require: /.+/,
    money:/^\d+(\.\d{1,2})?$/
};
function select_row($obj){
    var $this = $obj.parent();
    if($this.is(".clearfix")){
        return $this;
    }else{
        return select_row($this);
    }
}
function select_row_error($obj){
    var $this = $obj.next();
    if($this.is(".help-inline")){
        return $this;
    }else{
        return select_row_error($this);
    }
}
function change_status($obj, status, msg){
    var obj = select_row($obj);
    var txt = select_row_error($obj);
    if(status == "loading"){
        txt.html("<img src='"+__public__+"/images/loading.gif'> 校验中...");
    }else if(status == "error"){
        obj.removeClass("success").addClass("error");
        txt.html("<img src='"+__public__+"/images/poster/task_verify.png'> "+msg);
    }else{
        obj.removeClass("error").addClass("success");
        txt.html("<img src='"+__public__+"/images/poster/task_finish.png'>");
    }
}
function check_input($this, $reg, msg){
    if(!$reg.test($($this).val())){
        change_status($($this), "error", msg);
    }else{
        change_status($($this));
    }
}
function check_keyup(obj, check, msg){
    var $obj = $(obj);
    var val = $obj.val();
    if($.isArray(check) && !$.isEmptyObject(check)){
        for(var i=0;i<check.length;i++){
            if($.isArray(check[i]) && !$.isEmptyObject(check[i])){
                if(val.length<check[i][0] || val.length>check[i][1]){
                    change_status($obj, "error", msg[i]);
                    break;
                }else{
                    change_status($obj);
                }
            }else{
                if(!check[i].test(val)){
					change_status($obj);
                    //change_status($obj, "error", msg[i]);
                    break;
                }else{
                    change_status($obj);
                }
            }
        }
    }else{
        if(!check.test(val)){
            change_status($obj, "error", msg);
        }else{
            change_status($obj);
        }
    }
}
function checktime(t){
    /*传递进来的时间转换成时间戳*/
    var times=Date.parse(t.replace(/\-/g,"/"));
    var now=new Date();
    /*当前时间的时间戳*/
    var nowtime=Date.parse(now);
    /*获取两天后的时间戳*/
    now.setDate(now.getDate()+7);
    var year=now.getFullYear();
    var month=now.getMonth()+1;
    var day=now.getDate();
    var hour=now.getHours();
    var minute=now.getMinutes();
    var second=now.getSeconds();
    var twoday=year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
    var aftertwoday=Date.parse(twoday.replace(/\-/g,"/"));
    //传递过来的和当前的时间差
    var cha = times-nowtime;
    if( cha > 60*30*1000 && times < aftertwoday) {
        return true;
    }else {
        return false;
    }
}
