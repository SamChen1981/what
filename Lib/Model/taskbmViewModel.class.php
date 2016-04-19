<?php

class taskbmViewModel extends ViewModel
{
    public $viewFields = array(
        'task_blog'=>array('_type'=>'LEFT','_as'=>'tb'),
        'blog'=>array('_as'=>'b','_on'=>'tb.blog_id=b.blog_id','_type'=>'LEFT'),
        'blog_member'=>array('phone','email','_as'=>'bm','_on'=>'bm.member_id=b.member_id'),
    );
}

?> 