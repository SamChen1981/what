<?php

class companyAction extends Action
{
    public function check($on=0)
    {
        if ($on)
            $this->assign('on',$on);
        if ($_SESSION['cid']<=0)
            $this->redirect('company/login','',0,'请先登录');
    }
    public function index()
    {
        $this->display();
    }
    public function pay_red()
    {
        $this->check(3);
        if ($this->isPost())
        {
            if (md5($_POST['verify'])!=$_SESSION['verify'])
                $this->error('验证码错误');
            $data['card'] = $_POST['card'];
            $data['state']=3;
            $cash = M('cash');
            if (!$money =$cash->where($data)->getField('money'))
                $this->error('红包ID错误！');
            $dat['state']=1;
            $cash->where($data)->save($dat);
            M('company_member')->setInc('money','member_id='.$_SESSION['cid'],$money);
            $this->success('恭喜！充值成功！');
        }
        $this->assign('verify',U('blog/verify'));
        $this->display();
    }
    public function register()
    {
        $this->assign('login',U('company/login'));
        $this->assign('verify',U('blog/verify'));
        $this->assign('checkUsername',U('company/checkUsername'));
        $this->assign('checkVerify',U('blog/checkVerify'));
        $this->assign('hregister',U('company/hregister'));
        $this->display();
    }
    public function hregister()
    {
        $mem = M('company_member');
        $data['username'] = $_POST['username'];
        if ($mem->where($data)->find())
            $this->ajaxReturn(U('company/register'),"用户名已存在",0);
        $mem->create();
        $mem->password = md5($_POST['password']);
        $mem->reg_ip = $this->getIp();
        $mem->regtime = time();
        $mem->lasttime = time();
        $mem->login_count = 1;
        $id = $mem->add();
        if (!$id)
            $this->ajaxReturn(U('company/register'),'注册失败,请稍后再试···',0);
        if ($info = is_send(15))
        {
            $array=array('username'=>$_POST['username']);
            $content = $this->get_draw_theme($info['content'],$array);
            $err =send_email($_POST['email'],$info['name'],$content,$_POST['username']);
        }
        if ($info = is_send(14))
        {
            $array=array('username'=>$_POST['username']);
            $content = $this->get_draw_theme($info['content'],$array);
            $err = send_sms($_POST['phone'],$content);
        }
        $this->ajaxReturn('','恭喜信息提交成功！等待审核···',1);
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
        $mem = M('company_member');
        if ($mem->where($data)->find())
            $this->ajaxReturn('','用户名已存在',0);
        else
            $this->ajaxReturn('','',1);
    }
    public function login()
    {
        if ($_SESSION['cid']>0)
            $this->redirect('company/myindex');
        $this->assign('register',U('company/register'));
        $this->assign('hlogin',U('company/hlogin'));
        $this->assign('verify',U('blog/verify'));
        $this->display();
    }
    public function hlogin()
    {
        if (md5($_POST['verify'])!=$_SESSION['verify'])
            $this->ajaxReturn('','验证码错误',0);
        $data['password'] = md5($_POST['password']);
        $data['username'] = $_POST['username'];
        $mem = M('company_member');
        $info = $mem->where($data)->find();
        if ($info['wedlock']==0)
            $this->ajaxReturn('','待审核或者用户名密码错误',0);
        elseif($info['wedlock']==2)
            $this->ajaxReturn('','被驳回，未通过',0);
        if ($info)
        {
            $_SESSION['cid'] = $info['member_id'];
            $_SESSION['contact'] =$info['contact'];
            $_SESSION['username']=$data['username'];
            $_SESSION['lasttime'] = $info['lasttime'];
            $_SESSION['lastip'] = $info['lastip'];
            $data=array();
            $data['lasttime']= time();
            $data['login_count'] = $info['login_count']+1;
            $data['member_id'] = $info['member_id'];
            $data['lastip'] = $this->getIp();
            $mem->save($data);
            $this->ajaxReturn('',U('company/myindex'),1);
        }
        else
            $this->ajaxReturn('','用户名或密码错误',0);
    }
    public function logout()
    {
        session_unset();
        $this->assign('jumpUrl',U('company/login'));
        $this->success('恭喜，您已安全退出');
    }
    public function myindex()
    {
        $this->check();
        $data['member_id'] = $_SESSION['cid'];
        $task = M('task');
        $list = $task->where($data)->limit(9)->order('task_id desc')->select();
        $mem = M('company_member');
        $u['member_id'] = $_SESSION['cid'];
        $uinfo = $mem->where($u)->find();
        $article = M('article');
        $data=array();
        $data['type']=2;
        $alist =$article->field('article_id,name')->where($data)->order('article_id desc')->limit(9)->select();
        $data['type']=5;
        $a2list =$article->field('article_id,name')->where($data)->order('article_id desc')->limit(5)->select();
        $this->assign('a2list',$a2list);
        $this->assign('list',$list);
        $this->assign('help',U('index/help'));
        $this->assign('register',U('index/register'));
        $this->assign('uinfo',$uinfo);
        $this->assign('alist',$alist);
        $this->assign('task_edit',U('company/task_edit'));
        $this->assign('task_choose',U('company/task_choose'));
        $this->assign('task_info',U('company/task_info'));
        $this->assign('task_del',U('company/task_del'));
        $this->assign('task',U('company/task'));
        $this->display();
    }
    public function task()
    {
        $this->check(1);
        $task= D('taskView');
        $data['t.member_id'] = $_SESSION['cid'];
        if (!empty($_POST['start_time']))
            $data['t.begintime'] = array('egt',strtotime($_POST['start_time']));
        if (!empty($_POST['end_time']))
            $data['t.begintime'] = array('lt',strtotime($_POST['end_time']));
        if (!empty($_POST['keyword']))
            $data['t.name'] = array('like','%'.$_POST['keyword'].'%');
        if (!empty($_POST['sort']))
        {
            $sort = $_POST['sort'];
            if ($sort=='costup')
                $task->order('t.consume asc');
            elseif($sort=='costdown')
                $task->order('t.consume desc');
            elseif($sort=='timeup')
                $task->order('t.begintime asc');
            elseif($sort=='timedown')
                $task->order('t.begintime desc');
        }
        $list = $task->where($data)->order('t.task_id desc')->group('tb.task_id')->select();
        foreach($list as $key =>$val)
        {
            $list[$key]['ctrim']= $this->msubstr($val['content'],0,10);
        }
        $this->assign('list',$list);
        $this->assign('task_edit',U('company/task_edit'));
        $this->assign('task_choose',U('company/task_choose'));
        $this->assign('task_info',U('company/task_info'));
        $this->assign('task_del',U('company/task_del'));
        $this->assign('task_pay',U('company/task_pay'));
        $this->assign('task',U('company/task'));
        $this->display();
    }
  public function task_add()
    {
        $this->check();
        if ($this->isPost())
        {
            $task = M('task');
            if ($_POST['type']=='publish')
            {
                unset($_POST['url']);
                if (!empty($_FILES['photo']['type']))
                {
                    if ($url = $this->upload(1))
                        $_POST['image'] = $url;
                }
            }
            $task->create();
            $task->member_id = $_SESSION['cid'];
            $task->begintime = strtotime($task->begintime);
            if ($id = $task->add())
                $this->redirect('company/task_show?task_id='.$id);
            else
                $this->error('增加失败，请稍后重试');
        }
        $this->assign('htask_add',U('company/htask_add'));
        $this->display();
    }
    public function task_del()
    {
        $this->check();
        $data['member_id'] = $_SESSION['cid'];
        $data['task_id'] = $_GET['task_id'];
        $task = M('task');
        $pay_state=$task->where($data)->getField('pay_state');
        if ($pay_state=='Y')
            $this->error('支付活动，无法删除！');
        if ($task->where($data)->delete())
        {
            $tblog = M('task_blog');
            if ($tblog->where($data)->delete())
                $this->success('恭喜，删除成功！');
            else
                $this->error('删除失败,部分数据未删除');
        }
        else
            $this->error('删除失败！');
    }
    public function task_edit()
    {
        $this->check();
        $data['task_id'] = $_GET['task_id'];
        $data['member_id']= $_SESSION['cid'];
        $task = M('task');
        $pay_state=$task->where($data)->getField('pay_state');
        if ($pay_state=='Y')
            $this->error('已支付活动，无法编辑！');
        if ($this->isPost())
        {
            if ($_POST['type']=='publish')
            {
                unset($_POST['url']);
                if (!empty($_FILES['photo']['type']))
                {
                    if ($url = $this->upload(1))
                        $_POST['image'] = $url;
                }
            }
            $task->create();
            $task->begintime = strtotime($task->begintime);
            if ($task->where($data)->save())
                $this->redirect('company/task_show?task_id='.$data['task_id']);
            else
                $this->error('','修改失败，请稍后重试',0);
        }
        $info = $task->where($data)->find();
        $ctime = $info['begintime']-time();
        $info['beginm'] = intval($ctime/60);
        $this->assign('info',$info);
        $this->assign('htask_edit',U('company/htask_edit?task_id='.$data['task_id']));
        $this->display();
    }
    public function task_show()
    {
        $this->check();
        $data['task_id'] = $_GET['task_id'];
        $data['member_id'] = $_SESSION['cid'];
        $task = M('task');
        $info = $task->where($data)->find();
        $ctime = $info['begintime']-time();
        $info['beginm'] = intval($ctime/60);
        $this->assign('info',$info);
        $this->assign('task_edit',U('company/task_edit?task_id='.$data['task_id']));
        $this->assign('task',U('company/task'));
        $this->assign('task_choose',U('company/task_choose?task_id='.$data['task_id']));
        $this->display();
    }
    public function task_choose()
    {
        $this->check();
        $hide['task_id'] = $_GET['task_id'];
        $hide['member_id']=$_SESSION['cid'];
        if (empty($hide['task_id']))
            $this->redirect('company/task','',0,'先选择活动');
        else{
            $task = M('task');
            $info = $task->where($hide)->find();
        }
        if (!$info)
            $this->error('未找到相关活动！');
        if ($info['pay_state']=='Y')
            $this->error('已支付活动，无法编辑！');
        if ($info['begintime']<time() ||$info['begintime']>strtotime(date('Y-m-d H:i:s',time()).'7day'))
        {
            $this->assign('jumpUrl',U('company/task_edit?task_id='.$info['task_id']));
            $this->error('活动开始时间不正确');
        }
        $this->assign('info',$info);
        $_GET['platform']=$info['platform'];
        $_GET['type'] = $info['type'];
        if ($info['soft']=='Y')
            $_GET['soft'] = $info['soft'];
        $hide['act']= $act = isset($_GET['act']) ?$_GET['act'] : 'other';
        $hide['sort'] = $sort= isset($_GET['sort']) ?$_GET['sort'] :'fansnum';
        $hide['direction'] = $direction = isset($_GET['direction']) ?$_GET['direction'] :'desc';
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        $si = $this->pselinfo($hide);
        $blog = D('blogView');
        if ($act == 'other')
        {
            $data=$si;
            $cls = empty($_GET['cls']) ?'all': $_GET['cls'];
            if ($cls=='red')
                $data['b.class'] =2;
            elseif($cls=='grass')
                $data['b.class'] =1;
            elseif($cls=='media')
                $data['b.class'] =3;
            elseif($cls=='small')
                $data['b.class'] =4;
            $data['b.lock']='1';
            $data['bb.member_id']=array(array('neq',$_SESSION['cid']),array('exp','is NULL'),'or');
            $list = $blog->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count      = $blog->where($data)->count();
            $this->assign('cls',$cls);
            $theme='';
        }elseif($act== 'hots'){
            $data=$si;
            $data['lock']=array('eq','1');
            $data['hots']=array('gt','1');
            $data['bb.member_id']=array(array('neq',$_SESSION['cid']),array('exp','is NULL'),'or');
            $list = $blog->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count      = $blog->where($data)->count();
            $theme='task_hots';
        }elseif($act == 'fav'){
            $data=$si;
            $this->assign('blog_del_fav',U('company/blog_del_fav'));
            $blogf = D('favblogView');
            $data['bf.member_id'] = $_SESSION['cid'];
            $list = $blogf->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count = $blogf->where($data)->count();
            $theme='task_fav';
        }elseif($act == 'history'){
            $data=$si;
            $blogf = D('hblogView');
            $data['tb.member_id'] = $_SESSION['cid'];
            $data['bb.member_id']=array(array('neq',$_SESSION['cid']),array('exp','is NULL'),'or');
            $list = $blogf->where($data)->order($sort.' '.$direction)->group('tb.blog_id')->page($p.',20')->select();
            $count = $blogf->where($data)->count();
            $theme='task_history';
        }
        $this->assign('list',$list);
        import("ORG.Util.Page");
        $Page       = new Page($count,20);
        $show       = $Page->show();
        $cs = S('class');
        if (!$cs)
        {
            $cs ='';
            $cla = M('class')->field('name,label')->findAll();
            foreach ($cla as $val)
                $cs .='<option value="'.$val['label'].'">'.$val['name'].'</option>';
            S('class',$cs,3600);
        }
        $this->assign('cs',$cs);
        $url = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        $this->assign('url',$url);
        $this->assign('hide',$hide);
        $this->assign('task_add_blog',U('company/task_add_blog'));
        $this->assign('task_del_blog',U('company/task_del_blog'));
        $this->assign('task_view_blog',U('company/task_view_blog'));
        $this->assign('blog_add_block',U('company/blog_add_block'));
        $this->assign('blog_add_fav',U('company/blog_add_fav'));
        $this->assign('task_pay',U('company/task_pay'));
        $this->assign('select',U('company/task_choose'));
        $this->assign('page',$show);
        $this->display($theme);
    }
    public function task_add_blog()
    {
        $this->check();
        $tblog = M('task_blog');
        $blog = M('blog');
        $data['task_id'] = $_POST['task_id'];
        $data['blog_id'] = $_POST['blog_id'];
        $data['member_id'] = $_SESSION['cid'];
        $blog_id = explode(',',$data['blog_id']);
        if (count($blog_id)==1)
        {
            if ($tblog->where($data)->find())
            {
                $this->ajaxReturn('','',1);
            }
        }
        $i=0;
        foreach($blog_id as $val)
        {
            $data['blog_id'] = $val;
            $bd['blog_id'] = $val;
            $bi = $blog->where($bd)->getField('reject');
            if ($bi!='Y')
            {
                if (!$tblog->where($data)->find())
                {
                    $blog->setInc('week_order','blog_id='.$val);
                    $blog->setInc('month_order','blog_id='.$val);
                    $all[$i]['task_id'] =  $data['task_id'];
                    $all[$i]['blog_id'] = $val;
                    $all[$i]['member_id'] = $_SESSION['cid'];
                    $i++;
                }
            }else $msg++;
        }
        if ($tblog->addAll($all))
        {
            if (!empty($msg))
                $this->ajaxReturn('','部分微博主未添加成功！原因：暂时不接受订单',2);
            else
                $this->ajaxReturn('','',1);
        }
        else{
            if (!empty($msg))
                $this->ajaxReturn('','部分微博主未添加成功！原因：暂时不接受订单',2);
            else
                $this->ajaxReturn('','',1);
        }
    }
    public function task_del_blog()
    {
        $tblog = M('task_blog');
        $blog = M('blog');
        $task_id = $_POST['task_id'];
        $blog_id = $_POST['blog_id'];
        $dat['task_id'] = $task_id;
        $info = M('task')->where($dat)->find();
        $data['member_id'] = $info['member_id'];
        $data['task_id'] = $task_id;
        $data['blog_id'] = $blog_id;
		 $tiao['member_id'] = $info['member_id'];
        $tiao['task_id'] = $task_id;
        $tiao['blog_id'] = $_POST['blog_id'];
		$shan['task_id'] = $task_id;
        $shan['blog_id'] = $blog_id;
		$tiaojian = M('task_blog')->where($tiao)->find();
		 if ($tiaojian['reject']!='2')
            $this->ajaxReturn('','未完成链接的无法删除',0);
        if ($tblog->where($data)->delete())
        {
		 $bpayoff = M('blog_payoff');
		 $qian = $bpayoff->where($shan)->field('pingtai_money')->find(); //取得返回的钱数
		 $task = M('task');
		 $task->setDec('consume','task_id='.$dat['task_id'],$qian['pingtai_money']); //删除 活动支出的这个微博主的钱数
		 $bpayoff->where($shan)->delete();//删除后台打款管理的钱数 和 微博主收入明细的钱数
         $this->ajaxReturn('','删除成功,刷新该网页即可',0);
        }
       else
            $this->ajaxReturn('','已删除或没有该微博，请稍后重试',0);
    }
    public function task_view_blog()
    {
        $this->check();
        $data['task_id'] = $_POST['task_id'];
        $tblog = M();
        $list = $tblog->query('SELECT b.blog_id,b.name,b.fansnum,b.com_money,b.com_pmoney,b.com_click,b.weibo FROM '
            .C('DB_PREFIX').'task_blog AS tb, '
            .C('DB_PREFIX').'blog AS b WHERE tb.blog_id=b.blog_id AND tb.task_id='.$data['task_id']);
        if ($_POST['type'] =='publish')
            $type = 'com_pmoney';
        else
            $type = 'com_money';
        foreach($list as $val)
        {
            $money += $val[$type];
        }
        if ($list)
            $this->ajaxReturn($list,$money,1);
        else
            $this->ajaxReturn('false','您还没有选择微博主哦',0);
    }
    //活动支付
    public function task_pay()
    {
        $this->check();
        $data['task_id']=$_GET['task_id'];
        $data['member_id']=$w['member_id'] =  $_SESSION['cid'];
        $task =M('task');
        $tp=$task->where($data)->find();
        $pay_state= $tp['pay_state'];
        if (!$pay_state)
            $this->error('未找到活动！');
        if ($pay_state=='Y')
            $this->error('支付失败，活动已支付！');
        $tblog = M();
        if ($tp['type']=='publish')
            $type = 'b.com_pmoney';
        else
            $type = 'b.com_money';
        $list = $tblog->query($sql = 'SELECT '.$type.' as money FROM '
            .C('DB_PREFIX').'task_blog AS tb, '
            .C('DB_PREFIX').'blog AS b WHERE tb.blog_id=b.blog_id AND tb.task_id='.$data['task_id']);
        $tp['money']=0;
        foreach($list as $val)
        {
            $tp['money'] += $val['money'];
        }
        $cmember = M('company_member');
        $money = $cmember->where($w)->getField('money');
        if ($tp['money'] >$money)
        {
            $money=$tp['money']-$money;
            $this->assign('jumpUrl',U('company/bill_recharge?money='.$money));
            $this->error('您的账户余额不足，还差'.$money.'元，请先充值后再支付本次活动！');
        }
        $save['money'] = $money-$tp['money'];
        if (!$cmember->where($w)->save($save))
            $this->error('支付失败,系统故障');
        $save=array();
        $save['pay_state']='Y';
        $save['state']='1';
        $save['money'] = $tp['money'];
        $save['yp_num'] = count($list);
        if ($task->where($data)->save($save))
        {
            $dati['task_id']=$_GET['task_id'];
            $da['reject']='0';
            M('task_blog')->where($dati)->save($da);
            $task_cron = array(
                array('type'=>0,'time'=>$tp['begintime']-600,'task_id'=>$_GET['task_id']),
                array('type'=>1,'time'=>$tp['begintime'],'task_id'=>$_GET['task_id']),
                array('type'=>2,'time'=>$tp['begintime']+3600,'task_id'=>$_GET['task_id'])
            );
            M('task_cron')->addAll($task_cron);
            $payoff = M('task_payoff');
            $data['member_id']=$_SESSION['cid'];
            $data['time'] = time();
            $data['money'] = $tp['money'];
            if ($payoff->add($data))
            {
                if ($info = is_send(23))
                {
                    $d['tb.task_id'] = $_GET['task_id'];
                    $tbm = D('taskbmView');
                    $list = $tbm->where($d)->group('bm.member_id')->select();
                    foreach($list as $val)
                    {
                        $array=array('money'=>$tp['money']);
                        $content = $this->get_draw_theme($info['content'],$array);
                        $err =send_email($val['email'],$info['name'],$content,'微博主');
                    }
                }
                if ($info = is_send(9))
                {
                    $c['member_id'] = $_SESSION['cid'];
                    $email = M('company_member')->where($c)->getField('email');
                    $ta['task_id'] = $_GET['task_id'];
                    $tinfo = M('task')->where($ta)->field('name,money')->find();
                    $array=array('name'=>$tinfo['name'],'money'=>$tinfo['money'],'username'=>$_SESSION['username']);
                    $content = $this->get_draw_theme($info['content'],$array);
                    $err =send_email($email,$info['name'],$content,$_SESSION['username']);
                    $es = 1;
                }
                if ($info = is_send(8))
                {
                    if ($es!=1 )
                    {
                        $ta['task_id'] = $_GET['task_id'];
                        $tinfo = M('task')->where($ta)->field('name,money')->find();
                    }
                    $phone = M('company_member')->where($c)->getField('phone');
                    $array=array('name'=>$tinfo['name'],'money'=>$tinfo['money'],'username'=>$_SESSION['username']);
                    $content = $this->get_draw_theme($info['content'],$array);
                    $err = send_sms($phone,$content);
                }
                $this->assign('jumpUrl',U('company/task_info?task_id='.$_GET['task_id']));
                $this->success('恭喜，支付成功');
            }
            else
                $this->error('系统错误，支付记录未写入！');
        }
        else
            $this->error('抱歉，支付失败，系统故障！');
    }
    public function task_info()
    {
        $this->check();
        $data['task_id'] = $_GET['task_id'];
        $data['member_id'] = $_SESSION['cid'];
        $name = $_GET['name'];
        $task = M('task');
        if (!$info = $task->where($data)->find())
            $this->error('抱歉，未找活动信息！');
        $this->assign('info',$info);
        $tblog = D('taskfbView');
        $dat['tb.task_id'] = $_GET['task_id'];
        $list = $tblog->where($dat)->select();
        if ($info['type']=='publish')
            $type = 'com_pmoney';
        else
            $type = 'com_money';
        foreach($list as $val)
        {
            $money += $val[$type];
        }
        $this->assign('list',$list);
        $this->assign('tnum',count($list));
        $this->assign('task_id',$data['task_id']);
        $this->assign('money',$money);
        $this->assign('task_choose',U('company/task_choose'));
        $this->assign('task_edit',U('company/task_edit'));
        $this->assign('task_pay',U('company/task_pay'));
        $this->assign('task_del_blog',U('company/task_del_blog'));
        $this->assign('task_del',U('company/task_del'));
        $this->assign('task_info',U('company/task_info'));
        $this->display();
    }
    public function dinner()
    {
        $this->check(6);
        $data['member_id'] = $_SESSION['cid'];
        $dinner = M();
        $where='';
        if (!empty($_POST['start_time']))
            $where .= ' AND cd.addtime>='.strtotime($_POST['start_time']);
        if (!empty($_POST['end_time']))
            $where .= ' AND cd.addtime<'.strtotime($_POST['end_time']);
        if (!empty($_POST['keyword']))
            $where .= ' AND cd.name like "%'.$_POST['keyword'].'%"';
        $list = $dinner->query('SELECT cd.cdinner_id,d.name as type,d.money,cd.name,cd.begintime,cd.addtime,cd.pay_state  FROM '
            .C('DB_PREFIX').'company_dinner AS cd, '
            .C('DB_PREFIX').'dinner AS d WHERE cd.dinner_id=d.dinner_id AND cd.member_id='.$data['member_id'].$where);
        $this->assign('list',$list);
        $this->assign('dinner_edit',U('company/dinner_edit'));
        $this->assign('dinner_add',U('company/dinner_add'));
        $this->assign('dinner_del',U('company/dinner_del'));
        $this->assign('dinner_info',U('company/dinner_info'));
        $this->assign('dinner_pay',U('company/dinner_pay'));
        $this->assign('dinner',U('company/dinner'));
        $this->display();
    }
    public function dinner_add()
    {
        $this->check();
        $dinner = M('dinner');
        $list = $dinner->select();
        $this->assign('list',$list);
        foreach($list as $key =>$val)
        {
            $code->$val['dinner_id'] = $val;
        }
        $code = json_encode($code);
        $this->assign('code',$code);
        $this->assign('list',$list);
        $this->assign('hdinner_add',U('company/hdinner_add'));
        $this->assign('upload',U('company/upload'));
        $this->display();
    }
    public function hdinner_add()
    {
        $this->check();
        $cdinner = M('company_dinner');
        $cdinner->create();
        $cdinner->member_id=$_SESSION['cid'];
        $cdinner->begintime= strtotime($cdinner->begintime);
        $this->assign('jumpUrl',U('company/dinner'));
        if ($cdinner->add())
            $this->success('增加成功');
        else
            $this->error('增加失败，请稍后重试···');
    }
    public function dinner_edit()
    {
        $this->check();
        $dinner = M('dinner');
        $list = $dinner->select();
        $this->assign('list',$list);
        foreach($list as $key =>$val)
        {
            $code->$val['dinner_id'] = $val;
        }
        $code = json_encode($code);
        $this->assign('code',$code);
        $this->assign('list',$list);
        $data['member_id']=$_SESSION['cid'];
        $data['cdinner_id'] = $_GET['cdinner_id'];
        $dinner = D('dinnercView');
        $info = $dinner->where($data)->find();
        if ($info['pay_state']=='Y')
            $this->error('已支付套餐，无法修改！');
        $this->assign('info',$info);
        $this->assign('upload',U('company/upload'));
        $this->assign('hdinner_edit',U('company/hdinner_edit'));
        $this->display();
    }
    public function hdinner_edit()
    {
        $this->check();
        $cdinner = M('company_dinner');
        $cdinner->create();
        $cdinner->begintime= strtotime($cdinner->begintime);
        $data['member_id']=$_SESSION['cid'];
        $data['cdinner_id']=$_GET['cdinner_id'];
        if ($cdinner->where($data)->save())
        {
            $this->assign('jumpUrl',U('company/dinner_edit?cdinner_id='.$_GET['cdinner_id']));
            $this->success('恭喜，套餐信息修改成功！');
        }
        else
            $this->error('套餐信息修改失败，请稍后重试');
    }
    public function dinner_info()
    {
        $this->check();
        $member_id=$_SESSION['cid'];
        $cdinner_id = $_GET['cdinner_id'];
        $dinner = M();
        $info = $dinner->query('SELECT cd.cdinner_id,d.name as type,cd.content,d.content as remark,d.money,cd.name,cd.begintime,cd.addtime,cd.pay_state,cd.s_time,cd.operator,cd.url,cd.state  FROM '
            .C('DB_PREFIX').'company_dinner AS cd, '
            .C('DB_PREFIX').'dinner AS d WHERE cd.dinner_id=d.dinner_id AND cd.member_id='.$member_id.' AND cd.cdinner_id='.$cdinner_id);
        $this->assign('info',$info[0]);
        $this->assign('dinner_pay',U('company/dinner_pay'));
        $this->assign('dinner_edit',U('company/dinner_edit'));
        $this->display();
    }
    public function dinner_pay()
    {
        $this->check();
        $data['cdinner_id']=$_GET['cdinner_id'];
        $data['member_id']=$w['member_id'] =  $_SESSION['cid'];
        $cdinner =M('company_dinner');
        if (!$info = $cdinner->where($data)->find())
            $this->error('未找到套餐');
        $d['dinner_id']=$info['dinner_id'];
        $dinner = M('dinner');
        if (!$info['money']=$dinner->where($d)->getField('money'))
            $this->error('抱歉，套餐已过期！');
        $cmember = M('company_member');
        $money = $cmember->where($w)->getField('money');
        if ($info['pay_state']=='Y')
            $this->error('支付失败，套餐已支付！');
        if ($info['money'] >$money)
        {
            $money=$info['money']-$money;
            $this->assign('jumpUrl',U('company/bill_recharge?money='.$money));
            $this->error('您的账户余额不足，还差'.$money.'元，请先充值后再支付本次套餐！');
        }
        $save['money'] = $money-$info['money'];
        if (!$cmember->where($w)->save($save))
            $this->error('支付失败,系统故障');
        $save=array();
        $save['pay_state']='Y';
        $save['state']=1;
        if ($cdinner->where($data)->save($save))
        {
            $payoff = M('task_payoff');
            $data['member_id']=$_SESSION['cid'];
            $data['time'] = time();
            $data['money'] = $info['money'];
            if ($payoff->add($data))
                $this->success('恭喜，支付成功');
            else
                $this->error('系统错误，支付记录未写入！');
        }
        else
            $this->error('抱歉，支付失败，系统故障！');
    }
    public function dinner_del()
    {
        $this->check();
        $data['cdinner_id'] = $_GET['cdinner_id'];
        $data['member_id'] = $_SESSION['cid'];
        $cdinner = M('company_dinner');
        $info = $cdinner->where($data)->getField('pay_state');
        if ($info=='Y')
            $this->error('删除失败，已支付套餐无法删除！');
        if ($cdinner->where($data)->delete())
        {
            $this->assign('jumpUrl',U('company/dinner'));
            $this->success('恭喜，套餐删除成功');
        }
        else
            $this->error('删除失败，请稍后再试！');
    }
    public function upload($type=0)
    {
        import("ORG.Net.UploadFile");
        $upload = new UploadFile();
        $upload->maxSize  = 3145728 ;
        $upload->allowExts  = array('jpg','gif','png','jpeg');
        $upload->savePath =  'uploads/images/';
        $upload->saveRule    = 'uniqid';
        if(!$upload->upload()) {
            if ($type)
                return false;
            else
                echo 'error';
        }else{
            $info =  $upload->getUploadFileInfo();
            $url=$info[0]['savepath'].$info[0]['savename'];
            if ($type){
                return $url;
            }else{
                $msg="{'err':'','msg':{'url':'".$url."'}}";
                echo $msg;
            }
        }
    }
    public function account_info()
    {
        $this->check(4);
        $mem = M('company_member');
        $data['member_id'] = $_SESSION['cid'];
        $info = $mem->where($data)->find();
        $this->assign('info',$info);
        $this->assign('haccount_info',U('company/haccount_info'));
        $this->display();
    }
    public function haccount_info()
    {
        $this->check();
        $mem = M('company_member');
        $mem->create();
        $mem->member_id = $_SESSION['cid'];
        if ($mem->save())
            $this->ajaxReturn('','更新成功',1);
        else
            $this->ajaxReturn('','更新失败',0);
    }
    public function account_pass()
    {
        $this->check(4);
        $this->assign('haccount_pass',U('company/haccount_pass'));
        $this->display();
    }
    public function haccount_pass()
    {
        $this->check();
        $mem = M('company_member');
        $data['member_id'] = $_SESSION['cid'];
        $data['password'] = md5($_POST['oldpassword']);
        if ($mem->where($data)->find())
        {
            $data['password'] = md5($_POST['password']);
            if ($mem->save($data))
                $this->success('恭喜！密码修改成功');
            else
                $this->error('修改失败，请稍后重试');
        }else
            $this->error('修改失败，原始密码不正确');
    }
    public function pselinfo($h)
    {
        $act=$h['act'];
        $sort=$h['sort'];
        $direction=$h['direction'];
        $s=array(
            'fansnum'=>'desc',
            'money'=>'desc',
            'price'=>'desc',
            'zp_rate'=>'desc',
            'com_money'=>'desc',
            'com_pmoney'=>'desc',
            'month_order'=>'desc',
            'week_order'=>'desc'
        );
        $class=array(
            'fansnum'=>'all',
            'com_money'=>'all',
            'com_pmoney'=>'all',
            'zp_rate'=>'all',
            'com_money'=>'all',
            'com_pmoney'=>'all',
            'month_order'=>'all',
            'week_order'=>'all'
        );
        foreach ($s as $key=>$val)
        {
            if ($key==$sort)
            {
                if ($direction=='desc')
                    $s[$key]='asc';
                $class[$key]=$direction;
            }
        }
        $this->assign('s',$s);
        $this->assign('class',$class);
        $keyword=trim($_GET['keywords']);
        if (!empty($keyword))
        {
            $keyword=explode(" ",$keyword);
            if (count($keyword)>1)
            {
                foreach($keyword as $val)
                    $data['b.keywords'][]=array('like','%'.$val.'%');
                $data['b.keywords'][]='or';
            }else $data['b.keywords'] = array('like','%'.$keyword[0].'%');
        }
        if (!empty($_GET['reject']))
            $data['reject'] = $_GET['reject'];
        if (!empty($_GET['soft']))
            $data['soft'] = $_GET['soft'];
        if (!empty($_GET['type']) &&$_GET['type']=='publish')
            $data['shield'] = 'Y';
        if (!empty($_GET['money1']))
            $data['money'][0]=array('egt',$_GET['money1']);
        if (!empty($_GET['money2']))
            $data['money'][1]=array('lt',$_GET['money2']);
        if (!empty($_GET['fans1']))
            $data['fansnum'][0]=array('egt',$_GET['fans1']);
        if (!empty($_GET['fans2']))
            $data['fansnum'][1]=array('lt',$_GET['fans2']);
        if (!empty($_GET['wname']))
            $data['name']=array('like','%'.$_GET['wname'].'%');
        if (!empty($_GET['name']) &&!isset($h['task_id']))
            $data['name']=array('like','%'.$_GET['name'].'%');
        if (!empty($_GET['platform']) &&$_GET['platform']!='all')
            $data['platform']=array('eq',$_GET['platform']);
        if (!empty($_GET['verify']) &&$_GET['verify']!='all')
            $data['verifyinfo']=array('eq',$_GET['verify']);
        return $data;
    }
    public function bloger()
    {
        $this->check(2);
        $hide['act']= $act = isset($_GET['act']) ?$_GET['act'] : 'other';
        $hide['sort'] = $sort= isset($_GET['sort']) ?$_GET['sort'] :'fansnum';
        $hide['direction'] = $direction = isset($_GET['direction']) ?$_GET['direction'] :'desc';
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        $si=$this->pselinfo($hide);
        $blog = D('blogView');
        if ($act == 'other')
        {
            $data=$si;
            $cls = empty($_GET['cls']) ?'all': $_GET['cls'];
            if ($cls=='red')
                $data['b.class'] =2;
            elseif($cls=='grass')
                $data['b.class'] =1;
            elseif($cls=='media')
                $data['b.class'] =3;
            elseif($cls=='small')
                $data['b.class'] =4;
            $data['b.lock']='1';
            $data['bb.member_id']=array(array('neq',$_SESSION['cid']),array('exp','is NULL'),'or');
            $list = $blog->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count      = $blog->where($data)->count();
            $this->assign('cls',$cls);
            $theme='';
        }elseif($act== 'hots'){
            $data=$si;
            $data['lock']=array('eq','1');
            $data['hots']=array('gt','1');
            $data['bb.member_id']=array(array('neq',$_SESSION['cid']),array('exp','is NULL'),'or');
            $list = $blog->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count      = $blog->where($data)->count();
            $theme='bloger_hots';
        }elseif($act == 'fav'){
            $data=$si;
            $this->assign('blog_del_fav',U('company/blog_del_fav'));
            $blogf = D('favblogView');
            $data['bf.member_id'] = $_SESSION['cid'];
            $list = $blogf->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count = $blogf->where($data)->count();
            $theme='bloger_fav';
        }elseif($act == 'block'){
            $data=$si;
            $this->assign('blog_del_block',U('company/blog_del_block'));
            $blogf = D('bblogView');
            $data['bb.member_id'] = $_SESSION['cid'];
            $list = $blogf->where($data)->order($sort.' '.$direction)->page($p.',20')->select();
            $count = $blogf->where($data)->count();
            $theme='bloger_block';
        }elseif($act == 'history'){
            $data=$si;
            $blogf = D('hblogView');
            $data['tb.member_id'] = $_SESSION['cid'];
            $data['bb.member_id']=array(array('neq',$_SESSION['cid']),array('exp','is NULL'),'or');
            $list = $blogf->where($data)->order($sort.' '.$direction)->group('tb.blog_id')->page($p.',20')->select();
            $count = $blogf->where($data)->count();
            $theme='bloger_history';
        }
        $this->assign('list',$list);
        import("ORG.Util.Page");
        $Page       = new Page($count,20);
        $show       = $Page->show();
        $cs = S('class');
        if (!$cs)
        {
            $cs ='';
            $cla = M('class')->field('name,label')->findAll();
            foreach ($cla as $val)
                $cs .='<option value="'.$val['label'].'">'.$val['name'].'</option>';
            S('class',$cs,3600);
        }
        $this->assign('cs',$cs);
        $url = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        $this->assign('url',$url);
        $this->assign('hide',$hide);
        $this->assign('task_add_blog',U('company/task_add_blog'));
        $this->assign('task_del_blog',U('company/task_del_blog'));
        $this->assign('task_view_blog',U('company/task_view_blog'));
        $this->assign('blog_add_block',U('company/blog_add_block'));
        $this->assign('blog_add_fav',U('company/blog_add_fav'));
        $this->assign('select',U('company/task_choose'));
        $this->assign('page',$show);
        $this->display($theme);
    }
    public function blog_add_block()
    {
        $this->check();
        $data['blog_id']=$_POST['blog_id'];
        $data['member_id'] = $_SESSION['cid'];
        $bblock = M('blog_block');
        if ($bblock->where($data)->find())
            $this->ajaxReturn('','',1);
        if ($bblock->add($data))
        {
            $this->ajaxReturn('','',1);
        }else{
            $this->ajaxReturn('','操作失败,请稍后重试···',0);
        }
    }
    public function blog_del_block()
    {
        $this->check();
        $data['blog_id']=$_POST['blog_id'];
        $data['member_id'] = $_SESSION['cid'];
        $bblock = M('blog_block');
        if ($bblock->where($data)->delete())
            $this->ajaxReturn('','',1);
        else
            $this->ajaxReturn('','操作失败,请稍后重试···',0);
    }
    public function blog_add_fav()
    {
        $this->check();
        $data['blog_id']=$_POST['blog_id'];
        $data['member_id'] = $_SESSION['cid'];
        $bfav = M('blog_fav');
        if ($bfav->where($data)->find())
            $this->ajaxReturn('','',1);
        if ($bfav->add($data))
        {
            $this->ajaxReturn('','',1);
        }else{
            $this->ajaxReturn('','操作失败,请稍后重试···',0);
        }
    }
    public function blog_del_fav()
    {
        $this->check();
        $data['blog_id']=$_POST['blog_id'];
        $data['member_id'] = $_SESSION['cid'];
        $bfav = M('blog_fav');
        if ($bfav->where($data)->delete())
            $this->ajaxReturn('','',1);
        else
            $this->ajaxReturn('','操作失败,请稍后重试···',0);
    }
    public function bill_credit()
    {
        $this->check(3);
        $data['member_id']=$_SESSION['cid'];
        $mem = M('company_member');
        $money = $mem->where($data)->getField('money');
        $this->assign('money',$money);
        $this->assign('time',time());
        $this->display();
    }
    public function bill_payment()
    {
        $this->check(3);
        $data['member_id'] = $_SESSION['cid'];
        $ment = M('pay_ment');
        if (!empty($_POST['start_time']))
            $data['time']=array('egt',strtotime($_POST['start_time']));
        if (!empty($_POST['end_time']))
            $data['time']=array('lt',strtotime($_POST['end_time']));
        if (!empty($_POST['start_time']) &&!empty($_POST['end_time']))
            $data['time']=array('between',array(strtotime($_POST['start_time']),strtotime($_POST['end_time'])));
        $list = $ment->where($data)->order('pay_id desc')->select();
        $this->assign('list',$list);
        $this->display();
    }
    public function bill_payoff()
    {
        $this->check(3);
        $payoff = M('task_payoff');
        $data['member_id'] = $_SESSION['cid'];
        $list = $payoff->where($data)->select();
        $this->assign('list',$list);
        $this->display();
    }
    public function bill_recharge()
    {
        $this->check(3);
        $money = $_GET['money'];
        $mem = M('company_member');
        $data['member_id'] = $_SESSION['cid'];
        $info = $mem->where($data)->find();
        if ($money <= 0)
            $money=100;
        $this->assign('info',$info);
        $this->assign('bill_payment',U('company/bill_payment'));
        $this->assign('jump',U('company/pay_jump'));
        $this->assign('money',$money);
        $this->display();
    }
    public function pay_jump()
    {
        $this->check();
        require_once("alipay.config.php");
        require_once("alipay_service.class.php");
        $subject      = C('shop_name').'-余额充值';
        $payment = M('pay_ment');
        $data['member_id']=$_SESSION['cid'];
        $data['type'] = $subject;
        $data['time'] = time();
        $out_trade_no = $payment->add($data);
        $body         = '余额不足！充值';
        $total_fee    = $_POST['outlay'];
        $anti_phishing_key  = 'false';
        $exter_invoke_ip = $this->getIp();
        $parameter = array(
            "service"=>"create_direct_pay_by_user",
            "payment_type"=>"1",
            "partner"=>trim($aliapy_config['partner']),
            "_input_charset"=>trim(strtolower($aliapy_config['input_charset'])),
            "seller_email"=>trim($aliapy_config['seller_email']),
            "return_url"=>'http://'.$_SERVER['HTTP_HOST'].C('shop_dir').$aliapy_config['return_url'],
            "notify_url"=>'http://'.$_SERVER['HTTP_HOST'].C('shop_dir').$aliapy_config['notify_url'],
            "out_trade_no"=>$out_trade_no,
            "subject"=>$subject,
            "body"=>$body,
            "total_fee"=>$total_fee,
            "paymethod"=>$paymethod,
            "defaultbank"=>$defaultbank,
            "anti_phishing_key"=>$anti_phishing_key,
            "exter_invoke_ip"=>$exter_invoke_ip,
            "show_url"=>$show_url,
            "extra_common_param"=>$extra_common_param,
            "royalty_type"=>$royalty_type,
            "royalty_parameters"=>$royalty_parameters
        );
        $alipayService = new AlipayService($aliapy_config);
        $html_text = $alipayService->create_direct_pay_by_user($parameter);
        $this->assign('form',$html_text);
        $this->display('pay_to');
    }
    public function notify_url()
    {
        $this->check();
        require_once("alipay.config.php");
        require_once("alipay_notify.class.php");
        $alipayNotify = new AlipayNotify($aliapy_config);
        $verify_result = $alipayNotify->verifyNotify();
        if($verify_result) {
            $out_trade_no    = $_POST['out_trade_no'];
            $trade_no        = $_POST['trade_no'];
            $total_fee        = $_POST['total_fee'];
            $payment= M('pay_ment');;
            $data['pay_id']=$out_trade_no;
            $info = $payment->where($data)->find();
            $data['time'] = time();
            $data['money'] = $total_fee;
            $data['code'] = $trade_no;
            $data['state'] = 1;
            $payment->save($data);
            M('company_member')->setInc('money','member_id='.$info['member_id'],$total_fee);
            echo "success";
        }
    }
    public function return_url()
    {
        echo 'success';
    }
    public function help()
    {
        $this->check(5);
        $this->display();
    }
}

?> 