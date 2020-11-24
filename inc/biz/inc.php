<?php 
//手机跳转
function mob_goto_url($url){
	global $webdb;
	if($webdb['mob_goto_3g']&&is_mobile()){	//手机访问自动跳转
		header("location:$url");
		exit;
	}
}


function avoidgather( )
{
	global $rsdb;
	global $webdb;
	global $IS_BIZPhp168;
	if ( !$IS_BIZPhp168 )
	{
		return;
	}
	if ( $webdb[AvoidCopy] )
	{
		$rsdb[content] = "<body oncopy='return false' oncut='return false'>{$rsdb['content']}";
	}
	if ( $webdb[AvoidSave] )
	{
		$rsdb[content] = "{$rsdb['content']}<noscript><iframe scr='*.htm'></iframe></noscript>";
	}
	if ( !$webdb[AvoidGather] )
	{
		return;
	}
	$AvoidGatherpre = rands( 3 ).$webdb[AvoidGatherPre].rands( 3 );
	$rsdb[content] = "<div class='{$AvoidGatherpre}'>{$webdb['AvoidGatherString']}</div>{$rsdb['content']}<div class='{$AvoidGatherpre}'>{$webdb['AvoidGatherString']}</div>";
	$AvoidGatherpre = rands( 3 ).$webdb[AvoidGatherPre].rands( 3 );
	$rsdb[content] = str_replace( "<br>", "<br><div class='{$AvoidGatherpre}'>{$webdb['AvoidGatherString']}{$AvoidGatherpre}</div>", $rsdb[content] );
	$rsdb[content] = str_replace( "<BR>", "<BR><div class='{$AvoidGatherpre}'>{$webdb['AvoidGatherString']}{$AvoidGatherpre}</div>", $rsdb[content] );
	$AvoidGatherpre = rands( 3 ).$webdb[AvoidGatherPre].rands( 3 );
	$rsdb[content] = str_replace( "<p>", "<p><div class='{$AvoidGatherpre}'>{$webdb['AvoidGatherString']}{$AvoidGatherpre}</div>", $rsdb[content] );
}

function limt_ip( $type )
{
	global $webdb;
	global $ForceEnter;
	global $IS_BIZPhp168;
	global $onlineip;
	if ( !$IS_BIZPhp168 )
	{
	}
	else
	{
		if ( $type == "ForbidIp" && $webdb[ForbidIp] )
		{
			$detail = explode( "rn", $webdb[ForbidIp] );
			foreach ( $detail as $key => $value )
			{
				$value = trim( $value );
				if ( !$value )
				{
					continue;
				}
				if ( ereg( "^{$value}", $onlineip ) )
				{
					exit( "Forbid Ip!!" );
				}
			}
		}
		if ( $type == "AllowVisitIp" && $webdb[AllowVisitIp] )
		{
			$AllowVisit = 0;
			$detail = explode( "rn", $webdb[AllowVisitIp] );
			foreach ( $detail as $key => $value )
			{
				$value = trim( $value );
				if ( !$value )
				{
					continue;
				}
				if ( ereg( "^{$value}", $onlineip ) )
				{
					$AllowVisit = 1;
				}
			}
			if ( !$AllowVisit )
			{
				exit( "NO Allow Visit!!" );
			}
		}
		if ( $type == "AdminIp" && $ForceEnter == 0 && $webdb[AdminIp] )
		{
			$AllowVisit = 0;
			$detail = explode( "rn", $webdb[AdminIp] );
			foreach ( $detail as $key => $value )
			{
				$value = trim( $value );
				if ( !$value )
				{
					continue;
				}
				if ( ereg( "^{$value}", $onlineip ) )
				{
					$AllowVisit = 1;
				}
			}
			if ( !$AllowVisit )
			{
				exit( "NO Allow Login!!" );
			}
		}
	}
}

function biz_function( )
{
}


function LIFE_CK($type){
	global $pre,$BIZ_MODULEDB;

	if( !is_array($BIZ_MODULEDB) )
	{
		die("授权认证不存在!");

		return ;
	}
	
	if( !in_array($type,$BIZ_MODULEDB) ){
		die("缺少授权认证!");
	}
	return 1;
}

function LIFE2_CK($type){
	global $pre,$BIZ_MODULEDB;

	if( !is_array($BIZ_MODULEDB) )
	{
		die("2授权认证不存在!");

		return ;
	}
	
	if( !in_array($type,$BIZ_MODULEDB) ){
		die("2缺少授权认证!");
	}
	return 1;
}


function B2B_CK($type){
	global $pre,$BIZ_MODULEDB;

	if( !is_array($BIZ_MODULEDB) )
	{
		die("授权认证不存在!");

		return ;
	}
	
	if( !in_array($type,$BIZ_MODULEDB) ){
		die("缺少授权认证!");
	}
	return 1;
}


function FENLEI_CK($type){
	global $pre,$BIZ_MODULEDB;

	if( !is_array($BIZ_MODULEDB) )
	{
		die("授权认证不存在!");

		return ;
	}
	
	if( !in_array($type,$BIZ_MODULEDB) ){
		die("缺少授权认证!");
	}
	return 1;
}
defined('ROOT_PATH') || define('ROOT_PATH',PHP168_PATH);
//require_once( ROOT_PATH."inc/biz/biz.php" );