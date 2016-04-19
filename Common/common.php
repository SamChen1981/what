<?php


//初始化全局变量
function initial_global()
{
	if (file_exists(RUNTIME_PATH.'~appvartime.php'))
	{
		if (function_exists('core_set'))
		{
			C(core_set());
			return ;
		}else{
			//要求系统重新生成核心缓存
			file_put_contents(RUNTIME_PATH.'~var.lock','');
			return ;
		}		 
	}
	$config=M('config');
	$name=array('shop_config','pay');
	$str = "<?php\n function core_set(){ return array(";
	foreach($name as $val)
	{
		$data['name']=$val;
		$value =$config->where($data)->getField('value');
		$value=unserialize($value);	
		C($value);	
		foreach($value as $key=> $val)
		{
				$str .='\''.$key.'\'=>';
				if (is_int($value[$key]))
					$str .=$val.',';
				else
					$str .='\''.$val.'\',';	
		}				
	}
	//获取计划任务
	$cron =M('cron');	
	$d['available']='0';
	$info =$cron->where($d)->field('cronid,nextrun,lastrun')->order('nextrun asc')->find();
	if ($info['lastrun']< $info['nextrun'])
	{
		unset($info['lastrun']);
		C($info);
		foreach($info as $key=> $val)
		{
			$str .='\''.$key.'\'=>';
			if (is_int($value[$key]))
				$str .=$val.',';
			else
				$str .='\''.$val.'\',';	
		}
	}
	//获取计划任务结束	
	unset($value);
	$str .=');}';
	//生成全局变量缓存文件
	file_put_contents(APP_PATH.'/Runtime/~appvartime.php',$str);
	//要求系统生成运行缓存
	file_put_contents(APP_PATH.'/Runtime/~var.lock','');
	unset($str);
}


