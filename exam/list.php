<?php
require("global.php");

//栏目配置文件
$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");
if(!$fidDB){
	showerr("栏目有误");
}

//导航条
@include(Mpath."data/guide_fid.php");

//SEO
$titleDB[title]		= "$fidDB[name] - $titleDB[title]";


$rows=20;
$page<1 && $page=1;
$min=($page-1)*$rows;

if($Fid_db[$fid]){
	$fup = $fid;
	$SQL=" WHERE S.fup='$fid' ";
}else{
	$fup = $fidDB[fup];
	$SQL=" WHERE F.fid='$fid' ";
}


$query = $db->query("SELECT SQL_CALC_FOUND_ROWS F.*,S.name AS fname FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid $SQL ORDER BY F.id DESC LIMIT $min,$rows");

$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];

$showpage=getpage('','',"?fid=$fid",$rows,$totalNum);


while($rs = $db->fetch_array($query)){
	$rs[posttime] = date('y-m-d',$rs[creattime]);
	$listdb[]=$rs;
}



/**
*标签
**/
$chdb[main_tpl]=getTpl('list');
$ch_fid	= intval($fidDB[config][label_list]);		//是否定义了栏目专用标签
$ch_pagetype = 2;									//2,为list页,3,为bencandy页
$ch_module = $webdb[module_id]?$webdb[module_id]:99;//系统特定ID参数,每个系统不能雷同
$ch = 0;											//不属于任何专题
require(ROOT_PATH."inc/label_module.php");


require(ROOT_PATH."inc/head.php");
require(getTpl("list"));
require(ROOT_PATH."inc/foot.php");
 
?>