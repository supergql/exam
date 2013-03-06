<?php
require("global.php");


//创建题目
if($job=="make")
{
	$sort_fid=$Guidedb->Select("{$_pre}sort","fid");

	$ifsharedb[1]=' checked ';
	
	require(ROOT_PATH."member/head.php");
	require("template/exam_title/make.htm");
	require(ROOT_PATH."member/foot.php");
}
//创建题目
elseif($action=="make")
{
	if(!$fid)
	{
		showerr("请选择分类");
	}
	$atc_question = preg_replace("/^<p>(.*)<\/p>$/is","\\1",$atc_question);
	$atc_question=En_TruePath($atc_question,1);
	$db->query("INSERT INTO `{$_pre}title` ( `fid`, `type`, `question`, `config`, `answer`, `uid`, `username`, `ifshare`, `difficult`, `star`, `yz`) VALUES ('$fid','$ctype','$atc_question','$atc_config','$atc_answer','$userdb[uid]','$userdb[username]','$atc_ifshare','$atc_difficult','$atc_star',1)");
	$id = $db->insert_id();
	refreshto("?job=list","创建成功",1);
}

//列出所有题目
elseif($job=="list")
{
	$sort_fid=$Guidedb->Select("{$_pre}sort","fid",$fid,"$admin_path&job=$job&paper_id=$paper_id&star=$star&difficult=$difficult&type=$type&paper_id=$paper_id");
	
	$choose_type="<select name=\"select\" onchange=\"window.location.href='$admin_path&job=$job&fid=$fid&paper_id=$paper_id&star=$star&difficult=$difficult&type='+this.options[this.selectedIndex].value\"><option value=''>---</option>";
	foreach($paperType AS $key=>$value){
		$select=$type==$key?'selected':'';
		$choose_type.="<option value='$key' $select>$value</option>";
	}
	$choose_type.="</select>";
	
	$select_difficult[$difficult]='selected';
	$choose_difficult="<select name=\"select\" onchange=\"window.location.href='$admin_path&job=$job&fid=$fid&paper_id=$paper_id&star=$star&type=$type&difficult='+this.options[this.selectedIndex].value\"><option value=''>---</option><option value='0' {$select_difficult[0]}>中等</option><option value='-1' {$select_difficult[-1]}>容易</option><option value='1' {$select_difficult[1]}>偏难</option></select>";
	
	$select_star[$star]='selected';
	$choose_star="<select name=\"select\" onchange=\"window.location.href='$admin_path&job=$job&fid=$fid&paper_id=$paper_id&difficult=$difficult&type=$type&star='+this.options[this.selectedIndex].value\"><option value=''>---</option><option value='0' {$select_star[0]}>0星级</option><option value='1' {$select_star[1]}>1星级</option><option value='2' {$select_star[2]}>2星级</option><option value='3' {$select_star[3]}>3星级</option></select>";

	if($fid){
		$SQL=" WHERE A.fid='$fid' AND uid='$lfjuid' ";
	}else{
		$SQL=" WHERE uid='$lfjuid' ";
	}

	if($type!=''){
		$SQL .=" AND A.type='$type' ";
	}
	if($difficult!=''){
		$SQL .=" AND A.difficult='$difficult' ";
	}
	if($star!=''){
		$SQL .=" AND A.star='$star' ";
	}
/*
	$select_exam="<select name='form_id'>";
	$query = $db->query("SELECT * FROM `{$_pre}form` A");
	while($rs = $db->fetch_array($query)){
		$select_exam.="<option value='$rs[id]'>$rs[name]</option>";
	}
	$select_exam.="</select>";
*/	
	$paperdb = $db->get_one("SELECT * FROM `{$_pre}form` WHERE id='$paper_id'");
	
	if($page<1){
		$page=1;
	}
	$rows=50;
	$min=($page-1)*$rows;

	$query = $db->query("SELECT A.*,S.name AS fname FROM `{$_pre}title` A LEFT JOIN `{$_pre}sort` S ON A.fid=S.fid $SQL ORDER BY A.id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rs[question]=En_TruePath($rs[question],0);
		$listdb[]=$rs;
	}
	
	$showpage=getpage("`{$_pre}title` A","$SQL","$admin_path&job=list&fid=$fid&paper_id=$paper_id&difficult=$difficult&type=$type&star=$star","$rows");
	require(ROOT_PATH."member/head.php");
	require("template/exam_title/list.htm");
	require(ROOT_PATH."member/foot.php");
}



//删除题目
elseif($action=="delete")
{
	if($db->get_one("SELECT * FROM {$_pre}title WHERE id='$id' AND uid='$lfjuid'")){
		$db->query(" DELETE FROM `{$_pre}title` WHERE id='$id'");
		$db->query(" DELETE FROM `{$_pre}form_element` WHERE title_id='$id' ");
		$db->query(" DELETE FROM `{$_pre}student_title` WHERE title_id='$id' ");
	}
	refreshto($FROMURL,"删除成功");
}

//修改题目
elseif($job=="edit")
{

	$rsdb=$db->get_one("SELECT * FROM {$_pre}title WHERE id='$id' AND uid='$lfjuid'");
	$sort_fid=$Guidedb->Select("{$_pre}sort","fid",$rsdb[fid]);
	$ifsharedb[$rsdb[ifshare]]=' checked ';

	$difficult[$rsdb[difficult]]=' selected ';
	$star[$rsdb[star]]=' selected ';
	
	$rsdb[question]=En_TruePath($rsdb[question],0);
	$rsdb[question]=editor_replace($rsdb[question]);

	require(ROOT_PATH."member/head.php");
	require("template/exam_title/make.htm");
	require(ROOT_PATH."member/foot.php");
}
//修改题目
elseif($action=='edit')
{
	if($ctype==4){
		$array=explode("\r\n",$atc_answer);
		foreach($array AS $key=>$value){
			if(trim($value)==''){
				unset($array[$key]);
			}
		}
		$atc_answer=implode("\r\n",$array);
	}
	if($ctype==1||$ctype==2||$ctype==5){
		$array=explode("\r\n",$atc_config);
		foreach($array AS $key=>$value){
			if(trim($value)==''){
				unset($array[$key]);
			}
		}
		$atc_config=implode("\r\n",$array);
	}
	$atc_question = preg_replace("/^<p>(.*)<\/p>$/is","\\1",$atc_question);
	$atc_question=En_TruePath($atc_question,1);
	$db->query("UPDATE `{$_pre}title` SET fid='$fid',type='$ctype',question='$atc_question',config='$atc_config',answer='$atc_answer',ifshare='$atc_ifshare',difficult='$atc_difficult',star='$atc_star' WHERE id='$id' AND uid='$lfjuid'");

	refreshto("?job=list","修改成功");

}

?>