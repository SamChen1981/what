<?php

class taskbViewModel extends ViewModel
{
    public $viewFields = array(
        'task_blog'=>array('tblog_id','reject','url','comment','_type'=>'LEFT','_as'=>'tb'),
        'blog'=>array('blog_id','weibo','nick','fansnum','image','com_pmoney','com_money','_as'=>'b','_on'=>'tb.blog_id=b.blog_id')
    );
}

?> 