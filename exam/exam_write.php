<?php
require("global.php");

$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

if(!$rsdb){
	showerr("数据不存在!");
}

$fid = $rsdb[fid];
if($rsdb[iftruename]&&!$truename) $rsu=$db->get_one("SELECT truename FROM {$pre}memberdata WHERE uid='$lfjuid'");
if($rsu) $truename=$rsu[truename];

//导航条
@include(Mpath."data/guide_fid.php");

if($rsdb[ifclose]&&!$web_admin){
	showerr("试卷已关闭,不可以查看!");
}elseif($rsdb[begintime]&&$timestamp<$rsdb[begintime]){
	showerr("试卷还没开放,不可以查看!");
}elseif($rsdb[endtime]&&$timestamp>$rsdb[endtime]){
	showerr("试卷已过期,不可以查看!");
}elseif($rsdb[money]>0&&$rsdb[money]>get_money($lfjdb[uid])){
	showerr("需要收费{$rsdb[money]}{$webdb[MoneyDW]},不可以查看!");
}elseif($rsdb[allowjoin]&&!in_array($groupdb[gid],explode(',',$rsdb[allowjoin]))){
	showerr("你所在用户组,不可以查看!");
}elseif((((!$rsdb[iftruename]&&!$truename)||(!$rsdb[ifclass]&&!$aclass)||(!$rsdb[ifnumber]&&!$number))||$login_edit)&&!$web_admin){
	require(getTpl("write_login"));
	exit; 
}

$config=@unserialize($rsdb[config]);

$examtotalfen=0;
foreach($config[fendb] AS $f){
	$examtotalfen +=abs($f);
}

//SEO
$titleDB[title]		= "$rsdb[name] - $rsdb[fname] - $titleDB[title]";

