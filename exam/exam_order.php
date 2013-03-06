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

if($page<1){
	$page=1;
}
if(!$rows) $rows=20;
if($search==1) $and=" AND aclass='$aclass'";//按班级查询
$T1=strtotime("$time1");
$T2=strtotime("$time2");
if($search==2) $and=" AND posttime>='$T1' AND posttime<='$T2'";//按考试时段查询
if($search==3) $and=" AND number>='$number1' AND number<='$number2'";//按考号范围查询
$min=($page-1)*$rows;
$i=$min;

unset($listdb);
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}student WHERE form_id='$id' $and ORDER BY total_fen DESC,totaltime ASC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];
while($rs = $db->fetch_array($query)){
	$rs[i]=++$i;
	$time_s = floor($rs[totaltime]/60);
	$time_i = $rs[totaltime]%60;
	$rs[usetime] = "{$time_s} 分 {$time_i} 秒";
	$rs[posttime] = date('y-m-d H:i:s',$rs[posttime]);
	$listdb[]=$rs;
}

$showpage = getpage('','',"?",$rows,$totalNum);
if(!$listdb){
	showerr('当前试卷没有考生信息!');
}


$time_s = floor($infodb[totaltime]/60);
$time_i = $infodb[totaltime]%60;

//导出EXCEL电子表格
if($excel==1){		
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=成绩表_{$rsdb[name]}.xls");
	$biaoti="<tr align=center height=30><td colspan=8>《{$rsdb[name]}》考生成绩表</td></tr>";
	$biaotou="<tr align=center height=30><td>排名</td><td>姓名</td><td>班级</td><td>考号</td><td>用户名</td><td>完成用时</td><td>考试成绩</td><td>交卷时间</td></tr>"; 
	foreach($listdb AS $rs){
		$data.="<tr align=center height=30><td>$rs[i]</td><td>$rs[student_truename]</td><td>$rs[aclass]</td><td>$rs[number]</td><td>$rs[student_name]</td><td>$rs[usetime]</td><td>$rs[total_fen]</td><td>$rs[posttime]</td></tr>";
	}
	echo '<table border="1">'.$biaoti.$biaotou.$data.'</table>';
	exit;
}
//处理查看方式提交表单需要用到的一些参数
if(!$time1) $time1=date("Y-m-d H:i",time()-86400);
if(!$time2) $time2=date("Y-m-d H:i");
if($search==1){
	$ck[1]=' checked ';
	$sty[2]=$sty[3]='display:none;';
}elseif($search==2){
	$ck[2]=' checked ';
	$sty[1]=$sty[3]='display:none;';
}elseif($search==3){
	$ck[3]=' checked ';
	$sty[1]=$sty[2]='display:none;';
}else{
	$sty[1]=$sty[2]=$sty[3]='display:none;';
}
	
require(ROOT_PATH."inc/head.php");
require(getTpl("exam_order"));
require(ROOT_PATH."inc/foot.php");
?>