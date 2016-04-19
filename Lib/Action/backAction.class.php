<?php

class backAction extends Action
{
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
    function setting($name,$file=false,$dir='web/')
    {
        $config = M('config');
        $data['name'] = $name;
        if ($this->isPost())
        {
            if ($file)
            {
                $info = $config->where($data)->getField('value');
                $info=unserialize($info);
                $_POST[$file]=$info[$file];
                if ($photo = upimage($dir))
                {
                    @unlink($info[$file]);
                    $_POST[$file] =$photo[0]['savename'];
                }
                unset($_POST['photo']);
            }
            $d['value'] = serialize($_POST);
            $info = $config->where($data)->save($d);
            if (!$info)
            {
                if (!$config->where($data)->find())
                {
                    $data['value']=$d['value'];
                    if (!$config->add($data)){
                        $this->assign('msg','抱歉！修改失败');
                        return ;
                    }
                }
            }
            $this->assign('msg','恭喜！修改成功');
        }
        $info = $config->where($data)->getField('value');
        $info=unserialize($info);
        $this->assign('info',$info);
    }
    function adminlog($act_name)
    {
        $log = M('admin_log');
        $data['admin_name'] = $_SESSION['username'];
        $data['ip'] = get_client_ip();
        $data['act_name'] = $act_name;
        $data['time'] = time();
        $log->add($data);
    }
}
?> 