<?php

class PublicVarAction extends Action
{
    public function __construct()
    {
        $this->getVar();
    }
    public function getVar()
    {
        $this->assign('qqqq','我靠啊');
    }
}

?> 