<?php


class cron  {    
  //活动开始操作
	function start_active($info)
	{
			return true;
	}
	
	//活动结束操作
	function finish_active($info)
	{
			$cron =M('cron');
			$data['cronid'] = C('cronid');
			if ($info['nextrun']<=time())
			{
				$tb = M('task_blog');
				$da['task_id'] = $info['pkey'];
				$d['reject'] = '4';
				$tb->where($da)->save($d);
				$task = M('task');
				$t = $task ->where($da)->find();
				$da['ld_num'] = $t['yp_num']-$t['url_num'];
				$task->save($da);
			}
			$data['available'] =0; //重新等待下一次执行						
			$cron->save($data);
	}
	
	//前10分钟发送短信
	function sms_active($info)
	{
		$cron =M('cron');
		$data['cronid'] = C('cronid');
		if ($info['nextrun']<=time())
		{
			import("@.Action.adminAction");
			$admin = new adminAction();
			if ($info = is_send(8))
			{
				$d['tb.task_id'] = $info['task_id'];
				$tbm = D('taskbmView');
				$list = $tbm->where($d)->group('bm.member_id')->select();
				foreach($list as $val)
				{
					$array=array('money'=> $info['money']);
	    		$content = $admin->get_draw_theme($info['content'],$array);
	    		$err = send_sms($val['phone'],$content);
				}
			}
		}
		$data['available'] =0; //重新等待下一次执行						
		$cron->save($data);
	}

}
?>