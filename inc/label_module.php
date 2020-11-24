<?php
require_once(ROOT_PATH."inc/label_funcation.php");
require_once(ROOT_PATH."inc/label_module_inc.php");

//目的是为了兼容其它频道模型
if(!function_exists('getTpl')){
	function getTpl($a,$b){
		return html($a,$b);
	}
}

/**
*获取模板所有的标签
**/
unset($haveCache,$all_label);
if($jobs=='show')
{
	if(!$_COOKIE[Admin]&&!$web_admin)
	{
		showerr("你无权查看");
	}
	//获取头与尾的标签
	preg_replace('/\$label\[([\'a-zA-Z0-9\_]+)\]/eis',"label_array_hf('\\1')",read_file(getTpl("head",$head_tpl)));
	preg_replace('/\$label\[([\'a-zA-Z0-9\_]+)\]/eis',"label_array_hf('\\1')",read_file(getTpl("foot",$foot_tpl)));
	
	//$label_hf为头部的检索数组,检查头部有多少个标签
	
	is_array($label_hf) || $label_hf=array();
	foreach($label_hf AS $key=>$value)
	{
		$rs=$db->get_one("SELECT * FROM {$pre}label WHERE tag='$key' AND chtype='99'");

		if($rs[tag])
		{
			$divdb=unserialize($rs[divcode]);
			$label[$key]=add_div($label[$key]?$label[$key]:'&nbsp;',$rs[tag],$rs[type],$divdb[div_w],$divdb[div_h],$divdb[div_bgcolor],'99');
		}
		else
		{
			$label[$key] || $label[$key]=add_div("新标签,无内容",$key,'NewTag','','','','99');
		}
	}	
}
else
{
	$FileName=ROOT_PATH."cache/label_cache/";
	if(!is_dir($FileName)){
		makepath($FileName);
	}
	$FileName.=(ereg("\.php",basename($WEBURL))?preg_replace("/\.php(.*)/","",basename($WEBURL)):'index')."_".intval($ch)."_".intval($ch_pagetype)."_".intval($ch_module)."_".intval($ch_fid)."_".intval($city_id).'_'.substr(md5(getTpl("index",$chdb[main_tpl])),0,5).".php";
	
	//默认缓存3分钟.
	if(!$webdb[label_cache_time]){
		$webdb[label_cache_time]=3;
	}
	if( (time()-filemtime($FileName))<($webdb[label_cache_time]*60) ){
		@include($FileName);
	}
}

if(!$haveCache){

	//获取内容页的标签
	preg_replace('/\$label\[([\'a-zA-Z0-9\_]+)\]/eis',"label_array('\\1')",read_file(getTpl("index",$chdb[main_tpl])));

	unset($label_rubbish);
	//屏蔽了错误.考虑到有时切换其他系统的时候SQL语句有错
	$query=$db->query("SELECT * FROM {$pre}label WHERE pagetype='$ch_pagetype' AND module='$ch_module' AND fid='$ch_fid' AND chtype='0'");
	while( $rs=$db->fetch_array($query) ){
		
		//读数据库的标签
		if( $rs[typesystem] )
		{
			if( !is_array($label["$rs[tag]"]) ){
				$label_rubbish[$rs[lid]]=$rs[tag];	//多余的旧标签,做个提示	
				continue;	//页面没有的标签.就不要读数据库
			}

			$_array=unserialize($rs[code]);

			if($_array[SYS]=='artcile'){
				$_array[sql]=preg_replace("/ORDER BY A.aid/is","ORDER BY A.list",$_array[sql]);
				//速度优化考虑,不使用缓存,就忽略速度
				//$webdb[label_cache_time]=='-1' || $_array[sql]=preg_replace("/AND R.topic=1/is","",$_array[sql]);				
			}

			$value=($rs[type]=='special')?Get_sp($_array):Get_Title($_array);
			if(strstr($value,"(/mv)")){
				$value=get_label_mv($value);
			}
			if($_array[c_rolltype])
			{
				$value="<marquee direction='$_array[c_rolltype]' scrolldelay='1' scrollamount='1' onmouseout='if(document.all!=null){this.start()}' onmouseover='if(document.all!=null){this.stop()}' height='$_array[roll_height]'>$value</marquee>";
			}
		}
		//代码标签
		elseif( $rs[type]=='code' )
		{
			$value=get_label_code($rs);

			//纠正一下不完整的javascript代码,不必做权限判断,普通用户也能删除
			if(eregi("<SCRIPT",$value)&&!eregi("<\/SCRIPT",$value)){
				if($delerror){
					$db->query("UPDATE `{$pre}label` SET code='' WHERE lid='$rs[lid]'");
				}else{
					die("<A HREF='$WEBURL?&delerror=1'>此“{$rs[tag]}”标签有误,点击删除之!</A><br>$value");
				}			
			}
			//真实地址还原
			$value=En_TruePath($value,0);
		}
		//单张图片
		elseif( $rs[type]=='pic' )
		{	
			unset($width,$height);
			$picdb=get_label_pic($rs);
			
			$picdb[width] && $width=" width='$picdb[width]'";
			$picdb[height] && $height=" height='$picdb[height]'";
			$picdb[imgurl]=En_TruePath($picdb[imgurl],0);
			$picdb[imglink]=En_TruePath($picdb[imglink],0);
			$picdb[imgurl]=tempdir($picdb[imgurl]);
			if($picdb['imglink'])
			{
				$value="<a href='$picdb[imglink]' target=_blank><img src='$picdb[imgurl]' $width $height border='0' /></a>";
			}
			else
			{
				$value="<img src='$picdb[imgurl]' $width $height  border='0' />";
			}
		}
		//单个FLASH
		elseif( $rs[type]=='swf' )
		{
			$flashdb=unserialize($rs[code]);
			$flashdb[flashurl]=En_TruePath($flashdb[flashurl],0);
			$flashdb[flashurl]=tempdir($flashdb[flashurl]);
			$flashdb[width] && $width=" width='$flashdb[width]'";
			$flashdb[height] && $height=" height='$flashdb[height]'";
			$value="<object type='application/x-shockwave-flash' data='$flashdb[flashurl]' $width $height wmode='transparent'><param name='movie' value='$flashdb[flashurl]' /><param name='wmode' value='transparent' /></object>";
		}
		//普通幻灯片
		elseif( $rs[type]=='rollpic' )
		{
			$detail=get_label_rollpic($rs);

			foreach($detail[picurl] AS $key=>$value){
				$detail[picurl][$key]=En_TruePath($value,0);
			}
			foreach($detail[piclink] AS $key=>$value){
				$detail[piclink][$key]=En_TruePath($value,0);
			}
			if($detail[rolltype]==2){	//自定义样式
				unset($_listdb);
				foreach($detail[picurl] AS $key=>$value){
					$_listdb[]=array(
						'picurl'=>tempdir($value),
						'link'=>$detail[piclink][$key],
						'url'=>$detail[piclink][$key],
						'title'=>$detail[picalt][$key],
					  );
				}
				$_listdb[0][tpl_1code]=En_TruePath($detail[tplpart_1code],0);
				$value=run_label_php($_listdb);
			}elseif($detail[picalt][1]==''){	//没有标题的情况
				$value=rollPic_no_title_js($detail);
			}else{
				if($detail[rolltype]==1){
					$value=rollPic_flash($detail);
				}else{
					$value=rollpic_2js($detail);
				}
			}
			
		}
		//其它形式的
		else
		{
			$value=stripslashes($rs[code]);
			//真实地址还原
			$value=En_TruePath($value,0);
		}

		//更新标签时显示的页面
		if($jobs=='show')
		{
			if(!$value)
			{
				$value='&nbsp;';
			}
			$divdb=unserialize($rs[divcode]);
			$value=add_div($value,$rs[tag],$rs[system_type]?$rs[system_type]:$rs[type],$divdb[div_w],$divdb[div_h],$divdb[div_bgcolor]);
		}
		//有些标签设置了暂时隐藏
		elseif($rs[hide])
		{
			$value='';
		}
		$label[$rs[tag]]=$value;
	}
}


