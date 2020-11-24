<?php
!function_exists('html') && exit('ERR');
unset($menu_partDB,$menudb,$menu_partDB);
$base_menuName=array('base'=>'系统功能','member'=>'会员管理','module'=>'模块中心','other'=>'插件管理');

$menu_partDB = array(
	'base'=>array('核心设置','网站常用功能管理','数据库工具','菜单管理'),
	'article'=>array('文章基本功能','内容/栏目/评论管理','静态页生成管理','更新标签内容','专题管理','辅栏目管理'),
	'member'=>array('用户管理','权限管理'),
);

$menudb=array(
	'核心设置'=>array(
		'网站全局参数设置' => array('power'=>'center_config','link'=>'index.php?lfj=center&job=config'),
		'会员注册设置' => array('power'=>'user_reg','link'=>'index.php?lfj=center&job=user_reg'),
		'系统模块管理' => array('power'=>'module_list','link'=>'index.php?lfj=module&job=list'),		
		'插件管理' => array('power'=>'hack_list','link'=>'index.php?lfj=hack&job=list'),
		'整合外部论坛系统设置' => array('power'=>'blend_set','link'=>'index.php?lfj=blend&job=set'),

		'单篇文章独立页面管理' => array('power'=>'alonepage_list','link'=>'index.php?lfj=alonepage&job=list'),
	),
	'数据库工具'=>array(
		'备份数据库' => array('power'=>'mysql_out','link'=>'index.php?lfj=mysql&job=out'),
		'数据库还原' => array('power'=>'mysql_into','link'=>'index.php?lfj=mysql&job=into'),
		'删除备份数据' => array('power'=>'mysql_del','link'=>'index.php?lfj=mysql&job=del'),
		'数据库工具' => array('power'=>'mysql_sql','link'=>'index.php?lfj=mysql&job=sql'),
	),
	'菜单管理'=>array(
		'网站头部导航菜单设置' => array('power'=>'menu_list','link'=>'index.php?lfj=guidemenu&job=list'),
		'管理员后台菜单设置' => array('power'=>'adminmenu_list','link'=>'index.php?lfj=adminguidemenu&job=list'),
		'会员中心菜单设置' => array('power'=>'membermenu_list','link'=>'index.php?lfj=memberguidemenu&job=list'),
	),
	'用户管理'=>array(
		'用户资料管理' => array('power'=>'member_list','link'=>'index.php?lfj=member&job=list'),
		'企业资料管理' => array('power'=>'company_list','link'=>'index.php?lfj=company&job=list'),
		'用户资料字段管理' => array('power'=>'regfield','link'=>'index.php?lfj=regfield&job=editsort'),
		'添加新用户' => array('power'=>'member_addmember','link'=>'index.php?lfj=member&job=addmember'),
	),
	'权限管理'=>array(
		'前台权限管理' => array('power'=>'group_list','link'=>'index.php?lfj=group&job=list'),
		'后台权限管理' => array('power'=>'group_list_admin','link'=>'index.php?lfj=group&job=list_admin'),
		'添加用户组' => array('power'=>'group_add','link'=>'index.php?lfj=group&job=add'),
	),

);

if(!$ModuleDB['hy_']){	//没装黄页，就没有企业功能
	unset($menudb['用户管理']['企业资料管理']);
}

@include(ROOT_PATH."data/hack.php");

if($ForceEnter||$GLOBALS[ForceEnter]){

	//强制进后台
	foreach( $menu_partDB AS $key1=>$value1){
		if($key1=='base'){
			continue;
		}
		foreach( $value1 AS $key2=>$value2){
			$menu_partDB['base'][]=$value2;
		}
	}
}else{

	if(!table_field("{$pre}module",'ifsys')){
		$db->query("ALTER TABLE `{$pre}module` ADD `ifsys` TINYINT( 1 ) NOT NULL");
	}
	//模块
	$query = $db->query("SELECT * FROM {$pre}module WHERE type=2 AND ifclose=0 ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		if(!$rs['dirname']){
			continue;
		}
		if($rs['ifsys']){	//独立的顶部菜单
			$base_menuName[$rs['pre']]=$rs['name'];
			$menu_partDB[$rs['pre']][]=$rs['name'];
		}else{
			$menu_partDB['module'][]=$rs['name'];
		}		
		$menudb[$rs['name']]=@include(ROOT_PATH."$rs[dirname]/admin/menu.php");
		foreach($menudb[$rs['name']] AS $key=>$value){
			if(eregi('^file=',$menudb[$rs['name']][$key]['link'])){
				$menudb[$rs['name']][$key]['link']="index.php?lfj=module_admin&dirname=$rs[dirname]&".$menudb[$rs['name']][$key]['link'];

				if($menudb[$rs['name']][$key]['power']!=1){
					$menudb[$rs['name']][$key]['power']="Module_".$rs[pre].$menudb[$rs['name']][$key]['power'];					
				}
			}
			if($rs['ifsys']&&$value['sort']){
				$keyname=get_word($rs['name'],4,0).">{$value['sort']}";
				$menu_partDB[$rs['pre']][$keyname]=$keyname;
				$menudb[$keyname][$key]=$menudb[$rs['name']][$key];
				unset($menudb[$rs['name']][$key]);
				
			}
		}
	}
}



?>