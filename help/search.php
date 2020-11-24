<?php
require(dirname(__FILE__)."/"."global.php");

$GuideFid[$fid]=" > 内容搜索";

$type = filtrate($type);
$keyword = filtrate($keyword);

if($action=="search")
{
	if(!$lfjid)
	{
		showerr("请先登录");
	}

	$search_url = '';
	
	$keyword=trim($keyword);
	$keyword=str_replace("%",'\%',$keyword);
	$keyword=str_replace("_",'\_',$keyword);

	if(!$keyword)
	{
		showerr("关键字不能为空");
	}
	
	/*每页显示500条*/
	$rows=500;
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rows;

	/*没指定模块或模块辅信息表不存在时,将搜索所有信息*/
	if(!$mid||!is_table("{$_pre}content_$mid"))
	{
		if($type=="username")
		{
			$field="username";
		}
		else
		{
			$field="title";
		}

		/*分页*/
		$showpage=getpage("{$_pre}content","WHERE $field LIKE '%$keyword%'","?mid=$mid&keyword=$keyword&action=search&type=$type",$rows);

		$SQL="SELECT * FROM {$_pre}content WHERE $field LIKE '%$keyword%' LIMIT $min,$rows ";
	}
	else
	{
		if($type=="username"||$type=="title")
		{
			$field="A.$type";
		}
		elseif(table_field("{$_pre}content_$mid",$type))
		{
			$field="B.$type";
		}
		else
		{
			showerr("关键字指定的类型不存在");
		}

		$_sql='';
		foreach( $postdb AS $key=>$value)
		{
			if( $value && table_field("{$_pre}content_$mid",$key) )
			{
				$_sql.=" AND B.`$key`='$value' ";
				$rsdb[$key][$value]=" selected ";
			}
		}
		
		//分页功能
		//$showpage=getpage("{$_pre}content A LEFT JOIN {$_pre}content_$mid B ON A.id=B.id","WHERE A.mid='$mid' AND $field LIKE '%$keyword%' $_sql","?mid=$mid&keyword=$keyword&action=search&type=$type",$rows);

		$SQL="SELECT A.*,B.* FROM {$_pre}content A LEFT JOIN {$_pre}content_$mid B ON A.id=B.id WHERE A.mid='$mid' AND $field LIKE '%$keyword%' $_sql LIMIT $min,$rows ";
	}

	$query = $db->query("$SQL");
	while($rs = $db->fetch_array($query))
	{
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		$listdb[]=$rs;
	}

	if(!$listdb)
	{
		showerr("很抱歉，没有找到你要查询的内容");
	}
	$typedb[$type]=" checked ";
}

else
{
	$typedb[title]=" checked ";
}

$mid=intval($mid);

$colordb[$mid]="red;";

require(ROOT_PATH."inc/head.php");
if($mid){
	require(getTpl("search_$mid"));
}else{
	require(getTpl("search"));
}
require(ROOT_PATH."inc/foot.php");

?>