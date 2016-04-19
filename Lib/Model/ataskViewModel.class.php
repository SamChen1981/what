<?php

class ataskViewModel extends ViewModel
{
    public $viewFields = array(
        'task'=>array('task_id','begintime','name','_type'=>'RIGHT','_as'=>'t'),
        'task_blog'=>array('tblog_id','url','reject','comment','_as'=>'tb','_on'=>'t.task_id=tb.task_id','_type'=>'LEFT'),
        'blog'=>array('name'=>'bname','money','_as'=>'b','_on'=>'b.blog_id=tb.blog_id'),
    );
}

?> 