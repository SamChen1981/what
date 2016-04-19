<?php

class indexAction extends Action
{
	public function setting($name,$file=false,$dir='web/')
    {
        $config = M('config');
        $data['name'] = $name;
        $info = $config->where($data)->getField('value');
        $info=unserialize($info);
        $this->assign('info',$info);
    }
    public function index()
    {
        $article = M('article');
        $data['type']=3;
        $d['article_id'] = $_GET['article_id'];
        $list =$article->field('article_id,name')->where($data)->order('article_id desc')->select();
        $this->assign('list',$list);
        $this->assign('about',U('index/about'));
        $this->assign('hlogin',U('company/hlogin'));
        $this->assign('register',U('company/register'));
        $this->assign('verify',U('blog/verify'));
        $this->assign('checklogin',U('index/checkLogin'));
		$this->setting('shop_config');
        $this->display();
    }
    public function get_pw()
    {
        if ($this->isPost())
        {
            if (md5($_POST['verify'])!=$_SESSION['verify'])
                $this->error('验证码输入错误');
            $data['username'] = trim($_POST['username']);
            $data['email'] = trim($_POST['email']);
            if ($_GET['type']=='1')
            {
                $cm = M('company_member');
                if ($cm->where($data)->find())
                {
                    $pw = rand(100000,999999);
                    $dat['password'] = md5($pw);
                    $cm->where($data)->save($dat);
                }else $this->error('用户名或邮件地址输入错误！');
            }elseif($_GET['type']=='2'){
                $bm = M('blog_member');
                if ($bm->where($data)->find())
                {
                    $pw = rand(100000,999999);
                    $dat['password'] = md5($pw);
                    $bm->where($data)->save($dat);
                }else $this->error('用户名或邮件地址输入错误！');
            }else $this->error('操作错误');
            if ($info = is_send(3))
            {
                $array=array('password'=>$pw,'username'=>$_POST['username']);
                $content = $this->get_draw_theme($info['content'],$array);
                $err =send_email($_POST['email'],$info['name'],$content,$_POST['username']);
            }
            $this->success('恭喜，新密码已发送至您的邮箱！');
        }
        $this->display();
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
    public function checkLogin()
    {
        if ($_SESSION['cid']<=0)
            $this->ajaxReturn('','',0);
        if ($_POST['type']=='qiye')
        {
            $mem = M('company_member');
            $data['member_id']=$_SESSION['cid'];
        }else{
            $mem = M('company_blog');
            $data['member_id']=$_SESSION['uid'];
        }
        $info = $mem->where($data)->find();
        $this->ajaxReturn($info,'',1);
    }
    public function gaishu()
    {
        $this->assign('on',1);
		$this->setting('shop_config');
        $this->display();
    }
    public function youshi()
    {
        $this->assign('on',1);
        $this->display();
    }
    public function tuiguang()
    {
        $this->assign('on',1);
        $this->display();
    }
    public function anli()
    {
        $this->assign('on',1);
        $this->display();
    }
    public function qiyetuiguang()
    {
        $this->assign('on',1);
        $this->display();
    }
    public function weibo_gaishu()
    {
        $this->assign('on',2);
        $this->display();
    }
    public function zhuanqian()
    {
        $this->assign('on',2);
        $this->display();
    }
    public function bozhu()
    {
        $this->assign('on',2);
        $this->display();
    }
    public function weibo_jiedan()
    {
        $this->assign('on',2);
        $this->display();
    }
    public function anli_2()
    {
        $this->assign('on',3);
        $this->display();
    }
    public function guanyu()
    {
        $this->assign('on',4);
        $this->display();
    }
    public function guanli()
    {
        $this->assign('on',4);
        $this->display();
    }
    public function wenhua()
    {
        $this->assign('on',4);
        $this->display();
    }
    public function zhaoren()
    {
        $this->assign('on',4);
        $this->display();
    }
    public function lianxi()
    {
        $this->assign('on',4);
        $this->display();
    }
    public function article()
    {
        $this->display();
    }
    public function industry()
    {
        $article = M('article');
        $data['type']=1;
        $d['article_id'] = $_GET['article_id'];
        $list =$article->field('article_id,name')->where($data)->order('article_id desc')->select();
        if ($d['article_id'])
            $info=$article->where($d)->find();
        else
            $info =$article->where($data)->order('article_id desc')->find();
        $this->assign('list',$list);
        $this->assign('info',$info);
        $this->assign('industry',U('index/industry'));
        $this->display();
    }
    public function about()
    {
        $article = M('article');
        $data['type']=3;
        $d['article_id'] = $_GET['article_id'];
        $list =$article->field('article_id,name')->where($data)->order('article_id desc')->select();
        if ($d['article_id'])
            $info=$article->where($d)->find();
        else
            $info =$article->where($data)->order('article_id desc')->find();
        $this->assign('list',$list);
        $this->assign('info',$info);
        $this->assign('about',U('index/about'));
        $this->assign('register',U('index/register'));
        $this->display();
    }
    public function help()
    {
        $article = M('article');
        $data['type']=2;
        $d['article_id'] = $_GET['article_id'];
        $list =$article->field('article_id,name')->where($data)->order('article_id desc')->select();
        if ($d['article_id'])
            $info=$article->where($d)->find();
        else
            $info =$article->where($data)->order('article_id desc')->find();
        $this->assign('list',$list);
        $this->assign('info',$info);
        $this->assign('help',U('index/help'));
        $this->assign('register',U('index/register'));
        $this->display();
    }
    public function video()
    {
        $article = M('article');
        $data['type']=4;
        $d['article_id'] = $_GET['article_id'];
        $list =$article->field('article_id,name')->where($data)->order('article_id desc')->select();
        if ($d['article_id'])
            $info=$article->where($d)->find();
        else
            $info =$article->where($data)->order('article_id desc')->find();
        $this->assign('list',$list);
        $this->assign('info',$info);
        $this->assign('video',U('index/video'));
        $this->assign('register',U('index/register'));
        $this->display();
    }

    //跳转
    public function jump()
    {
        if(isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])){
            $urlModel = M("url");
            $data['task_id'] = $_REQUEST['id'];
            $rs = $urlModel->field('jump_url')->where($data)->find();
            if($rs['jump_url']){
                $ip = $_SERVER['REMOTE_ADDR'];
                $blog_id = 0;
                if(isset($_REQUEST['blog_id']) && is_numeric(($_REQUEST['blog_id']))){
                    $blog_id = $_REQUEST['blog_id'];
                }
                if($ip && $blog_id){
                    $clickLogModel = M("click_log");
                    $clickLogData = array(
                        'task_id' => $data['task_id'],
                        'blog_id' => $blog_id,
                        'logtime' => time(),
                        'ip' => $ip,
                    );
                    $clickLogModel->add($clickLogData);
                }
                header("Location:{$rs['jump_url']}");
                exit();
            }
        }
    }
}

?> 