<?php

class favblogViewModel extends ViewModel
{
    public $viewFields = array(
        'blog_fav'=>array('_type'=>'LEFT','_as'=>'bf'),
        'blog'=>array('image','reject','week_order','month_order','zp_rate','to_sex','location','sex','platform','verifyinfo','blog_id','nick','fansnum','com_money','com_pmoney','weibo','keywords','hots','_as'=>'b','_on'=>'bf.blog_id=b.blog_id')
    );
}

?> 