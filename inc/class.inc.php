<?php
class Guide_DB {
	/**/
	//是否只显示部分模型栏目
	var $only='';
	var $mid='';
	var $ifpost=0;
	var $getfup=0;

	function Select($table,$name='fid',$ckfid='',$url='',$fid=0,$forbid='',$multiple='',$size=6){
		global $db,$pre,$webdb;
		if($table=="{$pre}sort"&&$webdb[sortNUM]>500){

			$ckfid && $rs=$db->get_one("SELECT * FROM $table WHERE fid='$ckfid'");
			$rand=time().rand(0,9999);
			$url && $url = urlencode("$url&{$name}=");
			$rs[name] || $rs[name]="请选择...";
			$show="<input type='hidden' name='$name' value='$rs[fid]' id='fid$rand'><input type=\"button\" name=\"\" value=\"$rs[name]\" id='fname$rand'  style=\"height:21px;width:150px;border:0px;background-image:url($webdb[www_url]/images/default/select.gif);padding-top:2px; background-color: transparent\" onClick=\"window.open('$webdb[www_url]/do/job.php?job=select&mid={$this->mid}&rand=$rand&url=$url&&fid=$fid&ckfid='+document.getElementById('fid$rand').value,'','width=400,height=400, scrollbars=yes');\">";

			return $show;
		}
		if($url){
			$reto=" onchange=\"window.location.href='{$url}&{$name}='+this.options[this.selectedIndex].value\"";
		}
		if($multiple){
			$multiple=" size=$size multiple=multiple ";
		}
		$show="<select name='$name' $reto $multiple><option value=''>现有分类</option>";
		$show.=$this->SelectIn($table,$fid,$ckfid);
		$show.=" </select>";
		return $show;
	}
	function Checkbox($table,$name='fiddb[]',$fiddb=array(),$fup=0,$w='350px',$h='200px'){
		global $db,$pre,$webdb;
		if($table=="{$pre}sort"&&$webdb[sortNUM]>500){
			$show=$this->Select($table,$name,$fiddb[0]);
			return $show;
		}
		$fid_str = $this->CheckboxIn($table,$name,$fiddb,$fup);
		return "<div style='width:$w;height:$h;overflow:auto;border:1px dotted #ccc;background:#FAFAFA;'>$fid_str</div>";
	}
	function CheckboxIn($table,$name,$fiddb,$fup=0){
		global $db;
		$query = $db->query("SELECT fid,name,fup,class,type FROM $table WHERE fup='$fup' ORDER BY list DESC");
		while($rs = $db->fetch_array($query)){
			$icon="";
			for($i=1;$i<$rs['class'];$i++){
				$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			if($icon){
				$icon=substr($icon,0,-24);
				$icon.="--";
			}
			$ck=in_array($rs[fid],$fiddb)?'checked':'';
			$disabled=$rs[type]?' disabled ':'';
			$show.="<input $disabled type='checkbox' name='$name' value='$rs[fid]' $ck>{$icon}【{$rs[name]}】<br>";
			$show .= $this->CheckboxIn($table,$name,$fiddb,$rs[fid]);
		}
		return $show;
	}
	/*导航条缓存*/
	function GuideFidCache($table,$filename="guide_fid.php",$TruePath=0){
		global $db,$webdb,$pre;
		if($table=="{$pre}sort"&&$webdb[sortNUM]>500){
			return ;
		}
		$show="<?php \r\n";
		//$showindex="<a href='javascript:guide_link(0);' class='guide_menu'>&gt;首页</a>";
		$showindex="<a href='\$webdb[www_url]' class='guide_menu'>&gt;首页</a>";
		$query=$db->query("select fid,name from $table ");
		while( @extract($db->fetch_array($query)) ){
			$show.="\$GuideFid[$fid]=\"$showindex".$this->SortFather($table,$fid)."\";\r\n";
		}
		$show.=$shows.'?>';
		if($TruePath==1){
			write_file($filename,$show);
		}else{
			write_file(ROOT_PATH."data/$filename",$show);
		}
	}
	/**/
	function FidSonCache($table,$filename="fidson_menu.js",$TruePath=0){
		global $db,$N_path,$webdb,$pre;
		if($table=="{$pre}sort"&&$webdb[sortNUM]>500){
			return ;
		}
		/*启用下拉菜单，栏目大于100个时不推荐*/
		if($webdb[nav_menu]){
			$show="var FidSon_0=\"".$this->SortSon($table,$url,0,0)."\";\r\n";
			$query=$db->query("select fid from $table where sons>0 ");
			while( @extract($db->fetch_array($query)) ){
				$show.="var FidSon_$fid=\"".$this->SortSon($table,$fid)."\";\r\n";
			}
			if($TruePath==1){
				write_file($filename,$show);
			}else{
				write_file(ROOT_PATH."data/$filename",$show);
			}
			
		}
	}
	/**/
	function BlankIcon($class,$blank='1'){
		if($blank){
			for($i=1;$i<$class;$i++){
				$show.="&nbsp;&nbsp;&nbsp;";
			}
		}
		return "{$show}|-";
	}
	/**/
	function SelectIn($table,$fup,$ckfid) {
		global $db,$groupdb,$lfjdb;
		$query=$db->query("SELECT * FROM `$table` WHERE fup='$fup' ORDER BY list");
		while( $rs=$db->fetch_array($query) ){
			$topico=$this->BlankIcon($rs['class']);
			$ckk='';
			if(is_array($ckfid)){
				in_array($rs[fid],$ckfid) && $ckk='selected';
			}else{
				$ckfid==$rs[fid] && $ckk='selected';
			}
						
			//有些非本模型的栏目不必显示
			if(($this->only=='')||$rs[fmid]==$this->mid){
				//只允许指定用户组在此栏目发表主题
				if($this->ifpost)
				{
					//$rs[type]==2时是单篇文章,=1时是分类,不允许发表内容
					if($rs[type]==1){
						$show.="<option value='0' $ckk style='color:blue;'>{$topico}$rs[name]</option>";
					}elseif($rs[type]==0){
						//如果指定了栏目发表权限或默认没权限发表的情况
						if($rs[allowpost]||$this->forbidpost==1){
							if(($lfjdb&&in_array($lfjdb[username],explode(",","$rs[admin]")))||in_array($groupdb[gid],explode(",","3,4,$rs[allowpost]"))){
								$show.="<option value='$rs[fid]' $ckk>{$topico}$rs[name]</option>";
							}
						}else{
							$show.="<option value='$rs[fid]' $ckk>{$topico}$rs[name]</option>";
						}						
					}
				}
				elseif($this->getfup)
				{
					if($rs[type]==1){
						$show.="<option value='$rs[fid]' $ckk>{$topico}$rs[name]</option>";
					}
				}
				else
				{
					$show.="<option value='$rs[fid]' $ckk>{$topico}$rs[name]</option>";
				}
			}
			$show.=$this->SelectIn($table,$rs[fid],$ckfid);
		}
		return $show;
	}

	//PW论坛
	function Select_PW($name='fid',$ck='',$url='',$multiple='',$size=6,$fiddb=''){
		global $db;
		if($url){
			$reto=" onchange=\"window.location=('{$url}&{$name}='+this.options[this.selectedIndex].value+'')\"";
		}
		if($multiple){
			$multiple=" size=$size multiple=multiple ";
		}
		$show="<select name='$name' $reto $multiple><option value=''>现有分类</option>";
		$show.=$this->Select_PWIn(0,$ck,0);
		$show.=" </select>";
		return $show;
	}
	function Select_PWIn($fup,$ck,$class) {
		global $db,$lfjdb,$TB_pre;
		$class++;
		$topico=$this->BlankIcon($class);
		$query=$db->query("SELECT * FROM {$TB_pre}forums WHERE fup='$fup' ORDER BY vieworder DESC");
		while($rs=$db->fetch_array($query)){
			if($rs[f_type]=='hidden'){
				continue;
			}
			if(is_array($ck)){
				in_array($rs[fid],$ck)?$ckk='selected':$ckk='';
			}else{
				$ck==$rs[fid]?$ckk='selected':$ckk='';
			}
			$show.="<option value='$rs[fid]' $ckk>{$topico}$rs[name]</option>";
			$show.=$this->Select_PWIn($rs[fid],$ck,$class);
		}
		return $show;
	}
	
	/**/
	function SortFather($table,$fup) {
		global $db,$webdb;
		$query=$db->query("select fid,fup,class,name,sons from $table where fid='$fup'");
		while( @extract($db->fetch_array($query)) ){
			if($webdb[nav_menu]&&$sons){			//启用下拉菜单，大网站不推荐
				$showmenu="onMouseOver='ShowMenu_mmc(forum_$fid,100)' onMouseOut='HideMenu_mmc()'";
			}
			$name=str_Replace('"',"",$name);
			//$show.=" -&gt; <a $showmenu href='javascript:guide_link($fid);' class='guide_menu'>$name</a>";
			$show.=" -&gt; <a $showmenu href='list.php?fid=$fid' class='guide_menu'>$name</a>";
			$show=$this->SortFather($table,$fup).$show;
		}
		return $show;
	}
	/**/
	function SortSon($table='',$fid='0',$showsons=1){
		global $db;
		$query=$db->query("select fid,name,sons,class from $table where fup='$fid' order by list");
		while( @extract($db->fetch_array($query)) ){
			$topico=$this->BlankIcon($class);
			$name=str_Replace('"',"",$name);
			//$show.="{$topico}<a href='javascript:guide_link($fid);'>$name</a><br>";
			$show.="{$topico}<a href='list.php?fid=$fid'>$name</a><br>";
			if($showsons){
				$show.=$this->SortSon($table,$fid,$showsons);
			}
						
		}
		return $show;
	}
}
?>