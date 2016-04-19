<?php

class dinnercViewModel extends ViewModel
{
    public $viewFields = array(
        'company_dinner'=>array('cdinner_id','name','begintime','content','addtime','pay_state','_type'=>'LEFT','_as'=>'cd'),
        'dinner'=>array('dinner_id','platform','name'=>'type','money','_as'=>'d','_type'=>'LEFT','_on'=>'cd.dinner_id=d.dinner_id')
    );
}

?> 