<?php

class hblogViewModel extends ViewModel
{
    public $viewFields = array(
        'blog'=>array('reject','image','week_order','month_order','zp_rate','to_sex','location','sex','platform','verifyinfo','blog_id','nick','fansnum','com_money','com_pmoney','weibo','keywords','hots','_as'=>'b','_type'=>'LEFT'),
        'blog_block'=>array('_type'=>'LEFT','_as'=>'bb','_on'=>'bb.blog_id=b.blog_id'),
        'blog_fav'=>array('bfav_id','_type'=>'LEFT','_as'=>'bf','_on'=>'bf.blog_id=b.blog_id'),
        'task_blog'=>array('_on'=>'tb.blog_id=b.blog_id','_as'=>'tb')
    );
}

?> 