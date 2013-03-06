<?php
!function_exists('html') && exit('ERR');

ck_power('exam_form');
//创建表单
if($job=="make")
{
	$sort_fid=$Guidedb->Select("{$_pre}sort","fid");

	$iftruename[1]=' checked ';
	$ifclass[1]=' checked ';
	$ifnumber[1]=' checked ';
	$ifsharedb[0]=' checked ';
	$typedb[1]=' checked ';
	$ifclose[0]=' checked ';
	$hidefen[0]=' checked ';

	$groups=group_box("atc_allowjoin");

	$sort=$Guidedb->Select("{$_pre}sort","atc_fid");
	
	get_admin_html('make');
}
//创建表单
elseif($action=="make")
{
	if(!$fid){
		showerr("请选择分类");
	}
	$rs=$db->get_one("SELECT name,class,type FROM {$_pre}sort WHERE fid='$fid' ");
	if($rs[type]){
		showmsg('分类只能选择终结栏目!');
	}

	$atc_begintime && $atc_begintime=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$atc_begintime);
	$atc_endtime && $atc_endtime=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$atc_endtime);

	$atc_allowjoin=implode(",",$atc_allowjoin);
	
	$db->query("INSERT INTO `{$_pre}form` (`type`, `fid`, `name`, `uid`, `username`, `ifshare`, `ifclose` , `creattime` , `recommend` , `yz` , `joins` , `money` , `iftruename` , `ifclass` , `ifnumber` , `totaltime` , `allowjoin` , `begintime` , `endtime` , `hidefen`) VALUES ('$atc_type','$fid','$atc_name','$userdb[uid]','$userdb[username]','$atc_ifshare', '$atc_ifclose' , '$timestamp' , '0' , '1' , '0' , '$atc_money' , '$atc_iftruename' , '$atc_ifclass' , '$atc_ifnumber' , '$atc_totaltime' , '$atc_allowjoin' , '$atc_begintime' , '$atc_endtime' , '$atc_hidefen')");
	
	$id=$db->insert_id();
	$SQL='';
	if($atc_fid){
		$SQL=" AND fid='$atc_fid'";
	}
	$array='';
	foreach( $numdb AS $key=>$value){
		if($value<1){
			continue;
		}
		$array[fendb][$key]=$fendb[$key];
		$query = $db->query("SELECT * FROM {$_pre}title WHERE type='$key'$SQL ORDER BY rand() LIMIT $value");
		while($rs = $db->fetch_array($query)){
			$db->query("INSERT INTO {$_pre}form_element SET form_id='$id',title_id='$rs[id]'");
		}
	}
	$s=addslashes(serialize($array));
	$db->query("UPDATE `{$_pre}form` SET config='$s' WHERE id='$id'");
 	jump("创建成功","$admin_path&job=list",1);
}

elseif($job=='com')
{
	$db->query("UPDATE `{$_pre}form` SET recommend='$com' WHERE id='$id'");
	jump("设置成功","$admin_path&job=list",0);
}

//列出表单信息
elseif($job=="list")
{
	if($page<1){
		$page=1;
	}
	$rows=50;
	$min=($page-1)*$rows;
	$SQL='';

	if($fid){
		$SQL=" WHERE A.fid='$fid' ";
	}

	$query = $db->query("SELECT A.*,S.name AS fname FROM `{$_pre}form` A LEFT JOIN `{$_pre}sort` S ON A.fid=S.fid $SQL ORDER BY A.id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rs[formtype]=$rs[type]==1?'试卷':'调查表';
		if($rs[recommend]){
			$rs[com]="<a href='$admin_path&job=com&com=0&id=$rs[id]' style='color:red;'>已推荐</a>";
		}else{
			$rs[com]="<a href='$admin_path&job=com&com=1&id=$rs[id]'>未推荐</a>";
		}
		$listdb[]=$rs;
	}
	
	$showpage=getpage("`{$_pre}form` A","$SQL","$admin_path&job=$job&fid=$fid","$rows");

	get_admin_html('list');
}

//删除表单
elseif($action=="delete")
{
	$db->query(" DELETE FROM `{$_pre}form` WHERE id='$id' ");
	$db->query(" DELETE FROM `{$_pre}form_element` WHERE form_id='$id' ");
	$db->query(" DELETE FROM `{$_pre}student_title` WHERE form_id='$id' ");
	$db->query(" DELETE FROM `{$_pre}student` WHERE form_id='$id' ");
	jump("删除成功",$FROMURL,1);
}