//初始化头变量
function initial_aign()
{
	initial_global();	
	//判读是否有待执行任务
	if (C('nextrun')<=time() && C('nextrun'))
	{
			ignore_user_abort();
			set_time_limit(60);	
			cron_run();
	}
}
	
	
	//获取当前用户所属地址id
	function get_user_reid()
	{
			import("Com.czip");
			$dat = new selectip();
			$ip=get_client_ip();
			$addre = $dat->convertip($ip);
			$addre = iconv('GB2312','UTF-8',$addre);
			$region = M('region');
			$data['index']='1';
			$list = $region->where($data)->field('region_name,region_id')->findAll();
			foreach($list as $val)
			{				
				if (stripos($addre,$val['region_name']))
					return $val['region_id'];
			}
			return false;
	}
	
	
	//执行任务
	function cron_run()
	{
			$cron =M('cron');
			$data['cronid'] = C('cronid');
			$info = $cron->where($data)->find();
			$data['lastrun'] =time();
			//天循环任务，无需锁定，直接进入执行队列
			if ($info['day']> 0)
			{
				$data['available'] =0;
				$t=24*60*60*$info['day'];
				$nextrun  =C('nextrun')+ $t;
				//循环判断是否超时				
				while(1){
					if ($nextrun < time())
					{
						$nextrun +=$t;						
					}else{
						$data['nextrun']=$nextrun;
						break;
					}
				}
			}elseif ($info['other']==1){ //活动任务
				if ($info['action']=='sms_active')
				{
					$dat['state']='1';
					$dat['sms']='0';
					$active =$task->where($dat)->order('begintime asc')->find();
					if (!$active)
						$data['available']='3';
					else{
						$data['nextrun']=$active['begintime']-600;
						$data['pkey'] = $active['task_id'];
						$data['available'] =0;
					}
				}else{
					$data['available'] =0;
					$task = M('task');
					$dat['task_id']=$info['pkey'];
					$dat['state'] = $info['data'];
					$task->save($dat);
					$dat['state'] = $info['data']-1;
					$dat['pay_state']='Y';
					$active =$task->where($dat)->order('begintime asc')->find();
					if (!$active)
						$data['available']='3';
					else{
						$data['nextrun'] = $active['begintime'];
						$data['pkey'] = $active['task_id'];
					}
				}			
			}else
				$data['available'] =1;  //锁定任务			
			$cron->save($data);
	 		@unlink(APP_PATH.'/Runtime/~appvartime.php');
	 		import('Com.cron');
	 		$common = new cron();			
			$common-> $info['action']($info);	
	}
	
	//信息模版判断公共函数
	function is_send($id)
	{
		$theme = M('theme');
		$data['theme_id'] =$id;
		$info = $theme->where($data)->field('status,content,name')->find();
		if ($info['status'])		
			return $info;
		else
			return 0;
	}
	
	//水印公共函数
	function image_water($file)
	{
		if (!C('shop_water'))
			return ;
		import('ORG.Util.upImageWater');
		$config = M('config');
		$data['name'] = 'water';
    $info = $config->where($data)->getField('value');
    $info=unserialize($info);
		$water = new upImageWater($file,$info['site']);
		if ($info['type'])	 
			$water->setWaterImageInfo($info['image'],$info['pct']); 
		else
			$water->setWaterTextInfo($info['text'],$info['color'],$info['size']); 
		return $water->makeWater();
	}
	
	//发送短信公共接口
	function send_sms($mobile,$content)
	{
		import('ORG.Util.sms');
		$config = M('config');
		$data['name'] = 'sms';
    $info = $config->where($data)->getField('value');
    $info=unserialize($info);
		$sms = new sms();
		$sms->uid = $info['uid'];		//用户账号
		$sms->pwd = $info['pwd'];		//密码
		$sms->mobile	 = $mobile;	//号码
		$sms->content = $content;		//内容
		return $sms->sendSMS();
	}
	
	
	//公共邮件发送类
	function send_email($to,$subject = "",$body = "",$username='')
	{
		 //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
    //error_reporting(E_ALL);
    import('Think.Util.phpmailer');
    import('Think.Util.smtp');
    $config = M('config');
	  $data['name'] = 'email';
    $info = $config->where($data)->getField('value');
	  $info=unserialize($info);
    $mail             = new PHPMailer(); 
    $body             = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
    $mail->CharSet ="UTF-8";
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug  = 0;                     // 启用SMTP调试功能
    $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
    $mail->SMTPSecure = ($info['ssl']) ? 'ssl' : '' ; // 安全协议
    $mail->Host       = $info['host'];      
    $mail->Port       = $info['port'];                   
    $mail->Username   = $info['username'];  
    $mail->Password   = $info['password'];            
    $mail->SetFrom($info['addreply'], C('shop_name'));  
    $mail->AddReplyTo($info['addreply'],'');  //回复人地址
    $mail->Subject    = $subject;
    $mail->AltBody    = ''; 
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, $username);
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment 
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // 附件
    if(!$mail->Send()) {
    	return array('error'=> 1,'msg'=> $mail->ErrorInfo);
    } else {
      return array('error'=> 0,'msg'=>'send success!');
    }

	}	
	
	//用户积分操作日志
	function scorelog($event,$score,$uid=0)
	{
		if (!$uid)
			$uid=$_SESSION['uid'];
		$log = M('users_score_log');
		$data['user_id'] = $uid;
		$data['event'] = $event;
		$data['number'] = $score;
		$data['add_time'] = time();
		$log->add($data);
	}
	
	//D币操作日志 $type 操作说明,+/-D币数,店铺id,店铺风格
	function dbilog($type,$dbi,$sid=0,$shop_type=0)
	{
		if (!$sid)
		{
			$sid=$_SESSION['sid'];
			$shop_type=$_SESSION['shop_type'];
		}
		$log = M('pay_ment');
		$data['shop_id'] = $sid;
		$data['shop_type'] = $shop_type;
		$data['type']= $type;
		$data['dbi'] = $dbi;
		$data['state'] = 2;
		$data['time'] = time();
		$log->add($data);
	} 

	//后台上传图片公共函数
	function upimage($file,$is_water=false,$th=false)
	{
		if ($is_water!==0) //0 为特殊状态
			if (empty($_FILES['photo']['type']))
				return false;
		$is_thumb = (C('shop_thumb') && $is_water);
		if ($th)
			$thumb='ys_,thumb_';
		else
		  $thumb='ys_';
		import("ORG.Net.UploadFile");
		$upload = new UploadFile();		
		$upload->savePath='./upload/'.$file;
		$upload->maxSize  = 3145728 ; // 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
		$upload->saveRule = 'uniqid';
		$upload->thumb = $is_thumb;
		$upload->thumbMaxWidth = C('shop_image_w');
		$upload->thumbMaxHeight = C('shop_image_h');
		$upload->thumbPrefix = $thumb;
		$upload->thumbRemoveOrigin = true;
		$upload->autoSub=true;
		$upload->subType='date';
		if(!$upload->upload()) { // 上传错误提示错误信息
			echo '<script>alert("'.$upload->getErrorMsg().'")</script>';
		}else{ // 上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo();
			//是否启用缩略图
			if ($th)
				$info[0]['thumb']=$upload->savePath.'thumb_'.$info[0]['savename'];
			//是否使用压缩图功能
			if ($is_thumb)
				$info[0]['savename'] = $upload->savePath.'ys_'.$info[0]['savename'];
			else
				$info[0]['savename'] = $upload->savePath.$info[0]['savename'];
			
			//是否加水印
			if ($is_thumb)
				image_water($info[0]['savename']);
			return  $info;
		}
	}



