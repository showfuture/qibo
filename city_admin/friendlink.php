<?php
require_once(dirname(__FILE__)."/global.php");



if($job=="yz"){
	$db->query("UPDATE {$_pre}friendlink SET yz='$yz' WHERE city_id='$city_id' AND id='$id'");
	write_friendlink();
}elseif($action=="del"){
	$db->query("DELETE FROM {$_pre}friendlink WHERE city_id='$city_id' AND id='$id'");
	write_friendlink();
}

$rows=15;

if(!$page)
{
	$page=1;
}
$min=($page-1)*$rows;


unset($listdb,$i);

$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}friendlink WHERE city_id='$city_id' ORDER BY id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];
$showpage=getpage('','',"?",$rows,$totalNum);
while($rs = $db->fetch_array($query)){
	$rs[posttime]=$rs[posttime]?date("Y-m-d H:i:s",$rs[posttime]):'';
	$i++;
	$rs[cl]=$i%2==0?'t2':'t1';
	$rs[yz]=$rs[yz]?"<A HREF='?job=yz&yz=0&id=$rs[id]' style='color:red;'>已审核</A>":"<A HREF='?job=yz&yz=1&id=$rs[id]' style='color:blue;'>未审核</A>";
	if($rs[logo]){
		$rs[logo]=tempdir($rs[logo]);
		$rs[logo]="<img src='$rs[logo]' width=88 height=31 border=0> ";
	}
	$listdb[]=$rs;
}

require(dirname(__FILE__)."/head.php");
require(dirname(__FILE__)."/template/friendlink.htm");
require(dirname(__FILE__)."/foot.php");



//友情链接缓存
function write_friendlink(){
	global $db,$pre,$timestamp,$webdb,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}friendlink WHERE ifhide=0 AND yz=1 AND (endtime=0 OR endtime>$timestamp) ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		foreach( $rs AS $key=>$value){
			$rs[$key]=AddSlashes($rs[$key]);
		}
		if($rs[logo]&&!$rs[iswordlink]){
			$rs[logo]=tempdir($rs[logo]);
			$logodb[]="'$rs[id]'=>array('name'=>'$rs[name]','url'=>'$rs[url]','logo'=>'$rs[logo]','descrip'=>'$rs[descrip]')";
		}else{
			$worddb[]="'$rs[id]'=>array('name'=>'$rs[name]','url'=>'$rs[url]','descrip'=>'$rs[descrip]')";
		}
	}
	$write="<?php\r\n\$friendlinkDB[1]=array(".implode(",\r\n",$logodb).");\r\n\$friendlinkDB[0]=array(".implode(",\r\n",$worddb).");";
	
	//以上是供首页调用显示.以下是供其它页面调用显示
	$query2 = $db->query("SELECT * FROM {$_pre}city");
	while($rs2 = $db->fetch_array($query2)){
		unset($logodb,$worddb);
		$query = $db->query("SELECT * FROM {$_pre}friendlink WHERE fid='$rs2[fid]' AND yz=1 AND (endtime=0 OR endtime>$timestamp) ORDER BY list DESC");
		while($rs = $db->fetch_array($query)){

			foreach( $rs AS $key=>$value){
				$rs[$key]=AddSlashes($rs[$key]);
			}
			if($rs[logo]&&!$rs[iswordlink]){
				$rs[logo]=tempdir($rs[logo]);
				$logodb[]="'$rs[id]'=>array('name'=>'$rs[name]','url'=>'$rs[url]','logo'=>'$rs[logo]','descrip'=>'$rs[descrip]')";
			}else{
				$worddb[]="'$rs[id]'=>array('name'=>'$rs[name]','url'=>'$rs[url]','descrip'=>'$rs[descrip]')";
			}
		}
		$write.="\r\n\r\n\$friendlink_DB[{$rs2[fid]}][1]=array(".implode(",\r\n",$logodb).");\r\n\$friendlink_DB[{$rs2[fid]}][0]=array(".implode(",\r\n",$worddb).");";
	}
	write_file(ROOT_PATH."data/friendlink.php",$write);
}

?>