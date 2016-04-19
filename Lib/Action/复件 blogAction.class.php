<?php

class blogAction extends Action
{
    public function check()
    {
        if ($_SESSION['uid']<=0)
            $this->redirect('blog/login',array('cate_id'=>2),0,'请先登录');
    }
    public function index()
    {
        $this->display();
    }
    public function register()
    {
        $this->assign('login',U('blog/login'));
        $this->assign('verify',U('blog/verify'));
        $this->assign('checkUsername',U('blog/checkUsername'));
        $this->assign('checkVerify',U('blog/checkVerify'));
        $this->assign('hregister',U('blog/hregister'));
        $this->display();
    }
    public function hregister()
    {
        $mem = M('blog_member');
        $data['username'] = $_POST['username'];
        if ($mem->where($data)->find())
            $this->error('注册失败,用户已存在');
        $data['password'] = md5($_POST['password']);
        $data['realname'] = $_POST['username'];
        $data['phone'] = $_POST['username'];
        $data['contact'] = $_POST['contact'];
        $data['qq'] = $_POST['qq'];
        $data['email'] = $_POST['email'];
        $data['alipay_account'] = $_POST['alipay_account'];
        $data['alipay_realname'] = $_POST['alipay_realname'];
        $data['reg_ip'] = $this->getIp();
        $data['regtime'] = time();
        $data['lasttime'] = time();
        $data['wedlock'] = '1';
        $platform = $_POST['platform'];
        $name = $_POST['name'];
        $weibo = $_POST['weibo'];
        $fansnum = $_POST['fansnum'];
        $verifyinfo = $_POST['verifyinfo'];
        $money = $_POST['money'];
        $keywords = $_POST['keywords'];
        $id = $mem->add($data);
        if ($id)
        {
            $_SESSION['uid']=$id;
            $_SESSION['contact']=$data['contact'];
            $_SESSION['username']=$data['username'];
            if ($info = is_send(13))
            {
                $array=array('username'=>$_POST['username']);
                $content = $this->get_draw_theme($info['content'],$array);
                $err =send_email($_POST['email'],$info['name'],$content,$_POST['username']);
            }
            if ($info = is_send(12))
            {
                $array=array('username'=>$_POST['username']);
                $content = $this->get_draw_theme($info['content'],$array);
                $err = send_sms($_POST['username'],$content);
            }
            $this->assign('jumpUrl',U('blog/myindex'));
            $this->success('恭喜您，注册成功！');
        }else{
            $this->error('注册失败');
        }
    }
    function get_draw_theme($content,$array)
    {
        foreach($array as $key=>$value)
            $this->assign($key,$value);
        $name = uniqid();
        $dir = 'Tpl/default/draw/'.$name.'.html';
        file_put_contents($dir,$content);
        $content = $this->fetch('draw:'.$name);
        @unlink($dir);
        return $content;
    }
    public function checkUsername()
    {
        $data['username'] = $_POST['username'];
        $mem = M('blog_member');
        if ($mem->where($data)->find())
            $this->ajaxReturn('','用户名已存在',0);
        else
            $this->ajaxReturn('','',1);
    }
    public function checkVerify()
    {
        if (md5($_POST['verify'])!=$_SESSION['verify'])
            $this->ajaxReturn('','验证码错误',0);
        else
            $this->ajaxReturn('','正确',1);
    }
    public function login()
    {
        if ($_SESSION['uid']>0)
            $this->redirect('blog/myindex');
        $this->assign('hlogin',U('blog/hlogin'));
        $this->assign('verify',U('blog/verify'));
        $this->assign('register',U('blog/register'));
        $this->display();
    }
    Public function verify()
    {
        import("ORG.Util.Image");
        Image::buildImageVerify();
    }
    public function hlogin()
    {
        if (md5($_POST['verify'])!=$_SESSION['verify'])
            $this->ajaxReturn('','验证码错误',0);
        $data['password'] = md5($_POST['password']);
        $data['username'] = $_POST['username'];
        $mem = M('blog_member');
        $info = $mem->where($data)->find();
        if ($info)
        {
            $_SESSION['uid'] = $info['member_id'];
            $_SESSION['contact'] =$info['contact'];
            $_SESSION['username']=$data['username'];
            $data=array();
            $data['lasttime']= time();
            $data['login_count'] = $info['login_count']+1;
            $data['member_id'] = $info['member_id'];
            $mem->save($data);
            $this->ajaxReturn('',U('blog/myindex'),1);
        }
        else
            $this->ajaxReturn('','用户名或密码错误',0);
    }
    public function logout()
    {
        session_unset();
        $this->assign('jumpUrl',U('blog/login'));
        $this->success('恭喜，您已安全退出');
    }
    public function myindex()
    {
        $this->check();
        $task = D('btaskView');
        $data['b.member_id'] = $_SESSION['uid'];
        $data['t.pay_state']=array('eq','Y');
        $data['t.begintime']=array('between',array(strtotime(date('Y-m-d',time())),strtotime(date('Y-m-d',time()).'1day')));
        $dlist = $task->where($data)->order('begintime asc')->select();
        $tj=array();
        foreach($dlist as $val)
        {
            if ($val['type']=='publish')
                $type='publish_pmoney';
            else
                $type='money';
            $tj['5']++;
            $tj['5m'] +=$val[$type];
            $rej = $val['reject'];
            ++$tj[$rej];
            $tj[$rej.'m'] +=$val[$type];
        }
        for($i=0;$i<=5;$i++)
        {
            if($tj[$i]=='') $tj[$i]=0;
            if($tj[$i.'m']=='') $tj[$i.'m']=0;
        }
        $this->assign('tj',$tj);
        if (!empty($_POST['str1']))
        {
            $field=$_POST['field1'];
            if ($field=='order')
                $data['tb.tblog_id'] = array('eq',$_POST['str1']);
            elseif($field=='task')
                $data['t.name'] = array('like',"%".$_POST['str1']."%");
            elseif($field=='weibo')
                $data['b.name'] = array('like',"%".$_POST['str1']."%");
        }
        $data['tb.reject'] =array('eq','0');
        $data['t.begintime']=array('between',array(time()-3600,strtotime(date('Y-m-d',time()).'1day')));
        $dlist = $task->where($data)->order('begintime asc')->select();
        if (!empty($_POST['str2']))
        {
            $field=$_POST['field2'];
            if ($field=='order')
                $data['tb.tblog_id'] = array('eq',$_POST['str2']);
            elseif($field=='task')
                $data['t.name'] = array('like',"%".$_POST['str2']."%");
            elseif($field=='weibo')
                $data['b.name'] = array('like',"%".$_POST['str2']."%");
        }
        if (!empty($_POST['start_time']))
            $data['t.begintime']=array('egt',strtotime($_POST['start_time']));
        if (!empty($_POST['end_time']))
            $data['t.begintime']=array('lt',strtotime($_POST['end_time']));
        $data['t.begintime']=array('egt',strtotime(date('Y-m-d',time()).'1day'));
        $alist = $task->where($data)->order('begintime asc')->select();
        $this->assign('dlist',$dlist);
        $this->assign('alist',$alist);
        $this->assign('getinfo',U('blog/getinfo'));
        $this->assign('hreject',U('blog/hreject'));
        $this->assign('referer',U('blog/referer'));
        $this->display();
    }
    public function getinfo()
    {
        $this->check();
        $task = M('task');
        $data['task_id'] = $_POST['task_id'];
        $info = $task->where($data)->find();
        $info['begintime'] = date('Y年m月d日 H时i分',$info['begintime']);
        if ($info['platform']=='sina')
            $info['platform']='新浪微博';
        elseif ($info['platform']=='qq')
            $info['platform']='腾讯微博';
        if ($info['type']=='forward')
        {
            $info['t']=1;
            $info['type']='转发';
        }elseif($info['type'] == "click"){
            $info['type']='点击';
        }else {
            $info['type']='直发';
        }
        if ($_POST['zurl']==1)
        {
            $d['tblog_id']=$_POST['tb_id'];
            $info['zurl']=M('task_blog')->where($d)->getField('url');
        }
        if ($info)
            $this->ajaxReturn($info,$_POST['tb_id'],1);
        else
            $this->ajaxReturn('',"获取信息失败，请稍后重试",0);
    }
    public function referer()
    {
        $this->check();
        $data['tblog_id'] = $_POST['tblog_id'];
        $tblog = M('task_blog');
        $tb = $tblog->where($data)->field('blog_id,task_id,reject')->find();
        if ($tb['reject']!='0')
            $this->ajaxReturn('','操作错误',0);
        $task = M('task');
        $t['task_id'] = $tb['task_id'];
        $ta = $task->where($t)->field('type,state,begintime')->find();
       	$now=time();
       if ($ta['begintime']>$now)
            $this->ajaxReturn('','活动还未开始',0);
        if ($ta['type']=='publish')
            $type='publish_money';
        else
            $type='money';
        $b['blog_id'] = $tb['blog_id'];
        $b['member_id']=$_SESSION['uid'];
        $blog = M('blog');
        if ($bl = $blog->where($b)->field($type.',fansnum')->find())
        {
            $money = $bl[$type];
            $data['reject']='2';
            $data['url'] = $_POST['url'];
            if ($tblog->save($data))
            {
                $task->setInc('fans_num','task_id='.$tb['task_id'],$bl['fansnum']);
                $task->setInc('consume','task_id='.$tb['task_id'],$money);
                $task->setInc('url_num','task_id='.$tb['task_id']);
                $info['member_id']=$_SESSION['uid'];
                $info['time']=time();
                $info['money']=$money;
                $info['account_money']=$money;
				$info['task_id'] = $t['task_id'];
				$info['blog_id'] = $b['blog_id'];
                $bpayoff = M('blog_payoff');
                $bpayoff->add($info);
                $this->ajaxReturn('',$data['tblog_id'],1);
            }
            else
                $this->ajaxReturn('','操作失败，请稍后重试',0);
        }else
            $this->ajaxReturn('','操作错误',0);
    }
    public function edit_url()
    {
        $this->check();
        $data['tblog_id'] = $_POST['tblog_id'];
        $tblog = M('task_blog');
        $tb = $tblog->where($data)->field('blog_id,task_id,reject')->find();
        if ($tb['reject']!='2')
            $this->ajaxReturn('','操作错误',0);
        $blog['task_id'] = $tb['task_id'];
        $state = M('task')->where($blog)->getField('state');
        if ($state!='2')
            $this->ajaxReturn('','操作错误',0);
        $data['url'] = $_POST['url'];
        if ($tblog->save($data))
            $this->ajaxReturn($data,'',1);
        else
            $this->ajaxReturn('','修改失败，请稍候再试···',0);
    }
    public function rule()
    {
        $this->display();
    }
    public function hreject()
    {
        $this->check();
        $data['tblog_id'] = $_POST['tblog_id'];
        $tblog = M('task_blog');
        $info =  $tblog->where($data)->field('blog_id,task_id,reject')->find();
        if ($info['reject']!='0')
            $this->ajaxReturn('','操作错误',0);
        $b['blog_id'] = $info['blog_id'];
        $b['member_id']=$_SESSION['uid'];
        $blog = M('blog');
        if ($blog->where($b)->find())
        {
            $data['reject']='1';
            $data['comment'] = $_POST['comment'];
            M('task')->setInc('rj_num','task_id='.$info['task_id']);
            if ($tblog->save($data))
                $this->ajaxReturn('',$data['tblog_id'],1);
            else
                $this->ajaxReturn('','操作失败，请稍后重试',0);
        }else
            $this->ajaxReturn('','操作错误',0);
    }
    public function orders()
    {
        $this->check();
        $tblog = D('ataskView');
        if (!empty($_POST['start_time']))
            $data['t.begintime']=array('egt',strtotime($_POST['start_time']));
        if (!empty($_POST['end_time']))
            $data['t.begintime']=array('lt',strtotime($_POST['end_time']));
        if (!empty($_POST['str']))
            $data[$_POST['field']]=array('eq',$_POST['str']);
        $data['b.member_id'] = $_SESSION['uid'];
        $data['t.pay_state'] = 'Y';
        $list = $tblog->where($data)->order('tb.tblog_id desc')->select();
        $this->assign('getinfo',U('blog/getinfo'));
        $this->assign('edit_url',U('blog/edit_url'));
        $this->assign('list',$list);
        $this->display();
    }
    public function weibo()
    {
        $this->check();
        $blog = M('blog');
        $data= array();
        $sort = $_POST['sort']=='default'?'blog_id desc':$_POST['sort'];
        $data['member_id']= $_SESSION['uid'];
        if (!empty($_POST['str']))
            $data['name'] = array('like',"%".$_POST['str']."%");
        if (!empty($_POST['platform']))
            $data['platform'] =$_POST['platform'];
        $info = $blog->where($data)->order($sort)->findAll();
        $this->assign('val',$info);
        $this->assign('weibo_add',U('blog/weibo_add'));
        $this->assign('weibo_edit',U('blog/weibo_edit'));
        $this->assign('weibo_info',U('blog/weibo_info'));
        $this->assign('check_info',U('blog/check_info'));
        $this->assign('save_info',U('blog/save_info'));
        $this->display();
    }
    //ajax提交待审核微薄账号
    public function check_info()
    {
        $this->check();
        $platform = trim($_POST['platform']);
        $nick = trim($_POST['name']);
        $blog = M('blog');
        $bdat['name'] = $nick;
        $bdat['platform'] = $platform;
        if ($blog->where($bdat)->getField('blog_id'))
            $this->ajaxReturn('','此微博已添加',0);
        if ($platform =='sina')
        {
            import('Com.saetv2');
            //保存了appkey，secret, 和access_token
            require_once("./weibo/config.php");
            global $s_access_token;
            $c = new SaeTClientV2( WB_AKEY ,WB_SKEY ,$s_access_token);
            $c->rate_limit_status();
            $a = $c->show_user_by_name($nick);
            if ($a['followers_count']<5000)
                $this->ajaxReturn('','粉丝数不足5000',0);
            $tl = $c->user_timeline_by_name($nick,1,50,0,0,1);
            $s='';
            foreach($tl['statuses'] as  $val)
                $s .=$val.',';
            $s = substr($s,0,-1);
            $zp = $c->get_zp_ids($s);
            $allnum = 0;
            foreach($zp as $val)
                $allnum += $val['comments']+$val['reposts'];
            $pnum = $allnum/count($zp);
            $zp_rate = $pnum/$a['followers_count']*10000;
            $zp_rate = sprintf("%.2f",$zp_rate);

            $blog->create();
            $blog->location = $a['location'];
            $blog->click_money = $_POST['click_money'];
            $blog->com_money = $_POST['money']+sprintf("%.2f",$_POST['money']*C('give_m')/100);
            $blog->com_pmoney = $_POST['publish_money']+sprintf("%.2f",$_POST['publish_money']*C('give_m')/100);
            //平台点击价格
            $blog->com_click = $_POST['click_money']+sprintf("%.2f",$_POST['click_money']*C('give_m')/100);

            $blog->zp_rate = $zp_rate;
            $blog->give_m = C('give_m');
            $blog->sex = $a['gender'];
            $blog->nick = $a['screen_name'];
            $blog->member_id = $_SESSION['uid'];
            $blog->shield='Y';
            $blog->image = $a['profile_image_url'];
            $blog->regtime = time();
            $blog->fansnum = $a['followers_count'];
            if ($a['verified'])
                $blog->verifyinfo = 'Y';
            else
                $blog->verifyinfo = 'N';
            $blog->weibo = 'http://weibo.com/'.$a['idstr'];
            if ($blog->add())
                $this->ajaxReturn('','',1);
            else
                $this->ajaxReturn('','增加微博信息失败！请稍后再试！',0);
        }elseif($platform=='qq'){
            import('Com.Tencent');
            OAuth::init(CLIENT_ID,CLIENT_SECRET);
            Tencent::$debug = false;
            $r = Tencent::api('user/other_info',array('name'=>$nick));
            $aResult = json_decode($r,true);
            if($aResult["ret"]==0){
                if ($aResult['data']['fansnum']<2000)
                    $this->ajaxReturn('','粉丝数不足2000',0);
                $aGetParam = array(
                    "pageflag"=>0,
                    "pagetime"=>0,
                    "reqnum"=>30,
                    "lastid"=>0,
                    "name"=>$nick,
                    "type"=>1,
                    "contenttype"=>1
                );
                $r = Tencent::api('statuses/user_timeline_ids',$aGetParam);
                $ut = json_decode($r,true);
                foreach ($ut['data']['info'] as $val)
                    $ids .=$val['id'].',';
                $ids = substr($ids,0,-1);
                $aGetParam = array(
                    "ids"=>$ids,
                    "flag"=>2
                );
                $r = Tencent::api('t/re_count',$aGetParam);
                $ut = json_decode($r,true);
                $allnum=0;
                foreach($ut['data'] as $val)
                {
                    $allnum += $val['mcount']+$val['count'];
                }
                $pnum = $allnum/count($ut['data']);
                $zp_rate = $pnum/$aResult['data']['fansnum']*10000;
                $zp_rate = sprintf("%.2f",$zp_rate);
                $blog->create();
                $blog->member_id = $_SESSION['uid'];
                $blog->location = $aResult['data']['location'];
                if ($aResult['data']['sex']==1)
                    $sex='m';
                elseif ($aResult['data']['sex']==2)
                    $sex='f';
                else
                    $sex='n';
                $blog->sex = $sex;
                $blog->regtime = time();

                $blog->click_money = $_POST['click_money'];
                //平台点击价格
                $blog->com_click = $_POST['click_money']+sprintf("%.2f",$_POST['click_money']*C('give_m')/100);


                $blog->com_money = $_POST['money']+sprintf("%.2f",$_POST['money']*C('give_m')/100);
                $blog->com_pmoney = $_POST['publish_money']+sprintf("%.2f",$_POST['publish_money']*C('give_m')/100);
                $blog->give_m = C('give_m');
                $blog->zp_rate = $zp_rate;
                $blog->image = $aResult['data']['head'].'/100';
                $blog->nick = $aResult['data']['nick'];
                $blog->shield='Y';
                $blog->fansnum = $aResult['data']['fansnum'];
                if ($aResult['data']['isvip'])
                    $blog->verifyinfo = 'Y';
                else
                    $blog->verifyinfo = 'N';
                $blog->weibo = 'http://t.qq.com/'.$aResult['data']['name'];
                if ($blog->add())
                    $this->ajaxReturn('','',1);
                else
                    $this->ajaxReturn('','增加微博信息失败！请稍后再试！',0);
            }else $this->ajaxReturn('','未找到微博信息！',0);
        }
    }
    public function qq_get($sUrl,$aGetParam){
        $oCurl = curl_init();
        if(stripos($sUrl,"https://")!==FALSE){
            curl_setopt($oCurl,CURLOPT_SSL_VERIFYPEER,FALSE);
            curl_setopt($oCurl,CURLOPT_SSL_VERIFYHOST,FALSE);
        }
        $aGet = array();
        foreach($aGetParam as $key=>$val){
            $aGet[] = $key."=".urlencode($val);
        }
        curl_setopt($oCurl,CURLOPT_URL,$sUrl."?".join("&",$aGet));
        curl_setopt($oCurl,CURLOPT_RETURNTRANSFER,1 );
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if(intval($aStatus["http_code"])==200){
            return $sContent;
        }else{
            return FALSE;
        }
    }
    public function save_info()
    {
        $field = $_POST['field'];
        $data['blog_id'] = $_POST['blog_id'];
        $data[$field] = $_POST['val'];
        if (M('blog')->save($data))
            $this->ajaxReturn('','',1);
        else
            $this->ajaxReturn('','',0);
    }
    public function weibo_add()
    {
        $this->check();
        $this->assign('hweibo_add',U('blog/hweibo_add'));
        $this->display();
    }
    public function hweibo_add()
    {
        $this->check();
        $blog= M('blog');
        $data = array();
        $blog->create();
        $blog->lock = '0';
        $blog->price = $blog->money/($blog->fansnum/10000);
        $blog->member_id = $_SESSION['uid'];
        $blog->lasttime= time();
        $blog->regtime = time();
        if ($blog->add())
        {
            $this->assign('jumpUrl',U('blog/weibo'));
            $this->success('恭喜，数据添加成功！');
        }else{
            $this->error('数据添加失败，稍后重试···');
        }
    }
    public function weibo_edit()
    {
        $this->check();
        $blog = M('blog');
        $data= array();
        $data['member_id']= $_SESSION['uid'];
        $data['blog_id'] = $_GET['blog_id'];
        $info = $blog->where($data)->find();
        $this->assign('info',$info);
        $this->assign('hweibo_edit',U('blog/hweibo_edit'));
        $this->display();
    }
    public function hweibo_edit()
    {
        $this->check();
        $blog= M('blog');
        $data = array();
        $data['member_id'] = $_SESSION['uid'];
        $data['blog_id'] = $_GET['blog_id'];
        $blog->create();
        $blog->price = $blog->money/($blog->fansnum/10000);
        $blog->lock = '0';
        $blog->lasttime= time();
        if ($blog->where($data)->save())
        {
            $this->success('恭喜，数据更新成功！');
        }else{
            $this->error('数据更新失败，没有修改数据/稍后重试···');
        }
    }
    public function weibo_info()
    {
        $this->check();
        $blog = M('blog');
        $data = array();
        $data['member_id'] = $_SESSION['uid'];
        $data['blog_id'] = $_GET['blog_id'];
        $info = $blog->where($data)->find();
        $this->assign('info',$info);
        $this->assign('weibo',U('blog/weibo'));
        $this->display();
    }
    public function auction()
    {
        $this->check();
        $this->display();
    }
    public function bill_payoff()
    {
        $this->check();
        if (!empty($_POST['date']))
            $data['time']=array('between',array(strtotime($_POST['date']),strtotime($_POST['date']."1day")));
        $bpayoff = M('blog_payoff');
        $data['member_id'] = $_SESSION['uid'];
        $list = $bpayoff->where($data)->select();
        $this->assign('list',$list);
        $this->display();
    }
    public function bill_payout()
    {
        $this->check();
        $bpayoff = M('blog_payoff');
        if (!empty($_POST['start_time']))
            $data['pay_time']=array('egt',strtotime($_POST['start_time']));
        if (!empty($_POST['end_time']))
            $data['pay_time']=array('lt',strtotime($_POST['end_time']));
        $data['member_id'] = $_SESSION['uid'];
        $data['state']=1;
        $list = $bpayoff->where($data)->select();
        $this->assign('list',$list);
        $this->display();
    }
    public function account_info()
    {
        $this->check();
        $mem = M('blog_member');
        $data['member_id'] = $_SESSION['uid'];
        $info = $mem->where($data)->find();
        $this->assign('info',$info);
        $this->assign('edit_account_info',U('blog/edit_account_info'));
        $this->display();
    }
    public function edit_account_info()
    {
        $this->check();
        $mem = M('blog_member');
        $mem->create();
        $mem->member_id = $_SESSION['uid'];
        if ($mem->save())
            $this->ajaxReturn('',"更新成功",1);
        else
            $this->ajaxReturn('','更新失败,请稍后再试',0);
    }
    public function account_pass()
    {
        $this->check();
        $this->assign('edit_pass',U('blog/edit_pass'));
        $this->display();
    }
    public function edit_pass()
    {
        $this->check();
        $mem = M('blog_member');
        $data['password'] = md5($_POST['oldpassword']);
        $data['member_id'] = $_SESSION['uid'];
        if ($mem->where($data)->find())
        {
            $data = array();
            $data['member_id'] = $_SESSION['uid'];
            $data['password'] = md5($_POST['password']);
            if ($mem->save($data))
                $this->success('恭喜，密码更改成功！');
        }else{
            $this->error('旧密码错误！');
        }
    }
    public function account_rebate()
    {
        $this->check();
        $this->display();
    }
}

?>