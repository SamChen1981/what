<?php
//mark
class blogViewModel extends ViewModel
{
    public $viewFields = array(
        'blog'=>array('blog_id','name','weibo','com_money','com_pmoney','keywords','platform','fansnum','hots','verifyinfo','_type'=>'LEFT','_as'=>'b'),
        'blog_fav'=>array('bfav_id','_as'=>'bf','_type'=>'LEFT','_on'=>'b.blog_id=bf.blog_id'),
        'blog_block'=>array('_as'=>'bb','_on'=>'b.blog_id=bb.blog_id'),
    );
}

?> 