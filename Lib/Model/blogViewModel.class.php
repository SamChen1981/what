<?php

class blogViewModel extends ViewModel
{
    public $viewFields = array(
        'blog'=>array('image','week_order','month_order','zp_rate','to_sex','location','sex','blog_id','nick',
            'weibo','com_money','com_pmoney','com_click','click_money','keywords','platform','fansnum','reject','hots',
'verifyinfo',
            '_type'=>'LEFT','_as'=>'b'),
        'blog_fav'=>array('bfav_id','_as'=>'bf','_type'=>'LEFT','_on'=>'b.blog_id=bf.blog_id'),
        'blog_block'=>array('_as'=>'bb','_on'=>'b.blog_id=bb.blog_id'),
    );
}

?> 