<?php
require("global.php");

//��Ŀ�����ļ�
$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");
if(!$fidDB){
	showerr("��Ŀ����");
}

//������
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
*��ǩ
**/
$chdb[main_tpl]=getTpl('list');
$ch_fid	= intval($fidDB[config][label_list]);		//�Ƿ�������Ŀר�ñ�ǩ
$ch_pagetype = 2;									//2,Ϊlistҳ,3,Ϊbencandyҳ
$ch_module = $webdb[module_id]?$webdb[module_id]:99;//ϵͳ�ض�ID����,ÿ��ϵͳ������ͬ
$ch = 0;											//�������κ�ר��
require(ROOT_PATH."inc/label_module.php");


require(ROOT_PATH."inc/head.php");
require(getTpl("list"));
require(ROOT_PATH."inc/foot.php");
 
?>