/**
*后台更新标签
**/
if($jobs=='show')
{
	unlink($FileName);	//把缓存文件删除掉,前台重新载入新资料

	if($label_rubbish){
		if($delete_label_rubbish){
			//$db->query("DELETE FROM {$pre}label WHERE tag IN ('".implode("','",$label_rubbish)."')");
		}else{
			//echo "<CENTER><br><br>提醒:::<A HREF='$WEBURL&delete_label_rubbish=1'>有 ".count($label_rubbish)." 个冗余的标签,你是否要删除它,点击即可删除:".implode(",",$label_rubbish)."</A><br><br><br><br></CENTER>";
		}		
	}
	$label || $label=array();
	foreach($label AS $key=>$value)
	{
		//如果是旧标签的话.$value已经是具体数值了,或者为空了,而不是数组
		if(is_array($value))
		{
			$label[$key]=add_div("新标签,内容暂无:$key",$key,'NewTag');
		}
	}

	//$all_label在函数label_array()label_array_hf()中统计所有有效的标签
	$fromurl=urlencode($WEBURL);
	$label[$all_label[0]]="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/images/default/label_jq.js'></SCRIPT><SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/images/default/label.js'></SCRIPT><SCRIPT LANGUAGE='JavaScript'>
	\$(document).ready(function(){ \$('.p8label').each(function(){ \$(this).hover(function(){ \$(this).css({'opacity':'0.8','filter':'alpha(opacity=70)'});}, function(){ \$(this).css({'opacity':'0.4','filter':'alpha(opacity=50)'});}).jqResize(\$('div', this))});});
	var admin_url='$webdb[admin_url]';var ch='$ch';var ch_fid='$ch_fid';var ch_pagetype='$ch_pagetype';var ch_module='$ch_module';var fromurl='$fromurl';var mystyle='$STYLE';</SCRIPT>{$label[$all_label[0]]}";

}
else
{
	foreach($label AS $key=>$value)
	{
		//如果是新标签时,即为数组array(),要清空
		if(is_array($value))
		{
			$label[$key]='';
		}
	}
	//写缓存
	if( (time()-filemtime($FileName))>($webdb[label_cache_time]*60) ){
		$_shows="<?php\r\n\$haveCache=1;\r\n";
		foreach($label AS $key=>$value){
			$value=addslashes($value);
			$_shows.="\$label['$key']=stripslashes('$value');\r\n";
		}
		write_file($FileName,$_shows.'?>');
	}	
}
?>