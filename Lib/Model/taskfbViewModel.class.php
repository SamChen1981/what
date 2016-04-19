<?php

class taskfbViewModel extends ViewModel
{
    public $viewFields = array(
        'task_blog'=>array('tblog_id','reject','url','comment','_type'=>'LEFT','_as'=>'tb'),
        'blog'=>array('blog_id','weibo','nick','fansnum','image','com_pmoney','com_money','_type'=>'LEFT','_as'=>'b','_on'=>'tb.blog_id=b.blog_id'),
        'blog_fav'=>array('bfav_id','_as'=>'bf','_on'=>'bf.blog_id=b.blog_id')
    );
}

?> 