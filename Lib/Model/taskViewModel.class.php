<?php

class taskViewModel extends ViewModel
{
    public $viewFields = array(
        'task'=>array('platform','begintime','content','consume','state','task_id','name','url','type','_type'=>'RIGHT','_as'=>'t'),
        'task_blog'=>array('sum(b.com_pmoney)'=>'com_pmoney','sum(b.com_money)'=>'com_money','_as'=>'tb','_on'=>'t.task_id=tb.task_id','_type'=>'LEFT'),
        'blog'=>array('_as'=>'b','_on'=>'b.blog_id=tb.blog_id')
    );
}

?> 