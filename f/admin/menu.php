<?php

return array(
'相关参数设置'=>array('power'=>'center_config','link'=>'file=center&job=post'),
'城市地区管理'=>array('power'=>'city','link'=>'file=city&job=city'),
'伪静态设置'=>array('power'=>'center_html','link'=>'file=center&job=html'),
'审核过滤设置'=>array('power'=>'autopass','link'=>'file=autopass&job=set'),

'内容管理'=>array('power'=>'list','link'=>'file=list&job=list','sort'=>'内容相关'),
'定时刷新管理'=>array('power'=>'refurbish','link'=>'file=refurbish&job=list','sort'=>'内容相关'),
'评论管理'=>array('power'=>'comment','link'=>'file=comment&job=list','sort'=>'内容相关'),
'点评管理'=>array('power'=>'dianping','link'=>'file=dianping&job=list','sort'=>'内容相关'),
'栏目管理'=>array('power'=>'sort','link'=>'file=sort&job=listsort','sort'=>'内容相关'),
'模型管理'=>array('power'=>'module','link'=>'file=module&job=listsort','sort'=>'内容相关'),
'举报信息管理'=>array('power'=>'report','link'=>'file=report&job=list','sort'=>'内容相关'),
'多城市友情链接'=>array('power'=>'friendlink','link'=>'file=friendlink&job=list','sort'=>'内容相关'),

'更新首页标签'=>array('power'=>'center_label','link'=>'file=center&job=label','sort'=>'页面显示'),
'首页分类布局设置'=>array('power'=>'center_settable','link'=>'file=center&job=settable','sort'=>'页面显示'),
'页面设置'=>array('power'=>'center_settpl','link'=>'file=center&job=settpl','sort'=>'页面显示'),

'联级字段管理'=>array('power'=>'fieldsort','link'=>'file=fieldsort&job=listsort&type=all','sort'=>'插件功能'),
'字符批量替换'=>array('power'=>'replace','link'=>'file=replace&job=list','sort'=>'插件功能'),
);

?>