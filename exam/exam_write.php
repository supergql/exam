<?php
require("global.php");

$rsdb=$db->get_one("SELECT F.*,S.name AS fname FROM {$_pre}form F LEFT JOIN {$_pre}sort S ON F.fid=S.fid WHERE F.id='$id'");

if(!$rsdb){
	showerr("���ݲ�����!");
}

$fid = $rsdb[fid];
if($rsdb[iftruename]&&!$truename) $rsu=$db->get_one("SELECT truename FROM {$pre}memberdata WHERE uid='$lfjuid'");
if($rsu) $truename=$rsu[truename];

//������
@include(Mpath."data/guide_fid.php");

if($rsdb[ifclose]&&!$web_admin){
	showerr("�Ծ��ѹر�,�����Բ鿴!");
}elseif($rsdb[begintime]&&$timestamp<$rsdb[begintime]){
	showerr("�Ծ�û����,�����Բ鿴!");
}elseif($rsdb[endtime]&&$timestamp>$rsdb[endtime]){
	showerr("�Ծ��ѹ���,�����Բ鿴!");
}elseif($rsdb[money]>0&&$rsdb[money]>get_money($lfjdb[uid])){
	showerr("��Ҫ�շ�{$rsdb[money]}{$webdb[MoneyDW]},�����Բ鿴!");
}elseif($rsdb[allowjoin]&&!in_array($groupdb[gid],explode(',',$rsdb[allowjoin]))){
	showerr("�������û���,�����Բ鿴!");
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

//�ύ�Ծ�
if($action=="postAnswer")
{

	if(!$lfjuid){
		showerr("���ȵ�¼!");
	}else{
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}student WHERE form_id='$id' AND student_uid='$lfjuid'"));
		if($NUM>0){
			showerr("���Ѿ��μӹ���{$rsdb[name]}���Ŀ��ԣ������ؿ���Ч��");
		}
	}

	if($rsdb[totaltime]&&$webdb[totaltime]){
		$rs=$db->get_one("SELECT jointime FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id' ORDER BY jointime DESC LIMIT 1");
		if(($timestamp-$rs[jointime])+5>$rsdb[totaltime]*60){
			showerr("���Ѿ�����ʱ����,�����ύ�Ծ�,�涨��{$rsdb[totaltime]}����!");
		}
	}

	//��ȡÿ�����͵ķ����Ƕ���
	$query = $db->query("SELECT COUNT(A.type) AS num,A.type FROM `{$_pre}form_element` E LEFT JOIN {$_pre}title A ON E.title_id=A.id WHERE E.form_id='$id' GROUP BY A.type");
	while($rs = $db->fetch_array($query)){
		$_L[$rs[type]]=$config[fendb][$rs[type]]/$rs[num];
	}
	
	//�����û�����.֤ʵ�ѿ���,�ο͵Ļ�,ֻ�����ǲμӵ����
	$student_name=$lfjid?$lfjid:$onlineip;	
	if($truename) $db->query("UPDATE `{$pre}memberdata` SET truename='$truename' WHERE uid='$lfjuid'");
	$db->query("INSERT INTO `{$_pre}student` (`student_uid`, `form_id`, `student_name`,`student_truename`,`aclass`,`number`,`posttime`) VALUES ('$lfjuid','$id','$student_name','$truename','$aclass','$number','$timestamp')");
	$student_id=$db->insert_id();
	
	$total_fen=$total_num=0;
	$query = $db->query("SELECT A.* FROM `{$_pre}form_element` E LEFT JOIN `{$_pre}title` A ON E.title_id=A.id WHERE E.form_id='$id' ");
	while($rs = $db->fetch_array($query)){
		if( $answerdb[$rs[id]]!='' ){
			
			//��ѡ��
			if(is_array($answerdb[$rs[id]])){
				$answer=implode("\n",$answerdb[$rs[id]]);
			}else{
				$answer=$answerdb[$rs[id]];
			}

			$fen=0;
			//�����Ծ����͵���Ŀ,�������͵���Ŀ����ֱ�ӵó�����,
			if( ereg("^(1|2|3|4|5|6)$",$rs[type]) ){
				//�����Ҫ�ر���
				if($rs[type]==4){
					//ÿ���һ���𰸶�Ҫ����
					$array=explode("\r\n",$rs[answer]);
					$each_fen=$_L[$rs[type]]/count($array);
					foreach($array AS $key=>$value){
						if(trim($value)==trim($answerdb[$rs[id]][$key])){
							$fen+=$each_fen;
						}
					}					
				}elseif($rs[type]==2){
					//��ѡ����,���ô𰸵�ʱ��.�����ܴ���,ֻѡ�в��ֵĸ�һ���,һ���д�.������
					if(trim($rs[answer])==implode(",",$answerdb[$rs[id]])){
						$fen=$_L[$rs[type]];
					}elseif($answerdb[$rs[id]]){
						$fen=$_L[$rs[type]]/2;
						$answer_array=explode(",",$rs[answer]);
						foreach( $answerdb[$rs[id]] AS $value){
							if(!in_array($value,$answer_array)){
								$fen=0;							//һ���д�.������
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

			//��ֹ�в���ȫ����
			$answer = preg_replace('/javascript/i','java script',$answer);
			$answer = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$answer);
			$db->query("INSERT INTO `{$_pre}student_title` ( `student_id`, `title_id`, `form_id`, `answer`, `fen` ) VALUES ('$student_id','$rs[id]','$id','$answer','$fen' )");
		}
	}
	$total_fen = ceil($total_fen);
	$totaltime = $timestamp-$_COOKIE[star_time];	//��������ʱ��
	$db->query("UPDATE `{$_pre}student` SET total_fen='$total_fen',totaltime='$totaltime' WHERE student_id='$student_id'");
	
	if($rsdb[totaltime]){
		$db->query("DELETE FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id'");
	}
	
	if($rsdb[money]>0){
		add_user($lfjuid,-$rsdb[money],'�μӿ��Կ۷�');
	}

	$db->query("UPDATE `{$_pre}form` SET joins=joins+1 WHERE id='$id'");

	if($rsdb[hidefen]){
		refreshto("$webdb[www_url]/","����Ծ����ύ,��ȴ�����Ա���ĺ�������ճɼ�!",60);
	}else{
		refreshto("$webdb[www_url]/","���ڱ��ο�����,���еĿ͹��⹲���{$total_num}��,�����ܷ���:{$total_fen}��",60);
	}
}

unset($listdb);
$query = $db->query("SELECT T.* FROM `{$_pre}form_element` E LEFT JOIN `{$_pre}title` T ON E.title_id=T.id WHERE E.form_id='$id' ORDER BY E.list DESC,E.element_id ASC ");
while($rs = $db->fetch_array($query)){
	//������Щ����ѱ�ɾ��
	if(!$rs[id]){
		continue;
	}
	$rs[showcontent]='';
	//��ѡ��
	if($rs[type]==1){
		$detail=explode("\r\n",$rs[config]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			$black=strlen($value)>20?'<br>':'&nbsp;&nbsp;&nbsp;';
			$_v=chr(97+$key);
			$rs[showcontent].="<input type='radio' name='answerdb[$rs[id]]' value='$_v'  style='border:0px;'> {$letterDB[$key]}��{$value} $black";
		}
	//��ѡ��
	}elseif($rs[type]==2){
		$detail=explode("\r\n",$rs[config]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			$black=strlen($value)>20?'<br>':'&nbsp;&nbsp;&nbsp;';
			$_v=chr(97+$key);
			$rs[showcontent].="<input type='checkbox' name='answerdb[{$rs[id]}][]' value='$_v' style='border:0px;'> {$letterDB[$key]}��{$value} $black";
		}
	//�ж���
	}elseif($rs[type]==3){
		$detail=array('��ȷ','����');
		foreach( $detail AS $key=>$value){
			$_v=chr(97+$key);
			$rs[showcontent].="<input type='radio' name='answerdb[$rs[id]]' value='$_v'  style='border:0px;'> {$letterDB[$key]}��{$value} &nbsp;&nbsp;&nbsp;";
		}
	//�����
	}elseif($rs[type]==4){
		$rs[question]=preg_replace("/\(([ ��]*)\)/is","(<input type='text' name='answerdb[$rs[id]][]' style='border:0px;border-bottom:1px solid #ccc;width:70px;text-align:center;'>)",$rs[question]);
		if(!strstr($rs[question],'answerdb[')){
			$rs[question].="<br>��:";
			$detail=explode("\r\n",$rs[answer]);
			foreach($detail AS $value){
				if(trim($value)){
					$rs[question].="<input type='text' name='answerdb[$rs[id]][]' style='border:0px;border-bottom:1px solid #ccc;width:120px;'>��";
				}
			}
		}
	//������
	}elseif($rs[type]==5){
		$detail=explode("\r\n",$rs[config]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			$rs[showcontent].="{$letterDB[$key]}��$value<BR>";
		}
		$rs[showcontent].="��:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:270px;'>";
	//�����
	}elseif($rs[type]==7){
		$rs[showcontent].="��:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:370px;'>";
	//�ʴ���,������
	}elseif($rs[type]==8||$rs[type]==9){
		$rs[showcontent].="��:<textarea name='answerdb[$rs[id]]' cols='65' rows='10'></textarea>";
	//��������,�������
	}else{
		$rs[showcontent].="��:<input type='text' name='answerdb[$rs[id]]' style='border:0px;border-bottom:1px solid #ccc;width:170px;'>";
	}
	$rs[question]=En_TruePath($rs[question],0);
	$listdb[$rs[type]][]=$rs;
}
ksort($listdb);
if(count($listdb)<1){
	showerr('��ǰ�Ծ�û������!');
}

if($rsdb[totaltime]){
	$rs = $db->get_one("SELECT * FROM `{$_pre}cache` WHERE `uid`='$lfjuid' AND `form_id`='$id' ORDER BY jointime DESC LIMIT 1");
	if($timestamp-$rs[jointime]<$rsdb[totaltime]*60){
		$times=$rsdb[totaltime]-(($timestamp-$rs[jointime])/60);
		$fz=floor($times);
		$mz=ceil(($times*60)-($fz*60));
		$times=$fz.'��'.$mz.'��';
		showerr("��ˢ�¹����������´򿪹���ǰ�Ծ�,{$times}�ڲ������ٽ��뿼��!");
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