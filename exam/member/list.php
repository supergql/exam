<?php
require("global.php");

$linkdb=array();

if($job=='list')
{
	$rows=20;
	if($page<1){
		$page=1;
	}
	$min=($page-1)*$rows;
	
	$query = $db->query("SELECT SQL_CALC_FOUND_ROWS S.*,F.*,S.yz AS syz FROM {$_pre}student S LEFT JOIN {$_pre}form F ON S.form_id=F.id WHERE S.student_uid='$lfjuid' ORDER BY S.student_id DESC LIMIT $min,$rows");
	
	$RS=$db->get_one("SELECT FOUND_ROWS()");
	$showpage=getpage("","","?job=$job",$rows,$RS['FOUND_ROWS()']);

	while($rs = $db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
		if($rs[hidefen]&&!$rs[yz]){
			$rs[total_fen]='';
		}
		$rs[state]=$rs[syz]?"<font color=blue>已批阅</font>":"未批阅";
		$listdb[]=$rs;
	}

	if(!$webdb[Info_delpaper]){
		$alert=" style='color:#eee;' onclick=\"return confirm('很抱歉,管理员设置成不允许删除自己的试卷!');\" ";
	}

	require(ROOT_PATH."member/head.php");
	require("template/list.htm");
	require(ROOT_PATH."member/foot.php");
}
elseif($job=='del')
{
	if(!$webdb[Info_delpaper]){
		showerr('很抱歉,管理员设置成不允许删除自己的试卷!');
	}
	$rsdb=$db->get_one("SELECT * FROM {$_pre}student WHERE student_id='$student_id' AND student_uid='$lfjuid'");
	if(!$rsdb){
		showerr('你无权限!');
	}
	$db->query("DELETE FROM {$_pre}student WHERE student_id='$student_id' AND student_uid='$lfjuid'");
	$db->query("DELETE FROM {$_pre}student_title WHERE student_id='$student_id'");
	refreshto($FROMURL,'删除成功!',1);
}


?>