//修改表单
elseif($job=="edit")
{

	$rsdb=$db->get_one("SELECT * FROM {$_pre}form WHERE id='$id'");

	$sort_fid=$Guidedb->Select("{$_pre}sort","fid",$rsdb[fid]);

	$ifsharedb[$rsdb[ifshare]]=' checked ';
	$typedb[$rsdb[type]]=' checked ';


	$iftruename[$rsdb[iftruename]]=' checked ';
	$ifclass[$rsdb[ifclass]]=' checked ';
	$ifnumber[$rsdb[ifnumber]]=' checked '; 
	$ifclose[$rsdb[ifclose]]=' checked ';
	$hidefen[$rsdb[hidefen]]=' checked ';

	$rsdb[begintime] = $rsdb[begintime]?date('Y-m-d H:i:s',$rsdb[begintime]):'';
	$rsdb[endtime] = $rsdb[endtime]?date('Y-m-d H:i:s',$rsdb[endtime]):'';

	$groups=group_box("atc_allowjoin",explode(',',$rsdb[allowjoin]));

	get_admin_html('make');
}

//修改表单
elseif($action=='edit')
{

	$rs=$db->get_one("SELECT name,class,type FROM {$_pre}sort WHERE fid='$fid' ");
	if($rs[type]){
		showmsg('分类只能选择终结栏目!');
	}

	$atc_begintime && $atc_begintime=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$atc_begintime);
	$atc_endtime && $atc_endtime=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$atc_endtime);

	$atc_allowjoin=implode(',',$atc_allowjoin);
	$db->query("UPDATE `{$_pre}form` SET type='$atc_type',fid='$fid',name='$atc_name',ifshare='$atc_ifshare',ifclose='$atc_ifclose',hidefen='$atc_hidefen',allowjoin='$atc_allowjoin',begintime='$atc_begintime',endtime='$atc_endtime',money='$atc_money',iftruename='$atc_iftruename',ifclass='$atc_ifclass',ifnumber='$atc_ifnumber',totaltime='$atc_totaltime' WHERE id='$id'");
	jump("修改成功",$FROMURL,1);
}


//考生答题对比分析统计
elseif($job=="viewstat")
{
	$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM `{$_pre}form` F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

	$titledb=$db->get_one("SELECT * FROM `{$_pre}title` WHERE id='$title_id'");
	
	$config="";
	if($titledb[type]==3){
		$titledb[config]="正确\r\n错误";
	}
	$array=explode("\r\n",$titledb[config]);
	foreach($array AS $key=>$value){
		$value && $config.=chr($key+97)."、$value &nbsp;&nbsp;&nbsp;";
	}
	
	$titledb[question]=En_TruePath($titledb[question],0);

	$totalman=0;

	//单选题,多选题,判断题
	if($titledb[type]<4){
		$query = $db->query("SELECT `answer` , COUNT( * ) AS NUM FROM `{$_pre}student_title` WHERE `form_id` ='$id' AND `title_id` ='$title_id' GROUP BY `answer` ");
		while($rs = $db->fetch_array($query)){
			$statshow.=str_replace("\n",",",$rs[answer])."  ($rs[NUM])人 <br>";
			$totalman+=$rs[NUM];
		}
	}else{
		$query = $db->query("SELECT `answer` FROM `{$_pre}student_title` WHERE `form_id` ='$id' AND `title_id` ='$title_id'");
		while($rs = $db->fetch_array($query)){
			$totalman++;
			$statshow.=str_replace("\n","<br>",$rs[answer])."<hr>";
		}
	}

	
	get_admin_html('viewstat');
}

//考生答题对比分析统计
elseif($job=="stat")
{
	$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM `{$_pre}form` F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

	$query = $db->query("SELECT E.element_id,E.list,T.*,S.name AS fname FROM `{$_pre}form_element` E LEFT JOIN `{$_pre}title` T ON E.title_id=T.id LEFT JOIN `{$_pre}sort` S ON T.fid=S.fid WHERE E.form_id='$id' ORDER BY E.list DESC,E.element_id ASC ");
	while($rs = $db->fetch_array($query)){
		
		$rs[question]=En_TruePath($rs[question],0);
		$listdb[]=$rs;
	}
	
	get_admin_html('stat');
}

//表单题库管理
elseif($job=="manage")
{
	$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM `{$_pre}form` F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");
	$config=@unserialize($rsdb[config]);

	$query = $db->query("SELECT E.element_id,E.list,T.*,S.name AS fname FROM `{$_pre}form_element` E LEFT JOIN `{$_pre}title` T ON E.title_id=T.id LEFT JOIN `{$_pre}sort` S ON T.fid=S.fid WHERE E.form_id='$id' ORDER BY E.list DESC,E.element_id ASC ");
	while($rs = $db->fetch_array($query)){
		
		//分数处理,不同的类型,如单选,多选,填空,可以控制不同的分数
		$num[$rs[type]]++;
		$subjectDB[$rs[type]]=array(
			'name'=>$paperType[$rs[type]],
			'num'=>$num[$rs[type]],
			'fen'=>$config[fendb][$rs[type]]
		);
		$rs[question]=En_TruePath($rs[question],0);
		$listdb[]=$rs;
	}
	ksort($subjectDB);
	
	get_admin_html('manage');
}

