<?php

require("global.php");

$chdb[main_tpl]=getTpl("index");
$ch_fid	= $ch_pagetype = 0;
$ch_module = $webdb[module_id]?$webdb[module_id]:7;
@include(ROOT_PATH."inc/label_module.php");

$newpaper=get_paper(5,'new');
$compaper=get_paper(5,'com');

require(ROOT_PATH."inc/head.php");
require(getTpl("index"));
require(ROOT_PATH."inc/foot.php");


function get_paper($rows,$type){
	global $db,$_pre;
	if($type=='com'){
		$SQL="WHERE F.recommend=1";
	}
	$query = $db->query("SELECT S.name AS fname,F.* FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid $SQL ORDER BY id DESC LIMIT $rows");
	while($rs = $db->fetch_array($query)){
		$listdb[]=$rs;
	}
	return $listdb;
}

?>