<?php 
require(dirname(__FILE__)."/global.php");

$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");
if(!$fidDB){
	ShowErrs("<span style=\"font-size:16px;color:red;\">栏目不存在</span>");
}
$guides=get_guides($fid);
$thisfup=$fidDB[type]==1?$fid:$fidDB[fup];

$rsdb=$db->get_one("SELECT A.*,B.* FROM {$_pre}content A LEFT JOIN {$_pre}content_$fidDB[mid] B ON A.id=B.id WHERE A.id='$id'");
if(!$rsdb){
	ShowErrs("<span style=\"font-size:16px;color:red;\">内容不存在</span>");
}
$db->query("UPDATE {$_pre}content SET hits=hits+1,lastview='$timestamp' WHERE id='$id'");

$rsdb[posttime]=date("Y-m-d H:i:s",$rsdb[posttime]);

$rsdb[picurl] && $rsdb[picurl]=tempdir($rsdb[picurl]);

$WebTitle=$rsdb[title]."-".$fidDB[name]."-".$webdb['webname'];

$showmoreconts=showmorecontent($fidDB[mid]);
$contacts="<div style=\"border-left:green solid 2px;background:#EFEFEF;padding:5px 5px 5px 10px;line-height:20px;margin:5px auto 10px auto;\"><div><b>电话号码:</b>$rsdb[telephone]</div>
        <div><b>手机号码:</b>$rsdb[mobphone]</div>
        <div><b>QQ号码:</b>$rsdb[oicq]</div>
        <div><b>MSN帐号:</b>$rsdb[msn]</div>
        <div><b>邮箱帐号:</b>$rsdb[email]</div></div>";

$showmoreconts.=$contacts;

require(Mpath."template/head.htm");
require(Mpath."template/bencandy.htm");
require(Mpath."template/foot.htm");

function showmorecontent($mid){
	global $db,$_pre,$rsdb;
	$query = $db->query("SELECT * FROM `{$_pre}field` WHERE mid='$mid' ORDER BY orderlist DESC,id ASC");
	$show="";
	while($rs = $db->fetch_array($query)){
		$key=$rs[field_name];
		if($rs[form_type]=='textarea'){
			require_once(ROOT_PATH."inc/encode.php");
			$rsdb[$key]=format_text($rsdb[$key]);
		}elseif($rs[form_type]=='ieedit'||$rs[form_type]=='ieeditsimp'){
			$rsdb[$key]=En_TruePath($rsdb[$key],0,1);
		}elseif($rs[form_type]=='upfile'||$rs[form_type]=='onepic'){
			$rsdb[$key]=tempdir($rsdb[$key]);
		}elseif($rs[form_type]=='upmorepic'||$rs[form_type]=='upmorefile'){
			$detail=explode("\n",$rsdb[$key]);
			unset($rsdb[$key]);
			foreach( $detail AS $_key=>$value){
				list($_url,$_name)=explode("@@@",$value);
				$rsdb[$key][url][]=tempdir($_url);
				$rsdb[$key][title][]=$_name;
			}
		}elseif($rs[form_type]=='classdb'){
			$rsdb[$key]=$this->classdb_show($rsdb[$key]);
		}elseif($rs[form_type]=='select'||$rs[form_type]=='radio'){
			if(strstr($rs[form_set],"|")){
				$rs[form_set]=str_replace("\r","",$rs[form_set]);
				$detail=explode("\n",$rs[form_set]);
				foreach( $detail AS $key2=>$value2){
					list($_key,$_value)=explode("|",$value2);
					$_key==$rsdb[$key] && $_value && $rsdb[$key]=$_value;
				}
			}
		}elseif($rs[form_type]=='checkbox'){
			if(strstr($rs[form_set],"|")){
				$rs[form_set]=str_replace("\r","",$rs[form_set]);
				$detail=explode("\n",$rs[form_set]);
				foreach( $detail AS $key2=>$value2){
					list($_key,$_value)=explode("|",$value2);
					if($_value){
						//以下还需要进一步改进的
						$rsdb[$key]=str_replace($_key,$_value,$rsdb[$key]);
					}
				}
			}
			$rsdb[$key]=str_replace("/","、",$rsdb[$key]);
		}

		$show.= "<div class='lists'><span>".$rs[title]."：</span>".$rsdb[$key].$rs[form_units]."</div>\r\n";
	}
	return $show;
}
?>