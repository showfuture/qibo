<?php
!function_exists('html') && exit('ERR');
if($job=="listimg"&&$Apower[attachment_list]){
	$imgdb=array();
	get_imgfile(ROOT_PATH."$webdb[updir]");
	krsort($imgdb);
	if($page<1){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;
	$i=-1;
	foreach($imgdb AS $key=>$value){
		$i++;
		if($i<$min){
			continue;
		}elseif($i>$min+$rows-1){
			break;
		}
		$listdb[]=array('time'=>date("m-d H:i",$key),'name'=>basename($value),'path'=>str_replace(ROOT_PATH,"",$value));
	}
	$showpage=getpage("","","?lfj=$lfj&job=$job","$rows",$total=count($imgdb));

	hack_admin_tpl('listimg');
}
elseif($job=="list"&&$Apower[attachment_list]){
	!$page&&$page=1;
	$rows=40;
	$min=($page-1)*$rows;
	$down_path || $down_path=$webdb[updir];
	
	$up_path=preg_replace("/(.*)\/([^\/]+)/is","\\1",$down_path);

	$thispath=ROOT_PATH.$down_path;

	$file_db=get_file($down_path);

	$total=count($file_db);
	
	$showpage=getpage("","","index.php?lfj=$lfj&job=$job&down_path=$down_path",$rows,$total);

	for($i=$min;$i<$min+$rows;$i++){
		if(!$file_db[$i]){
			break;
		}
		$rs[type]=$file_db[$i][type];
		$rs[size]=number_format(filesize(ROOT_PATH.$file_db[$i][path])/1024,3);
		$rs[path]=($file_db[$i][path]);
		$rs[name]=basename($file_db[$i][path]);
		$rs[icon]=$file_db[$i][icon];
		$rs[posttime]=date("Y-m-d H:i:s",filemtime(ROOT_PATH.$file_db[$i][path]));
		$rs[url]="$webdb[www_url]/".$file_db[$i][path];
		$rs[id]=$i;
		$listdb[]=$rs;
	}

	//$totalsize=dskspace(ROOT_PATH."$webdb[updir]");
	//$totalsize=abs(number_format($totalsize/(1024),3));


	hack_admin_tpl('list');
}
elseif($action=="delete"&&$Apower[attachment_list])
{
	foreach($iddb AS $key=>$value)
	{
		if(!strstr($value,"..")&&!ereg("^\/",$value)&&$value){
			del_file(ROOT_PATH.$value);
		}
	}
	jump("É¾³ý³É¹¦","$FROMURL",1);
}
// 

function get_file($dir){
	$dir_hand = opendir(ROOT_PATH.$dir);
	while($file=readdir($dir_hand))
	{
		$rs[path]="$dir/$file";
		if(is_file(ROOT_PATH."$dir/$file"))
		{
			$rs[type]="file";
			$rs[icon]="images/file_icon.gif";
			$array[]=$rs;
		}
		elseif( $file!="." && $file!=".." && is_dir(ROOT_PATH."$dir/$file") )
		{
			$rs[type]="dir";
			$rs[icon]="images/dir_icon.gif";
			$array[]=$rs;
		}
	}
	return $array;
}

function dskspace($dir) 
{ 
   $s = stat($dir); 
   $space = $s["blocks"]*512; 
   if (is_dir($dir)) 
   { 
     $dh = opendir($dir); 
     while (($file = readdir($dh)) !== false) 
       if ($file != "." and $file != "..") 
         $space += dskspace($dir."/".$file); 
     closedir($dh); 
   } 
   return $space; 
}

function get_imgfile($path){
	global $imgdb;
	if (file_exists($path)){
		if(is_file($path)){
			if(eregi("(\.gif|\.bmp|\.png|\.jpg)$",$path)){
				$imgdb[filemtime($path)]=$path;
			}			
		} else{
			$handle = opendir($path);
			while (($file = readdir($handle))!='') {
				if (($file!=".") && ($file!="..") && ($file!="")){
					if (is_dir("$path/$file")){
						get_imgfile("$path/$file");
					} else{
						if(eregi("(\.gif|\.bmp|\.png|\.jpg)$",$file)){
							$imgdb[filemtime("$path/$file")]="$path/$file";
						}
					}
				}
			}
			closedir($handle);
		}
	}
}

?>