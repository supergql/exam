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
		$rs[state]=$rs[syz]?"<font color=blue>������</font>":"δ����";
		$listdb[]=$rs;
	}

	if(!$webdb[Info_delpaper]){
		$alert=" style='color:#eee;' onclick=\"return confirm('�ܱ�Ǹ,����Ա���óɲ�����ɾ���Լ����Ծ�!');\" ";
	}

	require(ROOT_PATH."member/head.php");
	require("template/list.htm");
	require(ROOT_PATH."member/foot.php");
}
elseif($job=='del')
{
	if(!$webdb[Info_delpaper]){
		showerr('�ܱ�Ǹ,����Ա���óɲ�����ɾ���Լ����Ծ�!');
	}
	$rsdb=$db->get_one("SELECT * FROM {$_pre}student WHERE student_id='$student_id' AND student_uid='$lfjuid'");
	if(!$rsdb){
		showerr('����Ȩ��!');
	}
	$db->query("DELETE FROM {$_pre}student WHERE student_id='$student_id' AND student_uid='$lfjuid'");
	$db->query("DELETE FROM {$_pre}student_title WHERE student_id='$student_id'");
	refreshto($FROMURL,'ɾ���ɹ�!',1);
}


?>