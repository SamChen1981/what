<?php

class adminAction extends backAction
{
    public function check()
    {
        if ($_SESSION['aid']<=0)
            $this->redirect('admin/login','',0,'请先登录');
    }

    public function testlizhen(){
        var_dump("sth");
    }

    public function test_send()
    {
        if ($info = is_send(24))
        {
            $d['tb.task_id'] = 35;
            $tbm = D('taskbmView');
            $list = $tbm->where($d)->group('bm.member_id')->select();
            foreach($list as $v)
            {
                $content = $this->get_draw_theme($info['content'],array());
                $err = send_sms($v['phone'],$content);
            }
        }
        dump($err);
        dump($content);
        dump($list);
    }
    public function cron()
    {
        $this->display();
    }
    public function task_cron()
    {
        $cron = M('task_cron');
        $data['time'] = array('elt',time());
        $clist =$cron->where($data)->findAll();
        foreach($clist as $val)
        {
            switch($val['type'])
            {
                case 0:
                    if ($info = is_send(24))
                    {
                        $d=array();
                        $d['tb.task_id'] = $val['task_id'];
                        $tbm = D('taskbmView');
                        $list = $tbm->where($d)->group('bm.member_id')->select();
                        foreach($list as $v)
                        {
                            $content = $this->get_draw_theme($info['content'],array());
                            $err = send_sms($v['phone'],$content);
                        }
                    }
                    break;
                case 1:
                    $dat['task_id']=$val['task_id'];
                    $dat['state'] = '2';
                    M('task')->save($dat);
                    break;
                case 2:
                    $d=array();
                    $da['task_id'] = $val['task_id'];
                    $da['reject']='0';
                    $d['reject'] = '4';
                    M('task_blog')->where($da)->save($d);
                    $task = M('task');
                    unset($da['reject']);
                    $t = $task ->where($da)->find();
                    $da['ld_num'] = $t['yp_num']-$t['url_num']-$t['rj_num'];
                    $da['state'] = '3';
                    $task->save($da);
                    $money = $t['money']-$t['consume'];
                    if ($money >0)
                        M('company_member')->setInc('money','member_id='.$t['member_id'],$money);
            }
            $del['tc_id'] = $val['tc_id'];
            $cron->where($del)->delete();
        }
        $c =$cron->order('time asc')->find();
        if ($c)
            $this->ajaxReturn('',10,1);
        else
            $this->ajaxReturn('','',0);
    }
    public function clearCache($path=NULL) {
        $this->check(1);
        $type=isset($_GET['act']) ?$_GET['act'] : -1;
        if(is_null($path)) {
            switch($type) {
                case 0:
                    $path = CACHE_PATH;
                    break;
                case 1:
                    $path   =   TEMP_PATH;
                    break;
                case 2:
                    $path   =   LOG_PATH;
                    break;
                case 3:
                    $path   =   DATA_PATH;
                    break;
                case 4:
                    $path   =   APP_PATH.'/Runtime/';
            }
        }
        import("ORG.Io.Dir");
        if ($type == 3)
            Dir::delDir($path);
        else
            Dir::del($path);
        $this->success('恭喜！缓存清除成功！');
    }
    public function set_pay()
    {
        $this->check();
        $this->setting('pay');
        $this->display();
    }
    public function set_class()
    {
        $this->check();
        $class = M('class');
        if ($this->isPost())
        {
            foreach ($_POST['clabel'] as $key =>$val)
            {
                $str='';
                foreach ($val as $v)
                    if ($v !='')
                        $str .=$v.' ';
                $str = trim($str);
                $save['name']=$_POST['name'][$key];
                $save['label'] = $str;
                $save['class_id'] =$key;
                $class->save($save);
            }
            foreach($_POST['clabela'] as $key =>$val)
            {
                $str='';
                foreach ($val as $v)
                    if ($v !='')
                        $str .=$v.' ';
                $str = trim($str);
                $add[$key]['name']=$_POST['class_namea'][$key];
                $add[$key]['label'] = $str;
            }
            if (!empty($add))
                $class->addAll($add);
        }
        $cen = $_POST['label'];
        unset($_POST);
        $_POST['label']=$cen;
        $list = $class->select();
        foreach($list as $key=>$val)
            $list[$key]['label'] = explode(' ',$val['label']);
        $this->assign('list',$list);
        $this->setting('label');
        $this->assign('del_class',U('admin/del_class'));
        $this->display();
    }
    public function del_class()
    {
        $data['class_id']=$_POST['id'];
        if (M('class')->where($data)->delete())
            $this->ajaxReturn('','',1);
        else
            $this->ajaxReturn('','删除失败',0);
    }
    public function set_cash()
    {
        $this->check();
        $cash = M('cash');
        if ($this->isPost())
        {
            $str = '0123456789abcdefghijklmnopqrstuvwxyz';
            $c=array();
            for ($i2=0;$i2<$_POST['num'];$i2++)
            {
                $card='';
                for ($i=0;$i<=15;$i++)
                    $card .=$str{rand(0,35)};
                $c[$i2]['card']=$card;
                $c[$i2]['money'] = $_POST['money'];
            }
            $cash->addAll($c);
        }
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        $list =$cash->order('cash_id desc,state asc')->page($p.',20')->findAll();
        $count = $cash->count();
        $this->showpage($count);
        $this->assign('list',$list);
        $this->assign('hset_cash',U('admin/hset_cash'));
        $this->display();
    }
    public function hset_cash()
    {
        $this->check();
        $act = $_GET['act'];
        $id = $_GET['cash_id'];
        $cash = M('cash');
        if ($act=='del')
        {
            $data['cash_id'] =$id;
            $cash->where($data)->delete();
            $this->success('删除红包，操作成功！');
        }elseif ($act=='gnt'){
            $data['cash_id'] = $id;
            $data['state'] = 3;
            $cash->save($data);
            $this->success('发放红包，操作成功！');
        }
    }
    public function set_config()
    {
        $this->check();
        unset($_POST['photo']);
        if ($this->isPost())
        {
            if ($_POST['hgive']!=$_POST['give_m'])
            {
                $blog = M('blog');
                $count = $blog->count();
                $i=0;
                while(1){
                    $list = $blog->limit($i.',20')->select();
                    if(!$list) break;
                    foreach($list as $val)
                    {
                        $data['blog_id']=$val['blog_id'];
                        $data['com_money'] = $val['money']+sprintf("%.2f",$val['money']*$_POST['give_m']/100);
                        $data['com_pmoney'] = $val['publish_money']+sprintf("%.2f",$val['publish_money']*$_POST['give_m']/100);
                        $data['give_m'] =$_POST['give_m'];
                        $blog->save($data);
                    }
                    $i= $i+20;
                }
            }
        }
        $this->setting('shop_config');
        $this->display();
    }
    public function set_sms()
    {
        $this->check();
        if ($this->isPost())
            unset($_POST['smstest']);
        $this->setting('sms');
        $this->assign('testsms',U('admin/testsms'));
        $this->display();
    }
    public function testsms()
    {
        $this->check();
        $info = send_sms($_POST['smstest'],'恭喜，当您看到这条信息时，证明您的短信系统工作正常。');
        if (!$info['error'])
        {
            $this->ajaxReturn('','已成功发送',1);
        }else{
            $this->ajaxReturn('',$info['msg'],1);
        }
    }
    public function set_email()
    {
        $this->check();
        if ($this->isPost())
        {
            unset($_POST['addtest']);
        }
        $this->setting('email');
        $this->assign('testemail',U('admin/testemail'));
        $this->display();
    }
    public function testemail()
    {
        $this->check();
        $info = send_email($_POST['addtest'],'测试通过','这是系统测试内容，您收到此邮件，证明您网站的邮件系统工作正常！');
        if (!$info['error'])
        {
            $this->ajaxReturn('','已成功发送',1);
        }else{
            $this->ajaxReturn('','发送失败'.$info['msg'],0);
        }
    }
    public function set_theme()
    {
        $this->check();
        $theme = M('theme');
        if ($this->isPost())
        {
            $data['status']='0';
            $theme->where('1=1')->save($data);
            $data['status']='1';
            foreach($_POST as $key=>$val)
                $id .=$key.',';
            $id =substr($id,0,-1);
            $w['theme_id']=array('in',$id);
            $theme->where($w)->save($data);
        }
        $list =$theme->order('send_name,type')->findAll();
        $i=0;$b=1;
        foreach($list as $val)
        {
            $t[$i][$val['type'].'_id']= $val['theme_id'];
            $t[$i][$val['type'].'_status']= $val['status'];
            if ($b==2)
            {$t[$i]['send_name']=$val['send_name'];$b=1;$i++;}
            else
                $b++;
        }
        $this->assign('theme_edit',U('admin/theme_edit'));
        $this->assign('list',$t);
        $this->display();
    }
    public function theme_edit()
    {
        $data['theme_id'] = $_GET['theme_id'];
        $theme = M('theme');
        if ($this->isPost())
        {
            $theme->create();
            $theme->save();
        }
        $info =$theme->where($data)->find();
        $this->assign('info',$info);
        $this->display();
    }
    public function article()
    {
        $this->check();
        $article = M('article');
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        $list = $article->order('article_id desc')->page($p.',20')->select();
        $count      = $article->count();
        $this->showpage($count);
        $this->assign('list',$list);
        $this->assign('harticle',U('admin/harticle'));
        $this->display();
    }
    public function showpage($count)
    {
        import("ORG.Util.Page");
        $Page       = new Page($count,20);
        $show       = $Page->show();
        $this->assign('page',$show);
    }
    public function harticle()
    {
        $this->check();
        $article=M('article');
        $data['article_id']=$_GET['article_id'];
        $act = $_GET['act'];
        if ($act == 'del')
        {
            $article->where($data)->delete();
            $this->assign('jumpUrl',U('admin/article'));
            $this->success('操作成功');
        }elseif($act=='edit'){
            $info = $article->where($data)->find();
            $this->assign('harticle_edit',U('admin/harticle_edit'));
            $this->assign('info',$info);
            $this->display('article_edit');
        }else
            $this->error('操作错误');
    }
    public function harticle_edit()
    {
        $this->check();
        $article = M('article');
        $article->create();
        $article->article_id = $_GET['article_id'];
        if ($article->save())
        {
            $this->assign('jumpUrl',U('admin/article'));
            $this->success('恭喜，编辑成功！');
        }else $this->error('修改失败，请稍后重试···');
    }
    public function article_add()
    {
        $this->check();
        $this->assign('harticle_add',U('admin/harticle_add'));
        $this->assign('upload',U('company/upload'));
        $this->display();
    }
    public function harticle_add()
    {
        $this->check();
        $article = M('article');
        $article->create();
        if ($article->add())
            $this->success('恭喜！增加成功');
        else
            $this->error('增加失败，请稍后重试···');
    }
    public function index()
    {
        $this->check();
        $this->redirect('admin/sblog','',0,'正在跳转····');
    }
    public function login()
    {
        if ($_SESSION['aid']>0)
            $this->redirect('admin/index');
        $this->assign('hlogin',U('admin/hlogin'));
        $this->assign('verify',U('blog/verify'));
        $this->display();
    }
    public function register()
    {
        $this->check();
        $this->assign('hregister',U('admin/hregister'));
        $this->display();
    }
    public function admin_list()
    {
        $this->check();
        if ($_SESSION['aid']!='1')
            $this->error('无权限！');
        $admin = M('admin');
        $data['admin_id'] = $_GET['admin_id'];
        if ($_GET['act']=='del')
        {
            if ($data['admin_id']==1)
                $this->error('操作错误！超级管理员不可删除！');
            $admin->where($data)->delete();
            $this->success('恭喜！删除成功！');
        }elseif($_GET['act']=='edit'){
            if ($this->isPost())
            {
                $dat['username'] = $_POST['username'];
                if ($admin->where($dat)->find())
                    $this->error('修改失败！用户名已存在！');
                if ($_POST['password']!='')
                    $_POST['password'] = md5($_POST['password']);
                else unset($_POST['password']);
                $admin->create();
                $admin->admin_id = $data['admin_id'];
                $admin->save();
                $this->assign('jumpUrl',U('admin/admin_list'));
                $this->success('恭喜！管理要信息修改成功！');
            }
            $info= $admin->where($data)->find();
            $this->assign('info',$info);
            $this->display('admin_edit');
            exit;
        }
        $list = $admin->findAll();
        $this->assign('admin_list',U('admin/admin_list'));
        $this->assign('list',$list);
        $this->display();
    }
    public function hregister()
    {
        $this->check();
        $mem = M('admin');
        $data['username'] = $_POST['username'];
        if ($mem->where($data)->find())
            $this->error('用户已存在');
        $mem->create();
        $mem->password = md5($_POST['password']);
        $mem->lasttime = time();
        $mem->login_count = 1;
        $id = $mem->add();
        if ($id)
            $this->success('恭喜，添加成功！');
        else
            $this->error('抱歉操作错误,请稍后重试');
    }
    public function edit_pass()
    {
        $this->check();
        $this->assign('hedit_pass',U('admin/hedit_pass'));
        $this->display();
    }
    public function hedit_pass()
    {
        $this->check();
        $mem = M('admin');
        $data['admin_id'] = $_SESSION['aid'];
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
    public function logout()
    {
        session_unset();
        $this->assign('jumpUrl',U('admin/login'));
        $this->success('恭喜，您已安全退出');
    }
    public function hlogin()
    {
        if (md5($_POST['verify'])!=$_SESSION['verify'])
            $this->ajaxReturn('','验证码错误',0);
        $data['password'] = md5($_POST['password']);
        $data['username'] = $_POST['username'];
        $mem = M('admin');
        $info = $mem->where($data)->find();
        if ($info)
        {
            $_SESSION['aid'] = $info['admin_id'];
            $_SESSION['username']=$data['username'];
            $data=array();
            $data['lasttime']= time();
            $data['login_count'] = $info['login_count']+1;
            $data['admin_id'] = $info['admin_id'];
            $mem->save($data);
            $this->ajaxReturn('',U('admin/index'),1);
        }
        else
            $this->ajaxReturn('','用户名或密码错误',0);
    }
    public function sblog()
    {
        $this->check();
        $blog = M('blog');
        $data= array();
        $data['lock']= '0';
        $info = $blog->where($data)->page($_GET['p'].',20')->findAll();
        $count = $blog->where($data)->count();
        $this->showpage($count);
        $this->assign('val',$info);
        $this->assign('hsblog',U('admin/hsblog'));
        $this->display();
    }
    public function hsblog()
    {
        $this->check();
        $blog=M('blog');
        $data['blog_id'] = $_GET['blog_id'];
        $data['lock'] = $_GET['lock'];
        $blog->save($data);
        if ($_GET['lock']==1)
        {
            $sid = '4';
            $eid = '5';
        }
        elseif($_GET['lock']==2){
            $sid = '6';
            $eid = '7';
        }
        if ($info = is_send($eid))
        {
            $dat['blog_id'] = $_GET['blog_id'];
            $blog = M('blog')->where($dat)->field('nick,member_id')->find();
            $m['member_id'] = $blog['member_id'];
            $member = M('blog_member')->where($m)->field('username,email')->find();
            $array=array('nick'=>$blog['nick'],'username'=>$member['username']);
            $content = $this->get_draw_theme($info['content'],$array);
            $err =send_email($member['email'],$info['name'],$content,$member['username']);
        }
        if ($info = is_send($sid))
        {
            $dat['blog_id'] = $_GET['blog_id'];
            $blog = M('blog')->where($dat)->field('nick,member_id')->find();
            $m['member_id'] = $blog['member_id'];
            $member = M('blog_member')->where($m)->field('username,phone')->find();
            $array=array('nick'=>$blog['nick'],'username'=>$member['username']);
            $content = $this->get_draw_theme($info['content'],$array);
            $err = send_sms($member['phone'],$content);
        }
        $this->assign('jumpUrl',U('admin/sblog'));
        $this->success('操作成功');
    }
    public function gblog($theme='gblog')
    {
        $this->check();
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        $blog=M('blog');
        if (isset($_GET['member_id']))
            $data['member_id'] = $_GET['member_id'];
        if (!empty($_GET['str']))
            $data[$_GET['field']] = array('like','%'.$_GET['str'].'%');
        if (!empty($_GET['sort']))
            $blog->order($_GET['field'].' '.$_GET['sort']);
        else
            $blog->order('blog_id desc');
        $data['lock'] = array('neq','0');
        $info = $blog->where($data)->page($p.',20')->findAll();
        $count = $blog->where($data)->count();
        $this->showpage($count);
        $this->assign('val',$info);
        $this->assign('action',U('admin/gblog'));
        $this->assign('hgblog',U('admin/hgblog'));
        $this->display($theme);
    }
    public function hgblog()
    {
        $this->check();
        $blog=M('blog');
        $data['blog_id']=$_GET['blog_id'];
        $act = $_GET['act'];
        if ($act == 'del')
        {
            $blog->where($data)->delete();
            $this->assign('jumpUrl',U('admin/gblog'));
            $this->success('操作成功');
        }elseif ($act == 'edit'){
            $this->weibo_edit();
            exit;
        }else
            $this->error('操作错误');
    }
    public function weibo_edit($theme='weibo_edit')
    {
        $this->check();
        $blog= M('blog');
        if ($this->isPost())
        {
            $data = array();
            $data['blog_id'] = $_GET['blog_id'];
            $blog->create();
            $blog->com_money = $_POST['money']+sprintf("%.2f",$_POST['money']*$_POST['give_m']/100);
            $blog->com_pmoney = $_POST['publish_money']+sprintf("%.2f",$_POST['publish_money']*$_POST['give_m']/100);
            $blog->lasttime= time();
            if ($blog->where($data)->save())
            {
                $this->success('恭喜，数据更新成功！');
            }else{
                $this->error('数据更新失败，没有修改数据或稍后重试···');
            }
        }
        $arr = unserialize(M('config')->where('name="label"')->getField('value'));
        $arr = explode(',',$arr['label']);
        $this->assign('list',$arr);
        $data= array();
        $data['blog_id'] = $_GET['blog_id'];
        $info = $blog->where($data)->find();
        $this->assign('info',$info);
        $this->assign('hweibo_edit',U('admin/hweibo_edit'));
        $this->display($theme);
    }
    public function blog_member()
    {
        $this->check();
        $bmem = M('blog_member');
        if (!empty($_GET['str']))
            $data[$_GET['field']] = array('like','%'.$_GET['str'].'%');
        if (!empty($_GET['sort']))
            $bmem->order($_GET['field'].' '.$_GET['sort']);
        else
            $bmem->order('member_id desc');
        $list = $bmem->where($data)->page($_GET['p'].',20')->select();
        $count = $bmem->count();
        $this->showpage($count);
        $this->assign('action',U('admin/blog_member'));
        $this->assign('list',$list);
        $this->assign('hblog_member',U('admin/hblog_member'));
        $this->display();
    }
    public function hblog_member()
    {
        $this->check();
        $blog=M('blog_member');
        $data['member_id']=$_GET['member_id'];
        $act = $_GET['act'];
        if ($act == 'del')
        {
            $blog->where($data)->delete();
            $this->assign('jumpUrl',U('admin/blog_member'));
            $this->success('操作成功');
        }elseif ($act == 'edit'){
            $this->blog_edit();
            exit;
        }elseif ($act == 'blog'){
            $this->gblog();
            exit;
        }elseif ($act == 'pay'){
            $this->gpay();
            exit;
        }else
            $this->error('操作错误');
    }
    public function blog_edit($theme='blog_edit')
    {
        $this->check();
        $mem = M('blog_member');
        $data['member_id'] = $_GET['member_id'];
        $info = $mem->where($data)->find();
        $this->assign('info',$info);
        $this->assign('hblog_edit',U('admin/hblog_edit'));
        $this->display($theme);
    }
    public function hblog_edit()
    {
        $this->check();
        $mem = M('blog_member');
        $mem->create();
        if (!empty($_POST['password']))
        {
            if (!empty($_POST['repassword']))
            {
                if ($_POST['password'] != $_POST['repassword'])
                {
                    $this->error('两次密码输入不同！');
                }else $mem->password = md5($_POST['password']);
            }else $this->error('重复密码不能为空！');
        }else unset($mem->password);
        if ($mem->save())
            $this->ajaxReturn('',"更新成功",1);
        else
            $this->ajaxReturn('','更新失败或未做出修改',0);
    }
    public function scompany()
    {
        $this->check();
        $cmem = M('company_member');
        $data= array();
        $data['wedlock']= '0';
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        $list = $cmem->where($data)->order('member_id desc')->page($_GET['p'].',20')->findAll();
        $count = $cmem->where($data)->count();
        $this->showpage($count);
        $this->assign('val',$list);
        $this->assign('hscompany',U('admin/hscompany'));
        $this->display();
    }
    public function hscompany()
    {
        $this->check();
        $cmem=M('company_member');
        $data['member_id'] = $_GET['member_id'];
        $data['wedlock'] = $_GET['wedlock'];
        $cmem->save($data);
        if ($_GET['wedlock']==1)
        {
            $sid = '20';
            $eid = '21';
        }
        elseif($_GET['wedlock']==2){
            $sid = '10';
            $eid = '11';
        }
        if ($info = is_send($eid))
        {
            $m['member_id'] = $_GET['member_id'];
            $member = M('company_member')->where($m)->field('username,email')->find();
            $array=array('username'=>$member['username']);
            $content = $this->get_draw_theme($info['content'],$array);
            $err =send_email($member['email'],$info['name'],$content,$member['username']);
        }
        if ($info = is_send($sid))
        {
            $m['member_id'] = $_GET['member_id'];
            $member = M('blog_member')->where($m)->field('username,phone')->find();
            $array=array('username'=>$member['username']);
            $content = $this->get_draw_theme($info['content'],$array);
            $err = send_sms($member['phone'],$content);
        }
        $this->assign('jumpUrl',U('admin/scompany'));
        $this->success('操作成功');
    }
    public function gcompany()
    {
        $this->check();
        $cmem = M('company_member');
        $data= array();
        if (!empty($_GET['str']))
            $data[$_GET['field']] = array('like','%'.$_GET['str'].'%');
        if (!empty($_GET['sort']))
            $cmem->order($_GET['field'].' '.$_GET['sort']);
        else
            $cmem->order('member_id desc');
        $data['wedlock']= array('neq','0');
        $list = $cmem->where($data)->page($_GET['p'].',20')->findAll();
        $count = $cmem->where($data)->count();
        $this->showpage($count);
        $this->assign('val',$list);
        $this->assign('action',U('admin/gcompany'));
        $this->assign('hgcompany',U('admin/hgcompany'));
        $this->display();
    }
    public function hgcompany()
    {
        $this->check();
        $blog=M('company_member');
        $data['member_id']=$_GET['member_id'];
        $act = $_GET['act'];
        if ($act == 'del')
        {
            $blog->where($data)->delete();
            $this->assign('jumpUrl',U('admin/gcompany'));
            $this->success('操作成功');
        }elseif($act =='task'){
            $this->gtask();
            exit;
        }elseif($act =='edit'){
            $this->account_edit();
            exit;
        }elseif($act =='dinner'){
            $this->gdinner();
            exit;
        }elseif($act =='pay'){
            $this->assign('member_id',$data['member_id']);
            $this->assign('hcompany_pay',U('admin/hcompany_pay'));
            $this->display('company_pay');
        }else
            $this->error('操作错误');
    }
    public function account_edit($theme='account_edit')
    {
        $this->check();
        $mem = M('company_member');
        $data['member_id'] = $_GET['member_id'];
        $info = $mem->where($data)->find();
        $this->assign('info',$info);
        $this->assign('haccount_edit',U('admin/haccount_edit'));
        $this->display($theme);
    }
    public function haccount_edit()
    {
        $this->check();
        $mem = M('company_member');
        $mem->create();
        if (!empty($_POST['password']))
        {
            if (!empty($_POST['repassword']))
            {
                if ($_POST['password'] != $_POST['repassword'])
                {
                    $this->error('两次密码输入不同！');
                }else $mem->password = md5($_POST['password']);
            }else $this->error('重复密码不能为空！');
        }else unset($mem->password);
        if ($mem->save())
        {
            $this->success('更新成功');
        }
        else
            $this->error('更新失败或没有做出任何修改,请稍候重试');
    }
    public function hcompany_pay()
    {
        $this->check();
        $mem = M('company_member');
        $data['member_id'] = $_GET['member_id'];
        $money = $mem->where($data)->getField('money');
        $money = $money+$_POST['money'];
        $data['money'] = $money;
        if ($mem->save($data))
        {
            $this->assign('jumpUrl',U('admin/gcompany'));
            $this->success('恭喜充值成功');
        }else dump($mem);exit;$this->error('抱歉，充值失败，请稍后重试');
    }
    public function gtask($theme='gtask')
    {
        $this->check();
        $task = M('task');
        if (!empty($_GET['str']))
            $data[$_GET['field']] = array('like','%'.$_GET['str'].'%');
        if (!empty($_GET['sort']))
            $task->order($_GET['field'].' '.$_GET['sort']);
        else
            $task->order('task_id desc');
        if (isset($_GET['member_id']))
        {
            $data['member_id'] = $_GET['member_id'];
        }
        $list = $task->where($data)->page($_GET['p'].',20')->select();
        $count = $task->where($data)->count();
        $this->assign('val',$list);
        $this->showpage($count);
        $this->assign('action',U('admin/gtask'));
        $this->assign('hgtask',U('admin/hgtask'));
        $this->display($theme);
    }
    public function hgtask()
    {
        $this->check();
        $task=M('task');
        $data['task_id']=$_GET['task_id'];
        $act = $_GET['act'];
        if ($act == 'del')
        {
            $tb = M('task_blog');
            $tb->where($data)->delete();
            $task->where($data)->delete();
            $this->assign('jumpUrl',U('admin/gtask'));
            $this->success('操作成功');
        }elseif ($act == 'fade'){
            $info = $task->where($data)->find();
            if ($info['pay_state']=='N')
                $this->error('订单未支付，不用退单！');
            if ($info['state']=='2')
                $this->error('正在派单，无法退单！');
            if ($info['state']=='3')
                $this->error('派单完成，无法退单！');
            if ($info['state']=='4')
                $this->error('已退单，不要重复操作！');
            $dati['task_id'] = $info['task_id'];
            $da['reject'] = '3';
            M('task_blog')->where($dati)->save($da);
            $data['state'] ='4';
            $data['qx_num'] = $info['yp_num'];
            $data['yp_num'] ='0';
            $task->save($data);
            M('company_member')->setInc('money','member_id='.$info['member_id'],$info['money']);
            $tc['task_id'] = $info['task_id'];
            M('task_cron')->where($tc)->delete();
            if ($tinfo = is_send(28))
            {
                $d['tb.task_id'] = $info['task_id'];
                $tbm = D('taskbmView');
                $list = $tbm->where($d)->group('bm.member_id')->select();
                foreach($list as $v)
                {
                    $content = $this->get_draw_theme($tinfo['content'],array());
                    $err = send_sms($v['phone'],$content);
                }
            }
            $this->success('恭喜！退单成功');
        } elseif ($act == 'jiesuan'){
            $info = $task->where($data)->find();
            if ($info['state']=='3')
                {$this->error('已结算完成！请不要重复操作');exit;}
            M('company_member')->setInc('money','member_id='.$info['member_id'],($info['money']-$info['consume']));
			
				$data1['state']='3';
			$task->where('task_id='.$info['task_id'])->save($data1); 
			
            $tc['task_id'] = $info['task_id'];
            M('task_cron')->where($tc)->delete();
            $this->success('恭喜！结算成功');
        }elseif ($act == 'edit'){
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
                    $this->success('恭喜！编辑成功！');
                else
                    $this->error('','修改失败，请稍后重试',0);
            }
            $info = $task->where($data)->find();
            $this->assign('info',$info);
            $this->display('task_edit');
        }elseif($act=='look'){
            $data['task_id'] = $_GET['task_id'];
            $task = M('task');
            if (!$info = $task->where($data)->find())
                $this->error('抱歉，未找活动信息！');
            $this->assign('info',$info);
            $tblog = D('taskbView');
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
            $this->display('task_info');
            exit;
        }else
            $this->error('操作错误');
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
    public function gdinner($theme='gdinner')
    {
        $this->check();
        $dinner = D('dinnermView');
        $data = '';
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        if (!empty($_GET['str']))
            $data[$_GET[field]] = array('like','%'.$_GET['str'].'%');
        if (!empty($_GET['sort']))
            $order = $_GET['field'].' '.$_GET['sort'];
        else
            $order = 'cd.cdinner_id desc ';
        if (isset($_GET['member_id']))
        {
            $data['cd.member_id'] = array('eq',$_GET['member_id']);
        }
        $list = $dinner->where($data)->order($order)->page($p.',20')->select();
        $count = $dinner->where($data)->count();
        $this->assign('list',$list);
        $this->assign('action',U('admin/gdinner'));
        $this->showpage($count);
        $this->assign('hgdinner',U('admin/hgdinner'));
        $this->display($theme);
    }
    public function hgdinner()
    {
        $this->check();
        $cdinner=M('company_dinner');
        $data['cdinner_id']=$_GET['cdinner_id'];
        $act = $_GET['act'];
        if ($act == 'del')
        {
            $cdinner->where($data)->delete();
            $this->assign('jumpUrl',U('admin/gdinner'));
            $this->success('操作成功');
        }elseif($act=='look'){
            if ($this->isPost())
            {
                $dinner = M('company_dinner');
                $dinner->create();
                $dinner->s_time = time();
                if ($_POST['state']=='3')
                    $dinner->addtime = time();
                if ($dinner->save())
                    $this->success('保存成功！');
                else
                    $this->error('抱歉！保存失败，请稍后再试···');
            }
            $this->assign('adminl',M('admin')->field('username')->select());
            $info = D('dinnermView')->where($data)->find();
            $this->assign('info',$info);
            $this->display('dinner_info');
        }else
            $this->error('操作错误');
    }
    public function dinner_list()
    {
        $dinner = M('dinner');
        $list =$dinner->select();
        $this->assign('list',$list);
        $this->assign('hdl',U('admin/hdl'));
        $this->display();
    }
    public function hdl()
    {
        $data['dinner_id'] = $_GET['dinner_id'];
        $dinner = M('dinner');
        $act = $_GET['act'];
        if ($act=='del')
        {
            $dinner->where($data)->delete();
            $this->success('恭喜！删除成功');
        }elseif($act=='edit'){
            if ($this->isPost())
            {
                $dinner->create();
                $dinner->dinner_id = $data['dinner_id'];
                $dinner->save();
                $this->success('恭喜！修改成功！');
            }
            $info = $dinner->where($data)->find();
            $this->assign('info',$info);
            $this->display('dinner_edit');
        }else $this->error('操作错误');
    }
    public function dinner_add()
    {
        $this->check();
        $this->assign('hdinner_add',U('admin/hdinner_add'));
        $this->display();
    }
    public function hdinner_add()
    {
        $this->check();
        $dinner = M('dinner');
        $dinner->create();
        if ($dinner->add())
            $this->success('恭喜，增加成功');
        else
            $this->error('增加失败！请稍候重试');
    }
    public function gpay()
    {
        $this->check();
        $payoff = M();
        $where = '';
        $p = isset($_GET['p']) ?$_GET['p'] :0;
        if (!empty($_GET['str']))
            $where = ' AND b.'.$_GET['field'].' like "%'.$_GET['str'].'%" ';
        if (!empty($_GET['sort']))
            $order = ' order by b.'.$_GET['field'].' '.$_GET['sort'];
        else
            $order = ' order by bp.state asc ';
        if (isset($_GET['member_id']))
            $where .=' AND b.member_id='.$_GET['member_id'];
        $list = $payoff->query('SELECT bp.bpayoff_id,bp.time,bp.money,bp.pay_time,bp.state,b.alipay_account,b.alipay_realname  FROM '
            .C('DB_PREFIX').'blog_payoff AS bp , '
            .C('DB_PREFIX').'blog_member AS b WHERE b.member_id=bp.member_id '.$where.$order.' limit '.$p.',20');
        $count = $payoff->query('SELECT count(*) as num FROM '
            .C('DB_PREFIX').'blog_payoff AS bp , '
            .C('DB_PREFIX').'blog_member AS b WHERE b.member_id=bp.member_id '.$where);
        $this->assign('action',U('admin/gpay'));
        $this->showpage($count[0]['num']);
        $this->assign('list',$list);
        $this->assign('hgpay',U('admin/hgpay'));
        $this->display('payoff');
    }
    public function hgpay()
    {
        $this->check();
        $blog_off=M('blog_payoff');
        $data['bpayoff_id']=$_GET['bpayoff_id'];
        $data['state'] = 1;
        $data['pay_time'] = time();
        $act = $_GET['act'];
        if ($act == 'pay')
        {
            $blog_off->save($data);
            $this->assign('jumpUrl',U('admin/gpay'));
            $this->success('操作成功');
        }else
            $this->error('操作错误');
    }
}

?> 