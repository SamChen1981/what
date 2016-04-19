<?php
define( "COOKIEJAR", 'coo98E3.tmp');   //定义COOKIES存放的路径,要有操

$url='https://api.weibo.com/oauth2/authorize?client_id=1028527169&redirect_uri=http://www.hinigo.com/weibo/callback.php&response_type=code';
$url='https://api.weibo.com/oauth2/authorize';
//$url = 'https://crmct.chnl.zj.chinamobile.com/crm/ams/agent/AgentCardCharge.jsp';
//$url = 'http://movie.jxut.edu.cn/Vote.asp?id=18';
//$url = 'http://movie.jxut.edu.cn/inc/code.asp';
//$url = 'http://movie.jxut.edu.cn/submit.asp';
//$url = 'http://movie.jxut.edu.cn/index.asp';

$data= array(
		'action'=> 'submit',
		'withOfficalFlag'=> '0',
		'ticket'=> '',
		'isLoginSina'=> '',
		'response_type'=> 'code',
		'regCallback'=> '',
		'redirect_uri'=> 'http://www.hinigo.com/weibo/callback.php',
		'client_id'=> '1028527169',
		'state'=> '',
		'from'=> '',
		'userId'=> 'iloveufly@qq.com',
		'passwd'=> 'goodluck',		
	);


$head = get_header($url,$data); //获取 session id
echo $head;
exit;
//exit;
//getValite();
//login();
getMoney();
//echo login();
//exit;

//for ($i=0; $i<=5000; $i++)
//{
//	sendNote();  //发送数据
//}

	//curl操作
	function get_header($url,$post_fields){
	 $ch  = curl_init();
	 curl_setopt($ch, CURLOPT_URL, $url);
	 curl_setopt($ch, CURLOPT_HEADER, 0);
	 curl_setopt($ch, CURLOPT_NOBODY,false);
	 //curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	 //curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
	 //curl_setopt($ch, CURLOPT_COOKIE,'ASPSESSIONIDQCCRCQQQ=CEJDFFIACMJPPAKPMAODAAIF');
	 curl_setopt($ch, CURLOPT_COOKIEJAR, COOKIEJAR);
	 curl_setopt($ch, CURLOPT_COOKIEFILE, COOKIEJAR );
	 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
	 //curl_setopt($curl, CURLOPT_CAPATH, "/certificate"); 
	 //curl_setopt($curl, CURLOPT_CAINFO, "/certificate/server.crt"); 
	 //curl_setopt($ch, CURLOPT_AUTOREFERER,true);
	 //curl_setopt($ch, CURLOPT_TIMEOUT,30);
	 
	 
	 curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	 'Content-Type: multipart/form-data',
	 'Accept: */*',
	 'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
	 'Connection: Keep-Alive'));
	 curl_setopt($ch, CURLOPT_POST, 1);
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
	 $header = curl_exec($ch);
	 return $header;
	}

function getMoney()
{
	$postData = '<FormInfo formid="DBFormCustomer" setname="com.asiainfo.crm.ams.balance.web.SETPayOweCustInfo" datamodel="com.ai.appframe2.web.datamodel.MethodModelForService" editable="true" implservice_name="com.asiainfo.crm.ams.agent.service.interfaces.IAmAgentCustomerSV" implservice_querymethod="getCustomerInfoForSafe(String billId)" conditionname="condition" cols="ACCT_ID;ACCT_TYPE;USER_ID;USER_BRAND_ID;USER_REGION_ID;CUST_ID;ACCT_REGION_ID;USER_COUNTRY_CODE;ACCT_TYPE_DISPLAY"  >
</FormInfo>';
	$con = urlencode('billId=13506889848&CenterType=BillId&CenterValue=13506889848');
	$url='https://crmct.chnl.zj.chinamobile.com/dbformrefresh?action=refresh&pk=-1&'.$con.'&url_source=XMLHTTP';

	$head = get_header($url,$postData);
	echo $head;
	exit;
}

