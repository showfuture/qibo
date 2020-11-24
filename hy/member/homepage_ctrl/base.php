<?php
//更新公司模板

$style_level = @include(Mpath.'homepage_tpl/style_level.php');

unset($homepage_tpl);
if(is_dir($tpl_dir)){
	if ($handle = opendir($tpl_dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				
				@preg_match("/^self_([\d]+)$/",$file,$array);
				if($array[1]&&$array[1]!=$uid){
					continue;	//类似目录 self_3 后面的数字即是用户的UID,将是他的专用风格.
				}

				if(is_dir($tpl_dir.$file)){
					if(file_exists($tpl_dir.$file."/style.php")){
						@include($tpl_dir.$file."/style.php");
						$homepage_tpl[$file] || $homepage_tpl[$file] = $style_name;
					}
				}
			}
		}
	}
	closedir($handle);	
}else{
	showerr("网站风格目录有误，请联系管理员!");
}

$web_admin && $groupdb['useHomepageStyle']=$groupdb['useHomepage2Style']=1;

if(!$step){

	//商家配置文件
	$conf=$db->get_one("SELECT * FROM {$_pre}home WHERE uid='$uid'");

	//列表设置
	$conf[listnum]=unserialize($conf[listnum]);	

	unset($index_left,$index_left_hx,$index_right,$index_right_hx,$array_left,$array_right);

	//模块设置 left
	$conf[index_left]=explode(",",$conf[index_left]);
	foreach($conf[index_left] as $key){
		if($tpl_left[$key]){
			$index_left.="<option value='$key'>".$tpl_left[$key]."</option>";
			$array_left[$key]=$key;
		}
	}
	foreach($tpl_left as $key=>$val){
		if(!in_array($key,$array_left)){
			$index_left_hx.="<option value='$key'>$val</option>";
		}		
	}

	//模块设置 right
	$conf[index_right]=explode(",",$conf[index_right]);
	foreach($conf[index_right] as $key){
		if($tpl_right[$key]){
			$index_right.="<option value='$key' >".$tpl_right[$key]."</option>";
			$array_right[$key]=$key;
		}
	}
	foreach($tpl_right as $key=>$val){
		if(!in_array($key,$array_right)){
			$index_right_hx.="<option value='$key'>$val</option>";
		}
	}



	$bodytpl[$conf[bodytpl]]=" checked";
	//风格
	$homepage_style="default";
	if($conf[style] && is_dir($tpl_dir.$conf[style])) $homepage_style=$conf[style];



	//认证开放
	$renzheng_show[$conf[renzheng_show]]=" checked";
	
	//会员自定义菜单
	$head_menu=unserialize($conf[head_menu]);
	$array=$h_menu=array();
	foreach($head_menu AS $key=>$arr){
		$arr[ifshow] = ($arr[ifshow])? 'checked':'';
		$h_menu[$key]=$arr;
		$array[$arr[url]] = true;
	}

	//其一,方便新增功能时,自动增加新的可选菜单,其二,原菜单丢失时,也可方便补回
	$ar=require(Mpath."inc/homepage/menu.php");
	foreach($ar AS $arr){
		if(!$array[$arr[url]]){
			$h_menu[]=$arr;
		}
	}
	
	
}else{
	
	if($conf[style] && !is_dir($tpl_dir.$conf[style]))showerr('风格不存在!');
	//头部自定义导航
	$head_menu = array();
	arsort($conf[h_order]);
	foreach ($conf[h_order] as $key=>$val){
		if($conf[h_title][$key] && $conf[h_url][$key]){
			$head_menu[$key][title]=filtrate($conf[h_title][$key]);
			$head_menu[$key][url]=filtrate($conf[h_url][$key]);
			$head_menu[$key][order]=$conf[h_order][$key];
			$conf[h_ifshow][$key]=($conf[h_ifshow][$key])?1:0;
			$head_menu[$key][ifshow]=$conf[h_ifshow][$key];
		}
	}
	$head_menu = addslashes(serialize($head_menu));

	$conf[listnum]=addslashes(serialize($conf[listnum]));
	if(count($conf[index_left])<1){
		showerr("商铺左边栏目不能为空");
	}
	$conf[index_left]=implode(",",$conf[index_left]);
	if(count($conf[index_right])<1){
		showerr("商铺右边栏目不能为空");
	}
	$conf[index_right]=implode(",",$conf[index_right]);

	if(!$groupdb[useHomepageStyle] && in_array($conf[style],explode(',',$style_level[useHomepageStyle]))){
		showerr("这是VIP风格，你所在用户组无权使用！");
	}
	if(!$groupdb[useHomepage2Style] && in_array($conf[style],explode(',',$style_level[useHomepage2Style]))){
		showerr("这是钻石风格，你所在用户组无权使用！");
	}

	$db->query("UPDATE {$_pre}home SET
	`style`='$conf[style]',
	`head_menu`='$head_menu',
	`index_left`='$conf[index_left]',
	`index_right`='$conf[index_right]',
	`listnum`='$conf[listnum]',
	`bodytpl`='$conf[bodytpl]',
	renzheng_show='$conf[renzheng_show]'
	WHERE uid='$uid'");

	refreshto("?uid=$uid&atn=$atn","设置成功",1);
	
}
?>