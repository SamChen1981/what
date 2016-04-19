<?php

class btaskViewModel extends ViewModel
{
    public $viewFields = array(
        'task'=>array('platform','begintime','content','consume','state','task_id','name','url','type','_type'=>'RIGHT','_as'=>'t'),
        'task_blog'=>array('tblog_id'=>'oid','reject','_as'=>'tb','_on'=>'t.task_id=tb.task_id','_type'=>'LEFT'),
        'blog'=>array('name'=>'bname','money','publish_money','click_money','_as'=>'b','_on'=>'b.blog_id=tb.blog_id'),
    );
}

?> 