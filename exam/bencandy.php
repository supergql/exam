<?php
require("global.php");

$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");


$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

if(!$rsdb){
	showerr("数据不存在!");
}

$fid = $rsdb[fid];

//导航条
@include(Mpath."data/guide_fid.php");


$config=@unserialize($rsdb[config]);

$examtotalfen=0;
foreach($config[fendb] AS $f){
	$examtotalfen +=abs($f);
}

//SEO
$titleDB[title]		= "$rsdb[name] - $rsdb[fname] - $titleDB[title]";

if($Fid_db[$fid]){
	$fup = $fid;
}else{
	$fup = $fidDB[fup];
}




$db->query("UPDATE `{$_pre}form` SET hits=hits+1 WHERE id='$id'");

$begintime = date('Y-m-d H:i:s',$timestamp);

require(ROOT_PATH."inc/head.php");
require(getTpl("bencandy"));
require(ROOT_PATH."inc/foot.php");
?>