function getImgValite()
{
	header('Content-type: image/png');
	$url = 'http://www.malago.cn/captcha.php?is_login=1';
	$head = get_header($url,$post_fields);
	echo $head;
}

function login()
{
	$url = 'https://crmct.chnl.zj.chinamobile.com/baseserver?CHANNEL_ID=1&EventID=1&LOGIN_USRNAME=tianqilong&LOGIN_PSWD=Nh123456&LOGIN_VERFYCODE=6047&IP_ADDR=&MAC_ADDR=123456';
	$head = get_header($url,array());
	echo $head;
	exit;
	$post_fields = array();
	$post_fields['username'] = '麻辣商城';
	$post_fields['password'] = 'malagou';
	$post_fields['act'] = 'act_login';
	$post_fields['back_act'] = '';
	$post_fields['captcha'] = 'zmj4';
	$url = 'http://www.malago.cn/user.php';
	$head = get_header($url,$post_fields);
	return $head;
}


function sendNote()
{
	$post_fields = array();
	$post_fields['msg_title'] = '这个也太容易破解了！继续努力，今天就刷少点';
	$post_fields['msg_content'] = '例如：华东交大/1栋/1单元/101室';
	$post_fields['act'] = 'act_add_message';
	$url = 'http://www.malago.cn/user.php';
	$head = get_header($url,$post_fields);
	return $head;
}

//发送post数据包
function sendPost($num,$valite)
{
	$post_fields = array();
	$post_fields['username'] = '这个也太容易破解了！继续努力，今天就刷少点'.$num;
	$post_fields['address'] = '例如：华东交大/1栋/1单元/101室';
	$post_fields['telphone'] = '2767473637';
	$post_fields['password'] = 'admin';
	$post_fields['repassword'] = 'admin';
	$post_fields['realname'] = '2767473637';
	$post_fields['yzm'] = $valite['yzm'];
	$post_fields['i'] = $valite['pnum'];
	$url = 'http://www.malago.cn/';
	$head = get_header($url,$post_fields);
	return $head;
}


//获取验证码
function getValite()
{	
	$url = 'https://crmct.chnl.zj.chinamobile.com/vertifycodeservlet';
	$head = get_header($url,array());
	echo $head;
	exit;
	eregi('验证码/yzm(.*).jpg',$head,$arr);
	return array('yzm' => valite($arr[1]),'pnum' => $arr[1]);
	
	$valite = new Valite();
	$valite->setImage($head);
	$valite->getHec();
	$ert = $valite->run();
	return $ert['red'].'/'.$ert['blue'];
}

//计算验证码
function valite($pnum)
{

	$_key = array( 
		'1' => '7/7',
		'2' => '3/5',
		'3' => '5/5',
		'4' => '4/4',
		'5' => '4/7',
		'6' => '4/3',
		'7' => '7/4',
		'8' => '6/6',
		'9' => '5/9',
		'10' => '8/3'	
	);
	
	return $_key[$pnum];
}


//  通过此方法保存模型验证码
function GrabImage($url,$filename="") { 

	$ext= '.png'; 

	$filename=date("dMYHis").$ext; 
	ob_start(); 
	readfile($url); 
	$img = ob_get_contents(); 
	ob_end_clean(); 
	$size = strlen($img); 
	$fp2=@fopen($filename, "a"); 
	fwrite($fp2,$img); 
	fclose($fp2); 
	return $filename; 
} 
$img=GrabImage("http://www.yonglejia.com/user/code.php?image"); 
echo $img;
exit;




$head = get_headers('http://www.yonglejia.com/user/code.php?image');
//header('Content-type:image/jpeg');
//echo file_get_contents('http://www.yonglejia.com/user/code.php?image');
echo "<pre>";
var_dump($head);

exit;
// create a new curl resource 
$ch = curl_init(); 
// set URL and other appropriate options 
curl_setopt($ch, CURLOPT_URL, "http://www.baidu.com/"); 
// grab URL and pass it to the browser 
curl_exec($ch); 
// close curl resource, and free up system resources 
curl_close($ch); 
?> 
?>