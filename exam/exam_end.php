<?php
require("global.php");

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


if(!$lfjuid){
	showerr("请先登录!");
}

$infodb = $db->get_one("SELECT * FROM {$_pre}student WHERE form_id='$id' AND student_uid='$lfjuid'");
if(!$infodb){
	showerr("你还没有参加当前考试!");
}

extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}student WHERE form_id='$id' AND total_fen>'$infodb[total_fen]' "));

$ordernum = $NUM+1;

$time_s = floor($infodb[totaltime]/60);
$time_i = $infodb[totaltime]%60;

require(ROOT_PATH."inc/head.php");
require(getTpl("exam_end"));
require(ROOT_PATH."inc/foot.php");
?>