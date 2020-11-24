<?php
require_once(dirname(__FILE__)."/global.php");
require_once(dirname(__FILE__)."/../inc/homepage/global.php");
require_once(dirname(__FILE__)."/../bd_pics.php");


if(!$uid){
	$uid=$lfjuid;
}
if(!$web_admin && $uid!=$lfjuid ){
	showerr("UID有误!");
}

$post_company=1;//模板那里使用,使得类目选择时可以多选
$lfjdb[money]=get_money($lfjuid);
//$groupdb['allow_get_homepage']=1;	//可以控制哪些用户组可以申请商铺

$companyDB=$db->get_one("SELECT * FROM `{$_pre}company` WHERE uid='$uid'");

if($action!='ok'){
	if($companyDB['yz']){
		//有商铺主页的,就不允许再访问此页,没商铺的话,就可以在本页申请商铺
		if( $db->get_one("SELECT * FROM `{$_pre}home` WHERE uid='$companyDB[uid]'") ){
			if($job=='view'){
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$webdb[www_url]/home/?uid=$uid'>";
			}else{
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=homepage_ctrl.php?atn=info&uid=$uid'>";
			}			
			exit;
		}
	}elseif($companyDB && $job!='view'){
		showerr('你的企业资料正在审核当中,请耐心等候!');
	}
}