// 获取客户端IP地址
function get_client_ip(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
       $ip = getenv("HTTP_CLIENT_IP");
   else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
       $ip = getenv("HTTP_X_FORWARDED_FOR");
   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
       $ip = getenv("REMOTE_ADDR");
   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
       $ip = $_SERVER['REMOTE_ADDR'];
   else
       $ip = "unknown";
   return($ip);
}

	/**更新用户等级 经验
	* @param string $user_id 更新用户user_id
  * @param string $num	   增加的经验数（可选，默认1）
  * @param string $score	   增加的积分数（可选，默认c变量）
  * @param string $score	   订单消费金额（可选）
  **/
	function update_exp($user_id,$money,$num,$score)
	{
		if (empty($user_id))
			exit('更新用户等级失败，user_id未传入');
		$user = M('users');
		$users_rank = M('users_rank');
		$key['user_id']=$user_id;
		$exp = $user->where($key)->getField('user_exp');
		$score_now = $user->where($key)->getField('user_score');
		$num = $num ? $num : 1;  //经验默认为1
		$score = $score ? $score : C('point_order');  //积分默认为后台设置的变量
		$data['user_exp']=$exp+$num;
		$level['min_point']=array('elt',$data['user_exp']);
    $level['max_point']=array('egt',$data['user_exp']);
		$data['user_level']=$users_rank->where($level)->getField('urank_id');
		scorelog('完成订单交易','+'.C('point_order'),$user_id); //写入日志
		if ($money > 0)
		{
			$money = $money/C('point_consume');//消费金额除以单个积分兑换所需的金钱个数
			if ($money > C('point_top'))
				$money = C('point_top'); //大于封顶积分时采用封顶积分
			$money = intval($money);
			scorelog('消费积分','+'.$money,$user_id); //写入日志
		}
		$data['user_score']=$score_now+$score+$money;
		$user ->where($key)->save($data);
		return true;
	}
	
	
/**
 +----------------------------------------------------------
 * 字符串截取，支持中文和其他编码
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true)
{
    if(function_exists("mb_substr"))
        return mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        return iconv_substr($str,$start,$length,$charset);
    }
    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}




?>