//表单题目排序
elseif($action=="manage")
{
	foreach( $orderdb AS $key=>$value){
		$db->query("UPDATE `{$_pre}form_element` SET list='$value' WHERE element_id='$key'");
	}
	jump("修改成功",$FROMURL,1);
}

//表单分数设置
elseif($action=="fen")
{
	$rsdb=$db->get_one("SELECT * FROM `{$_pre}form` WHERE id='$id'");
	$config=@unserialize($rsdb[config]);
	$config[fendb]=$listdb;
	$str_config=addslashes(serialize($config));
	$db->query("UPDATE `{$_pre}form` SET config='$str_config' WHERE id='$id'");
	jump("修改成功",$FROMURL,1);
}

//表单移除某些题目
elseif($action=="remove")
{
	$db->query("DELETE FROM `{$_pre}form_element` WHERE element_id='$element_id'");
	$db->query("DELETE FROM `{$_pre}student_title` WHERE title_id='$title_id'");
	jump("移除成功",$FROMURL);
}

//打印试卷
elseif($job=='print')
{
	$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

	$config=@unserialize($rsdb[config]);

	unset($listdb);
	$query = $db->query("SELECT T.* FROM `{$_pre}form_element` E LEFT JOIN `{$_pre}title` T ON E.title_id=T.id WHERE E.form_id='$id' ORDER BY E.list DESC,E.element_id ASC ");
	while($rs = $db->fetch_array($query)){
		//处理有些题库已被删除
		if(!$rs[id]){
			continue;
		}
		$rs[showcontent]='';
		//单选题
		if($rs[type]==1){
			$detail=explode("\r\n",$rs[config]);
			foreach( $detail AS $key=>$value){
				if($value===''){
					continue;
				}
				$black=strlen($value)>20?'<br>':'&nbsp;&nbsp;&nbsp;';
				$_v=chr(97+$key);
				$rs[showcontent].=" {$letterDB[$key]}、{$value} $black";
			}
			$rs[showcontent].="<br>答:(<input type='text' style='border:0px;border-bottom:1px solid #ccc;width:50px;text-align:center;'>)<br><br>";
		//多选题
		}elseif($rs[type]==2){
			$detail=explode("\r\n",$rs[config]);
			foreach( $detail AS $key=>$value){
				if($value===''){
					continue;
				}
				$black=strlen($value)>20?'<br>':'&nbsp;&nbsp;&nbsp;';
				$_v=chr(97+$key);
				$rs[showcontent].=" {$letterDB[$key]}、{$value} $black";				
			}
			$rs[showcontent].="<br>答:(<input type='text' style='border:0px;border-bottom:1px solid #ccc;width:50px;text-align:center;'>)<br><br>";
		//判断题
		}elseif($rs[type]==3){
			$detail=array('正确','错误');
			foreach( $detail AS $key=>$value){
				$_v=chr(97+$key);
				$rs[showcontent].="{$letterDB[$key]}、{$value} &nbsp;&nbsp;&nbsp;";
			}
			$rs[showcontent].="<br>答:(<input type='text' style='border:0px;border-bottom:1px solid #ccc;width:50px;text-align:center;'>)<br><br>";
		//填空题
		}elseif($rs[type]==4){
			$rs[question]=preg_replace("/\(([ 　]*)\)/is","(<input type='text' name='answerdb[$rs[id]][]' style='border:0px;border-bottom:1px solid #ccc;width:70px;text-align:center;'>)",$rs[question]);
			if(!strstr($rs[question],'answerdb[')){
				$rs[question].="<br>答:";
				$detail=explode("\r\n",$rs[answer]);
				foreach($detail AS $value){
					if(trim($value)){
						$rs[question].="<input type='text' name='answerdb[$rs[id]][]' style='border:0px;border-bottom:1px solid #ccc;width:120px;'>，";
					}
				}
			}
		//排序题
		}elseif($rs[type]==5){
			$detail=explode("\r\n",$rs[config]);
			foreach( $detail AS $key=>$value){
				if($value===''){
					continue;
				}
				$rs[showcontent].="{$letterDB[$key]}、$value<BR>";
			}
			$rs[showcontent].="答:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:270px;'>";
		//简答题
		}elseif($rs[type]==7){
			$rs[showcontent].="答:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:370px;'>";
		//问答题,作文题
		}elseif($rs[type]==8||$rs[type]==9){
			$rs[showcontent].="答:<br><br><br><br><br><br><br><br><br>";
		//其它题型,如计算题
		}else{
			$rs[showcontent].="答:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:170px;'>";
		}
		$rs[question]=En_TruePath($rs[question],0);
		$listdb[$rs[type]][]=$rs;
	}
	ksort($listdb);

	require_once(dirname(__FILE__)."/template/exam_form/print.htm");
}

?>