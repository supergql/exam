<?php
require("global.php");
@include_once(ROOT_PATH."data/all_area.php");
if(!$uid&&!$username)
{
	$uid=$lfjuid;
}
if($uid)
{
	$rsdb = $userDB->get_info($uid);
}
elseif($username)
{
	$rsdb = $userDB->get_info($username,'name');
}

if(!$rsdb)
{
	showerr("用户不存在");
}

$db->query("UPDATE {$pre}memberdata SET hits=hits+1,lastview='$timestamp' WHERE uid='$uid'");

$rsdb[money]=get_money($rsdb[uid]);


$group_db=$db->get_one("SELECT totalspace,grouptitle FROM {$pre}group WHERE gid='$rsdb[groupid]' ");

//已使用空间
$rsdb[usespace]=number_format($rsdb[usespace]/(1024*1024),3);

//系统允许使用空间
$space_system=number_format($webdb[totalSpace],3);

//用户组允许使用空间
$space_group=number_format($group_db[totalspace],3);

//用户本身具有的空间
$space_user=number_format($rsdb[totalspace]/(1024*1024),3);

//用户余下空间
$rsdb[totalspace]=number_format($webdb[totalSpace]+$group_db[totalspace]+$rsdb[totalspace]/(1024*1024)-$rsdb[usespace],3);

if($rsdb[sex]==1)
{
	$rsdb[sex]='男';
}
elseif($rsdb[sex]==2)
{
	$rsdb[sex]='女';
}
else
{
	$rsdb[sex]='保密';
}

$rsdb[lastvist]=date("Y-m-d H:i:s",$rsdb[lastvist]);
$rsdb[regdate]=date("Y-m-d H:i:s",$rsdb[regdate]);
$rsdb[introduce]=str_replace("\n","<br>",$rsdb[introduce]);

if($lfjuid!=$rsdb[uid]&&!$web_admin)
{
	$rsdb[regip]=$rsdb[address]=$rsdb[postalcode]=$rsdb[telephone]=$rsdb[mobphone]=$rsdb[idcard]=$rsdb[truename]="保密";
}
$rsdb[icon]=tempdir($rsdb[icon]);

$rsdb[lastip]=ipfrom($rsdb[lastip]);

$rsdb[postalcode]==0&&$rsdb[postalcode]='';

$rsdb[lastview]=$rsdb[lastview]?date("Y-m-d H:i",$rsdb[lastview]):'未知';
$rsdb[hits] || $rsdb[hits]='未知';
/*
//我的最新文章
$myarticleDB='';
$query = $db->query("SELECT * FROM {$pre}news_article WHERE mid=0 AND uid='$uid' ORDER BY aid DESC LIMIT 10");
while($rs = $db->fetch_array($query)){
	$myarticleDB[]=$rs;
}

//我的热门文章
$myhotarticleDB='';
$query = $db->query("SELECT * FROM {$pre}news_article WHERE mid=0 AND uid='$uid' ORDER BY hits DESC LIMIT 10");
while($rs = $db->fetch_array($query)){
	$myhotarticleDB[]=$rs;
}

//我的评论
$mycommentDB='';
$query = $db->query("SELECT * FROM {$pre}news_comment WHERE uid='$uid' ORDER BY cid DESC LIMIT 10");
while($rs = $db->fetch_array($query)){
	$mycommentDB[]=$rs;
}

//系统推荐主题
$myotherDB=$comDB='';
$query = $db->query("SELECT * FROM {$pre}news_article ORDER BY levels DESC,levelstime DESC,aid DESC LIMIT 11");
while($rs = $db->fetch_array($query)){
	if(!$comDB){	//今日导读
		$comDB=$rs;
	}else{
		$myotherDB[]=$rs;
	}	
}

//我的图片主题
$myphotoDB='';
$query = $db->query("SELECT * FROM {$pre}news_article WHERE ispic=1 AND uid='$uid' ORDER BY aid DESC LIMIT 6");
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$myphotoDB[]=$rs;
}
*/
//论坛贴子
$mybbsDB='';
if( ereg("^pwbbs",$webdb[passport_type]) ){
	$query = $db->query("SELECT * FROM {$TB_pre}threads WHERE authorid='$uid' ORDER BY tid DESC LIMIT 10");
	while($rs = $db->fetch_array($query)){
		$mybbsDB[]=$rs;
	}
}

//过滤不健康的字
$rsdb[truename]=replace_bad_word($rsdb[truename]);
$rsdb[introduce]=replace_bad_word($rsdb[introduce]);
$rsdb[address]=replace_bad_word($rsdb[address]);

require(get_member_tpl('homepage'));

$content=ob_get_contents();
ob_end_clean();
ob_start();
if($webdb[www_url]=='/.'){
	$content=str_replace('/./','/',$content);
}
echo $content;
?>