//提交试卷
if($action=="postAnswer")
{

	if(!$lfjuid){
		showerr("请先登录!");
	}else{
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}student WHERE form_id='$id' AND student_uid='$lfjuid'"));
		if($NUM>0){
			showerr("你已经参加过《{$rsdb[name]}》的考试，本次重考无效！");
		}
	}

	if($rsdb[totaltime]&&$webdb[totaltime]){
		$rs=$db->get_one("SELECT jointime FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id' ORDER BY jointime DESC LIMIT 1");
		if(($timestamp-$rs[jointime])+5>$rsdb[totaltime]*60){
			showerr("你已经超过时间了,不能提交试卷,规定是{$rsdb[totaltime]}分钟!");
		}
	}

	//获取每种题型的分数是多少
	$query = $db->query("SELECT COUNT(A.type) AS num,A.type FROM `{$_pre}form_element` E LEFT JOIN {$_pre}title A ON E.title_id=A.id WHERE E.form_id='$id' GROUP BY A.type");
	while($rs = $db->fetch_array($query)){
		$_L[$rs[type]]=$config[fendb][$rs[type]]/$rs[num];
	}
	
	//插入用户资料.证实已考试,游客的话,只考虑是参加调查表单
	$student_name=$lfjid?$lfjid:$onlineip;	
	if($truename) $db->query("UPDATE `{$pre}memberdata` SET truename='$truename' WHERE uid='$lfjuid'");
	$db->query("INSERT INTO `{$_pre}student` (`student_uid`, `form_id`, `student_name`,`student_truename`,`aclass`,`number`,`posttime`) VALUES ('$lfjuid','$id','$student_name','$truename','$aclass','$number','$timestamp')");
	$student_id=$db->insert_id();
	
	$total_fen=$total_num=0;
	$query = $db->query("SELECT A.* FROM `{$_pre}form_element` E LEFT JOIN `{$_pre}title` A ON E.title_id=A.id WHERE E.form_id='$id' ");
	while($rs = $db->fetch_array($query)){
		if( $answerdb[$rs[id]]!='' ){
			
			//多选题
			if(is_array($answerdb[$rs[id]])){
				$answer=implode("\n",$answerdb[$rs[id]]);
			}else{
				$answer=$answerdb[$rs[id]];
			}

			$fen=0;
			//对于试卷类型的题目,这种类型的题目可以直接得出分数,
			if( ereg("^(1|2|3|4|5|6)$",$rs[type]) ){
				//填空题要特别处理
				if($rs[type]==4){
					//每答对一个答案都要给分
					$array=explode("\r\n",$rs[answer]);
					$each_fen=$_L[$rs[type]]/count($array);
					foreach($array AS $key=>$value){
						if(trim($value)==trim($answerdb[$rs[id]][$key])){
							$fen+=$each_fen;
						}
					}					
				}elseif($rs[type]==2){
					//多选题中,设置答案的时候.排序不能打乱,只选中部分的给一半分,一旦有错.不给分
					if(trim($rs[answer])==implode(",",$answerdb[$rs[id]])){
						$fen=$_L[$rs[type]];
					}elseif($answerdb[$rs[id]]){
						$fen=$_L[$rs[type]]/2;
						$answer_array=explode(",",$rs[answer]);
						foreach( $answerdb[$rs[id]] AS $value){
							if(!in_array($value,$answer_array)){
								$fen=0;							//一旦有错.不给分
							}
						}
					}
				}elseif(trim($answer)==trim($rs[answer])){
					$fen=$_L[$rs[type]];
				}
				if($fen){
					$total_num++;
					$total_fen+=$fen;
				}
			}

			//防止有不安全代码
			$answer = preg_replace('/javascript/i','java script',$answer);
			$answer = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$answer);
			$db->query("INSERT INTO `{$_pre}student_title` ( `student_id`, `title_id`, `form_id`, `answer`, `fen` ) VALUES ('$student_id','$rs[id]','$id','$answer','$fen' )");
		}
	}
	$total_fen = ceil($total_fen);
	$totaltime = $timestamp-$_COOKIE[star_time];	//考试所花时间
	$db->query("UPDATE `{$_pre}student` SET total_fen='$total_fen',totaltime='$totaltime' WHERE student_id='$student_id'");
	
	if($rsdb[totaltime]){
		$db->query("DELETE FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id'");
	}
	
	if($rsdb[money]>0){
		add_user($lfjuid,-$rsdb[money],'参加考试扣分');
	}

	$db->query("UPDATE `{$_pre}form` SET joins=joins+1 WHERE id='$id'");

	if($rsdb[hidefen]){
		refreshto("$webdb[www_url]/","你的试卷已提交,请等待管理员批阅后才有最终成绩!",60);
	}else{
		refreshto("$webdb[www_url]/","你在本次考试中,其中的客观题共答对{$total_num}题,所得总分是:{$total_fen}分",60);
	}
}

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
			$rs[showcontent].="<input type='radio' name='answerdb[$rs[id]]' value='$_v'  style='border:0px;'> {$letterDB[$key]}、{$value} $black";
		}
	//多选题
	}elseif($rs[type]==2){
		$detail=explode("\r\n",$rs[config]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			$black=strlen($value)>20?'<br>':'&nbsp;&nbsp;&nbsp;';
			$_v=chr(97+$key);
			$rs[showcontent].="<input type='checkbox' name='answerdb[{$rs[id]}][]' value='$_v' style='border:0px;'> {$letterDB[$key]}、{$value} $black";
		}
	//判断题
	}elseif($rs[type]==3){
		$detail=array('正确','错误');
		foreach( $detail AS $key=>$value){
			$_v=chr(97+$key);
			$rs[showcontent].="<input type='radio' name='answerdb[$rs[id]]' value='$_v'  style='border:0px;'> {$letterDB[$key]}、{$value} &nbsp;&nbsp;&nbsp;";
		}
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
		$rs[showcontent].="答:<textarea name='answerdb[$rs[id]]' cols='65' rows='10'></textarea>";
	//其它题型,如计算题
	}else{
		$rs[showcontent].="答:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:170px;'>";
	}
	$rs[question]=En_TruePath($rs[question],0);
	$listdb[$rs[type]][]=$rs;
}
ksort($listdb);
if(count($listdb)<1){
	showerr('当前试卷还没有试题!');
}

if($rsdb[totaltime]){
	$rs = $db->get_one("SELECT * FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id' ORDER BY jointime DESC LIMIT 1");
	if($timestamp-$rs[jointime]<$rsdb[totaltime]*60){
		$times=$rsdb[totaltime]-(($timestamp-$rs[jointime])/60);
		$fz=floor($times);
		$mz=ceil(($times*60)-($fz*60));
		$times=$fz.'分'.$mz.'秒';
		showerr("你刷新过或者是重新打开过当前试卷,{$times}内不可以再进入考场!");
	}
	$db->query("DELETE FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id'");
	$db->query("INSERT INTO `{$_pre}cache` ( `uid` , `form_id` , `jointime` ) VALUES ('$lfjuid', '$id', '$timestamp')");
}

$db->query("UPDATE `{$_pre}form` SET hits=hits+1 WHERE id='$id'");

$begintime = date('Y-m-d H:i:s',$timestamp);

setcookie("star_time",$timestamp);

require(ROOT_PATH."inc/head.php");
require(getTpl("exam_write"));
require(ROOT_PATH."inc/foot.php");
?>