if($action=='apply'){	//通过审核的企业用户,申请商铺,直接激活
	
	if(!$companyDB){
		showerr("<A HREF='post_company.php'>个人用户不能申请商铺,请先登记企业信息,先申请成为企业用户,再来申请商铺!</A>");
	}
	if(!$web_admin){
		if(!$groupdb['allow_get_homepage']){
			showerr("很抱歉,你所在用户组不能申请企业商铺,你要申请企业商铺,请先升级你的用户组,<A HREF='$webdb[www_url]/member/buygroup.php?job=list'>升级你的用户组</A>");
		}elseif($lfjdb[money]<$webdb[creat_home_money]){
			showerr("很抱歉,你不能申请企业商铺,因为创建企业商铺需要{$webdb[MoneyName]}{$webdb[creat_home_money]}{$webdb[MoneyDW]},而你的{$webdb[MoneyName]}仅有{$lfjdb[money]}{$webdb[MoneyDW]}<br>你可以选择在线充值来增加你的{$webdb[MoneyName]},<A HREF='$webdb[www_url]/member/money.php?job=list'>立即充值</A>");
		}
	}

	if($webdb[creat_home_money]){
		add_user($uid,-abs($webdb[creat_home_money]),'创建店铺扣分');
	}

	caretehomepage($companyDB,false);
	refreshto("?action=ok","",0);

}elseif($action=='add'||$action=='edit'){
	
	$action=$companyDB?'edit':'add';	//防止窜改

	if($postdb['if_homepage']&&!$web_admin){
		if(!$groupdb['allow_get_homepage']){
			showerr_post("很抱歉,你所在用户组不能申请商铺,你要申请商铺,请先升级你的用户组");
		}elseif($lfjdb[money]<$webdb[creat_home_money]){
			showerr_post("很抱歉,你不能申请商铺,因为创建商铺需要{$webdb[MoneyName]}{$webdb[creat_home_money]}{$webdb[MoneyDW]},而你的{$webdb[MoneyName]}仅有{$lfjdb[money]}{$webdb[MoneyDW]}<br>你可以选择在线充值来增加你的{$webdb[MoneyName]}");
		}		
	}


	if(count($fids)<1)showerr_post("请至少选择一个主营分类!");
	
	//插入分类表
	$ifids = $fnamedb = array();
	foreach($fids AS $key){
		$key = intval($key);
		if($key){
			$ifids[] = $key;
			$fnamedb[]=$Fid_db['name'][$key];
		}
	}
	$fname=implode(',',$fnamedb);

	if(!$postdb[city_id]) showerr_post("请选择所在城市区域!");
	if(!$postdb[title]) showerr_post("请输入公司全称");
	if(strlen($postdb[title])<10){
		showerr_post("公司全称小于5个字不规范!");
	}
	if(eregi("^([a-z0-9]+)$",$postdb[title])){
		//showerr_post("公司名称不规范!");
	}
	if(!$postdb[qy_regmoney]) showerr_post("请输入公司注册资本");
	if(!$postdb[content]) showerr_post("商家介绍不能为空");
	if(!$postdb[qy_contact_tel]) showerr_post("指定联系人电话不能为空");
	if(!$postdb[qy_contact]) showerr_post("指定联系人不能为空");
	if(!$postdb[qy_contact_email]) showerr_post("指定联系人邮箱地址不能为空");

	foreach($postdb AS $key=>$val){	//全部数据过滤处理
		if($key == 'content'){
			$postdb[$key]	=	preg_replace('/javascript/i','java script',$postdb[$key]);
			$postdb[$key]	=	preg_replace('/<(script)([^<>]*)>/i','&lt;\\1\\2>',$postdb[$key]);
			$postdb[$key]	=	preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$postdb[$key]);
		}else{
			$postdb[$key]=filtrate($val);
		}
	}

	if(!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$postdb[qy_contact_email])){
		showerr_post('邮箱不符合规则');
	}

	if($postdb[qy_regmoney]<3){
		showerr_post('注册资本不能小于3万');
	}

	if($postdb[qy_website]&&!ereg("^http:",$postdb[qy_website])){
		showerr_post('网址有误');
	}

	//图片处理
	if(is_uploaded_file($_FILES[postfile][tmp_name])){
		if($action=='edit'){
			delete_attachment($uid,tempdir($companyDB[picurl]));
		}
		$array[name]=is_array($postfile)?$_FILES[postfile][name]:$postfile_name;
		$dirid=ceil($uid/1000);
		$array[path]=$webdb[updir]."/homepage/logo/$dirid/";
				
		$array[size]=is_array($postfile)?$_FILES[postfile][size]:$postfile_size;
		$pic_name=upfile(is_array($postfile)?$_FILES[postfile][tmp_name]:$postfile,$array);
		
		$picurl="homepage/logo/$dirid/{$pic_name}";

		$sizedb=getimagesize(ROOT_PATH."$array[path]/$pic_name");

		if($sizedb[0]>300||$sizedb[1]>300){
			$Newpicpath=ROOT_PATH."$array[path]/logo_{$pic_name}";
			gdpic(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath,300,225);
			gdpic(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath.".jpg",225,300);
			gdpic(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath.".jpg.jpg",300,300);
			gdpic(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath.".jpg.jpg.jpg",300,100);
			if(file_exists($Newpicpath)){
				delete_attachment($uid,tempdir("homepage/logo/$dirid/{$pic_name}"));
				$picurl="homepage/logo/$dirid/logo_{$pic_name}";
			}
		}else{
			$Newpicpath=ROOT_PATH."$array[path]/{$pic_name}";
			copy(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath.".jpg");
			copy(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath.".jpg.jpg");
			copy(ROOT_PATH."$array[path]/{$pic_name}",$Newpicpath.".jpg.jpg.jpg");
		}
		
	}else{
		$picurl=$companyDB[picurl];
	}

	if($action=='edit'){	//先删除,方便再做新插入
		$db->query("DELETE FROM {$_pre}company WHERE uid='$companyDB[uid]'");
		$db->query("DELETE FROM {$_pre}company_fid WHERE uid='$companyDB[uid]'");
		$yz = $companyDB['yz'];
		$username = $companyDB['username'];
		$posttime = $companyDB['posttime'];
	}else{
		$SQL = "";
		if($webdb['RegQyNeedCheck']){ //注册成为企业会员,需要人工审核
			$gtype = -1;
			$yz = 0;
		}else{
			$yz = 1;
			$gtype = 1;
			$groupid = $webdb['RegQyGroupid'];
			if($ltitle[$groupid] && $groupid!=3){
				$SQL = ",groupid='$groupid'";
			}
		}
		$db->query("UPDATE {$pre}memberdata SET grouptype='$gtype'$SQL WHERE uid='$uid'");
		$username = $lfjid;
		$posttime = $timestamp;
	}
	
	
	$db->query("INSERT INTO `{$_pre}company` ( `title` , `fname` , `uid` , `username` , `posttime` , `picurl` , `yz` , `yzer` , `yztime` , `content` , `province_id` , `city_id` ,`zone_id` ,`street_id` , `qy_cate` , `qy_saletype` , `qy_regmoney` , `qy_createtime` , `qy_regplace` , `qy_address` , `qy_postnum` , `qy_pro_ser` , `my_buy` , `my_trade` , `qy_contact`,`qy_contact_zhiwei` , `qy_contact_sex` , `qy_contact_tel` , `qy_contact_mobile` , `qy_contact_fax` , `qy_contact_email` , `qy_website` , `qq` , `msn` , `skype`, `if_homepage` ) VALUES (  '$postdb[title]', '$fname', '$uid', '$username', '$posttime','$picurl', '$yz', '$companyDB[yzer]', '$companyDB[yztime]', '$postdb[content]', '$postdb[province_id]', '$postdb[city_id]','$postdb[zone_id]','$postdb[street_id]', '$postdb[qy_cate]', '$postdb[qy_saletype]', '$postdb[qy_regmoney]', '$postdb[qy_createtime]', '$postdb[qy_regplace]', '$postdb[qy_address]', '$postdb[qy_postnum]', '$postdb[qy_pro_ser]', '$postdb[my_buy]', '$postdb[my_trade]', '$postdb[qy_contact]', '$postdb[qy_contact_zhiwei]', '$postdb[qy_contact_sex]', '$postdb[qy_contact_tel]', '$postdb[qy_contact_mobile]', '$postdb[qy_contact_fax]', '$postdb[qy_contact_email]', '$postdb[qy_website]', '$postdb[qq]', '$postdb[msn]', '$postdb[skype]', '$postdb[if_homepage]');");
	
	foreach($ifids AS $v){
		$db->query("INSERT INTO {$_pre}company_fid (uid, fid) VALUES ($uid, $v)");
	}

	//申请主页
	if($postdb['if_homepage']){
		if(!$web_admin&&$webdb['creat_home_money']){
			add_user($lfjuid,-abs($webdb['creat_home_money']),'创建商铺扣分');
		}
		//初始化主页
		caretehomepage($db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid'"),false);
	}
	
	if($job=='apply' && $webdb['postSellHouseNeedQy'] && $webdb['webmail'] ){
		$title = "有新的企业用户“{$lfjid}”注册了!";
		$content = "<A HREF='$webdb[www_url]'>你网站有新企业用户“{$postdb[title]}”注册了!</A>";
		send_mail($webdb['webmail'],$title,$content,$ifcheck=0);
	}

	if( $action=='add' || $postdb['if_homepage'] ){
		parent_goto("?action=ok");
	}else{
		parent_goto("?job=view&uid=$uid");
	}
}elseif($action=='ok'){
	
	if($companyDB['yz']){
		if($companyDB['if_homepage']){
			$msg="恭喜您，商铺申请成功啦!";
			$do[0]['text']="点击查看商铺详情";
			$do[0]['target']=" target=_blank";
			$do[0]['link']="$webdb[www_url]/home/?uid=$uid";
		}else{
			$msg="恭喜您，企业用户申请成功啦!";
			$do[0]['text']="点击查看企业信息";
			$do[0]['link']="?job=view";
		}		
	}else{
		$msg="资料已成功提交,我们会尽快给符合条件的商家通过审核并与之联系,请耐心等候!";
	}

}elseif($job=='view'){

	$rsdb =& $companyDB;
	if(!$rsdb){
		showerr("企业信息不存在!");
	}
	$rsdb[picurl]=tempdir($rsdb[picurl]);
	@include(ROOT_PATH."data/zone/$rsdb[city_id].php");

}else{
	
	$rsdb =& $companyDB;
	if($rsdb){
		
		$do_type='edit';
		$rsdb[_my_trade][$rsdb[my_trade]]=' selected ';
		$rsdb[_qy_cate][$rsdb[qy_cate]]=' selected ';
		$rsdb[_qy_saletype][$rsdb[qy_saletype]]=' selected ';
		$fids = array();
		$query = $db->query("SELECT fid FROM `{$_pre}company_fid` WHERE uid = {$rsdb['uid']}");		
		while($arr = $db->fetch_array($query)) $fids[] = $arr['fid'];

	}else{

		$do_type='add';
		if($job=='apply'){	//新注册时,申请企业用户,传递过来的一些参数
			foreach($CP AS $key=>$value){
				$rsdb[$key] = filtrate($value);
			}
			$rsdb['city_id'] = $city_id;
		}else{
			if($webdb['ForbidUpHy']&&$lfjdb[grouptype]==0){
				showerr('系统禁止普通会员升级为企业会员!');
			}
		}		
	}
	$webdb[maxCompanyFidNum]=$webdb[maxCompanyFidNum]?$webdb[maxCompanyFidNum]:10;

}





$member_style=$webdb[sys_member_style]?$webdb[sys_member_style]:"images2";

$if_homepage=(($companyDB&&$job!='apply')||(!$web_admin&&($lfjdb[money]<$webdb[creat_home_money]||!$groupdb['allow_get_homepage'])))?'':' checked ';

require(dirname(__FILE__)."/head.php");
require(dirname(__FILE__)."/template/post_company.htm");
require(dirname(__FILE__)."/foot.php");



function showerr_post($msg,$html_id=''){
		echo "<SCRIPT LANGUAGE=\"JavaScript\">
			<!--
			alert(\"$msg\");
			parent.document.getElementById('post_showmsg').innerHTML=\"<strong>$msg</strong>\";	
			parent.document.getElementById('postSubmit').disabled=false;	
			//-->
			</SCRIPT>";exit;
}


function parent_goto($url,$msg=''){

	echo "<SCRIPT LANGUAGE=\"JavaScript\">
			<!--
			";
	if($msg!=''){
		echo "alert('$msg');";
	}
	echo    "
			
			parent.location='$url';	
			parent.location.href='$url';	
		
			//-->
			</SCRIPT>";exit;
}

?>