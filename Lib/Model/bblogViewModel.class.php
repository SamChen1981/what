<?php

class bblogViewModel extends ViewModel
{
    public $viewFields = array(
        'blog_block'=>array('_type'=>'LEFT','_as'=>'bb'),
        'blog'=>array('image','week_order','month_order','zp_rate','to_sex','location','sex','platform','verifyinfo','blog_id','nick','fansnum','com_money','com_pmoney','weibo','keywords','hots','_as'=>'b','_on'=>'bb.blog_id=b.blog_id')
    );
}

?> 