<?php

class dinnermViewModel extends ViewModel
{
    public $viewFields = array(
        'company_dinner'=>array('cdinner_id','name','begintime','content','pay_state','addtime','state','operator','url','s_time','_type'=>'LEFT','_as'=>'cd'),
        'dinner'=>array('platform','name'=>'type','content'=>'remark','money','_as'=>'d','_type'=>'LEFT','_on'=>'cd.dinner_id=d.dinner_id'),
        'company_member'=>array('member_id','realname','_as'=>'cm','_on'=>'cm.member_id=cd.member_id')
    );
}

?> 