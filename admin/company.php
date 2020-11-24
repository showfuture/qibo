<?php
!function_exists('html') && exit('ERR');

if(is_table("{$pre}hy_company")){
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=index.php?lfj=module_admin&dirname=hy&file=company&job=list'>";
	exit;
}else{
	showerr('你没有安装黄页模块');
}

?>