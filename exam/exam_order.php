<?php
require("global.php");

$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

if(!$rsdb){
	showerr("���ݲ�����!");
}

$fid = $rsdb[fid];

//������
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
if($search==1) $and=" AND aclass='$aclass'";//���༶��ѯ
$T1=strtotime("$time1");
$T2=strtotime("$time2");
if($search==2) $and=" AND posttime>='$T1' AND posttime<='$T2'";//������ʱ�β�ѯ
if($search==3) $and=" AND number>='$number1' AND number<='$number2'";//�����ŷ�Χ��ѯ
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
	$rs[usetime] = "{$time_s} �� {$time_i} ��";
	$rs[posttime] = date('y-m-d H:i:s',$rs[posttime]);
	$listdb[]=$rs;
}

$showpage = getpage('','',"?",$rows,$totalNum);
if(!$listdb){
	showerr('��ǰ�Ծ�û�п�����Ϣ!');
}


$time_s = floor($infodb[totaltime]/60);
$time_i = $infodb[totaltime]%60;

//����EXCEL���ӱ��
if($excel==1){		
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=�ɼ���_{$rsdb[name]}.xls");
	$biaoti="<tr align=center height=30><td colspan=8>��{$rsdb[name]}�������ɼ���</td></tr>";
	$biaotou="<tr align=center height=30><td>����</td><td>����</td><td>�༶</td><td>����</td><td>�û���</td><td>�����ʱ</td><td>���Գɼ�</td><td>����ʱ��</td></tr>"; 
	foreach($listdb AS $rs){
		$data.="<tr align=center height=30><td>$rs[i]</td><td>$rs[student_truename]</td><td>$rs[aclass]</td><td>$rs[number]</td><td>$rs[student_name]</td><td>$rs[usetime]</td><td>$rs[total_fen]</td><td>$rs[posttime]</td></tr>";
	}
	echo '<table border="1">'.$biaoti.$biaotou.$data.'</table>';
	exit;
}
//����鿴��ʽ�ύ����Ҫ�õ���һЩ����
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