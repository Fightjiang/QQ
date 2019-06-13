<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController{

    public function index(){    

    	$friend=M('friend');
    	$id1=$friend->query("select fid2name,fid2 from friend where fid1=%d",$_SESSION['id']);
    	$count1=count($id1);
        for($i=0;$i<$count1;$i++){
        	$id[$i]['id']=$id1[$i]['fid2'];
			$id[$i]['friend']=$id1[$i]['fid2name']; 
		}

		array_multisort(array_column($id,'id'),SORT_ASC,$id) ; // 按照 id 升序排列

        $this->id=$id;  
		$this->count=$count1;
		
		$this->display();
	}
	

    public function setfriend(){
    	if(IS_POST){
    		$New=M('news');   		
    		$data=$New->query("select flag,info,fid1,time from news where fid1=%d and fid2=%d or fid1=%d and fid2=%d",$_SESSION['id'],$_POST['fid'],$_POST['fid'],$_SESSION['id']);    		
			
			array_multisort(array_column($data,'time'),SORT_ASC,$id) ; // 按照 id 升序排列,消息先后顺序
			
			$_SESSION['fid']=$_POST['fid'];
			
			$this->ajaxReturn($data);
			
    	}else{
    		$this->error('非法操作');
    	}
	}
	

    public function info(){
    	if(IS_POST){  
			/*
    		$friend=M('friend');
    		$flag=$friend->query("select flag,id from friend where fid1=%d and fid2=%d or fid1=%d and fid2=%d",$_SESSION['id'],$_SESSION['fid'],$_SESSION['fid'],$_SESSION['id']);
			$flag[0]['flag'] = $flag[0]['flag'] + 1;
			var_dump($flag) ; 
    		$da['flag']=$flag[0]['flag'];
			$friend->where("id=%d",$flag[0]['id'])->save($da);  
			*/

			$New=M('news');
			$flag = $New->query("select flag from news where fid1=%d and fid2=%d",$_SESSION['id'],$_SESSION['fid']) ; 
			$count = count($flag) ; 
			$fg = $flag[$count-1]['flag'] + 1 ;

    		/*if($flag[0]['flag']>10){ 删除历史消息，暂定。
    			//删除一条消息
    			$fg = $flag[0]['flag']-10;
    			$New->where("fid1=%d and fid2=%d and flag=%d",$_SESSION['id'],$_SESSION['fid'],$fg)->delete();
    			
			}
			*/

    		$data['fid1'] = $_SESSION['id'];
    		$data['fid2'] = $_SESSION['fid'];
    		$data['flag'] = $fg  ; 
    		$data['info'] = $_POST['info'];
    		$data['time'] = date('Y-m-d H:i',time());
    		$New->field('fid1,fid2,flag,time,info')->add($data);
    		echo "true";
    	}else{
    		$this->error('非法操作');
		}
	}
	
    public function remove(){
    	if(IS_POST){

    		$friend=M('friend');    		
    		$friend->where("fid1=%d and fid2=%d or fid1=%d and fid2=%d",$_SESSION['id'],$_POST['did'],$_POST['did'],$_SESSION['id'])->delete();    		
    		$New=M('news');
    		$New->where("fid1=%d and fid2=%d or fid1=%d and fid2=%d",$_SESSION['id'],$_POST['did'],$_POST['did'],$_SESSION['id'])->delete();    		
    		echo "true";
		
		}else{
    		$this->error('非法操作');
    	}
	}
	
    public function selectfriend(){
    	if(IS_POST){
    		$User=M('user');    		
    		$data=$User->field('id,username')->where("username='%s'",$_POST['name'])->select();
    		if(!empty($data)){
    			$this->ajaxReturn($data);
    		}else{
    			echo "no";
    		}
    	}else{
    		$this->error('非法操作');
    	}
	}
	
    public function addfriend(){
    	if(IS_POST){

    		$friend=M('friend');
    		$data['fid1']=$_SESSION['id'];
    		$data['fid1name']=$_SESSION['username'];
    		$data['fid2']=$_POST['fid2'];
    		$data['fid2name']=$_POST['fid2name'];
			$friend->add($data);	

			$data['fid1'] = $_POST['fid2'];
    		$data['fid1name'] = $_POST['fid2name'];
    		$data['fid2'] = $_SESSION['id'];
    		$data['fid2name'] = $_SESSION['username'];
			$friend->add($data);
			echo "true";
			
    	}else{
    		$this->error('非法操作');
    	}
    }   
}