<?php
!function_exists('html') && exit('ERR');
unset($name,$uid,$email);
list($name,$uid,$email)=explode("\t",mymd5($eid,'DE') );
if($name&&$uid&&$email){
	
	$rsdb=$userDB->get_info($uid);
	if($rsdb[email_yz]==1){
		showerr("请不要重复验证");
	}elseif($rsdb){
		$array=array(
			'username'=>$name,
			'uid'=>$uid,
			'email_yz'=>1,
			'email'=>$email
		);
		$userDB->edit_user($array);
		add_user($rsdb[uid],$webdb[YZ_EmailMoney],'邮箱审核奖分');
		refreshto("$webdb[www_url]/","恭喜你!邮箱验证成功,同时你的{$webdb[MoneyName]}增加了{$webdb[YZ_EmailMoney]}{$webdb[MoneyDW]}",3);
	}else{
		showerr("邮箱验证失败,可能当前帐号已被删除!");
	}
}else{
	showerr("验证失败!");
}
?>