<?php
$_pre="{$pre}fenlei_";	
function GetInfos($type,$fid,$city_id,$rows){
	global $db,$_pre,$webdb,$Fid_db;
	$SQL="WHERE yz=1";
	if($fid){
		$fidstring=$fid;
		foreach( $Fid_db[$fid] AS $keyfid=>$value){
			$fidstring .=",$keyfid";
			$fid_array[]=$keyfid;
		}
		$fid_array && $fid_array[]=$fid;
		$SQL .=" AND fid IN ($fidstring) ";
	}
	if($city_id>0){
		$SQL .=" AND city_id='$city_id' ";
	}
	$query = $db->query("SELECT * FROM `{$_pre}content` $SQL  ORDER BY $type DESC LIMIT $rows");
	while($rs = $db->fetch_array($query)){
		$listdb[]=$rs;
	}
	return $listdb;
}



//ฬแสพาณรๆ
function ShowErrs($notes){
	global $Murl;
	require(Mpath."template/showerr.htm");
	require(Mpath."template/foot.htm");
	exit;
}
?>