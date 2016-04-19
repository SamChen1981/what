<?
/*--------------------------------
说明:		http://http.c123.com/tx/?uid=用户账号&pwd=MD5位32密码&mobile=号码&content=内容
状态:
	100 发送成功
	101 验证失败
	102 短信不足
	103 操作失败
	104 非法字符
	105 内容过多
	106 号码过多
	107 频率过快
	108 号码内容空
	109 账号冻结
	110 禁止频繁单条发送
	111 系统暂定发送
	112 号码不正确
	113 定时时间不对
	120 系统升级
--------------------------------*/
class sms{
	
	public $dtime='';
	//定时发送
	public $mid='';
	/*
	$time = '2010-05-27 12:11';
	$res = sendSMS($uid,$pwd,$mobile,$content,$time);
	echo $res;
	*/
	function sendSMS()
	{
		$http = 'http://http.c123.com/tx/';
		$data = array
			(
			'uid'=> $this->uid,					//用户账号
			'pwd'=>strtolower(md5($this->pwd)),	//MD5位32密码
			'mobile'=> $this->mobile,				//号码
			'content'=> $this->content,			//内容
			'time'=> $this->dtime,		//定时发送
			'mid'=> $this->mid,						//子扩展号
			'encode'=> 'utf8',
			);
		$re=$this-> postSMS($http,$data);			//POST方式提交
		if( trim($re) == '100' )
		{
			return array('error'=> 0,'msg'=>'发送成功');
		}
		else 
		{
			return array('error' => 1,'msg'=>'发送失败，状态：'.$re);
		}
	}
	
	function postSMS($url,$data='')
	{
		$row = parse_url($url);
		$host = $row['host'];
		$port = $row['port'] ? $row['port']:80;
		$file = $row['path'];
		while (list($k,$v) = each($data)) 
		{
			$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
		}
		$post = substr( $post , 0 , -1 );
		$len = strlen($post);
		$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
		if (!$fp) {
			return "$errstr ($errno)\n";
		} else {
			$receive = '';
			$out = "POST $file HTTP/1.1\r\n";
			$out .= "Host: $host\r\n";
			$out .= "Content-type: application/x-www-form-urlencoded\r\n";
			$out .= "Connection: Close\r\n";
			$out .= "Content-Length: $len\r\n\r\n";
			$out .= $post;		
			fwrite($fp, $out);
			while (!feof($fp)) {
				$receive .= fgets($fp, 128);
			}
			fclose($fp);
			$receive = explode("\r\n\r\n",$receive);
			unset($receive[0]);
			return implode("",$receive);
		}
	}
}
?>