<?php
namespace Home\Controller;
use Think\Controller;
class TestController extends Controller{
	// 调用控制器初始方法
    public function test(){
			$this->display() ; 
	}
}