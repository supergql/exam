<?php
!function_exists('html') && exit('ERR');

unset($base_menudb,$menudb);

$base_menudb['�鿴��������']['link']='homepage.php';
$base_menudb['�鿴��������']['power']='2';

$base_menudb['�޸ĸ�������']['link']='userinfo.php?job=edit';
$base_menudb['�޸ĸ�������']['power']='2';

$base_menudb['վ�ڶ���Ϣ����']['link']='pm.php?job=list';
$base_menudb['վ�ڶ���Ϣ����']['power']='2';



$menudb['��������']['�޸ĸ�������']['link']='userinfo.php?job=edit';
$menudb['��������']['վ�ڶ���Ϣ']['link']='pm.php?job=list';
$menudb['��������']['���ֳ�ֵ']['link']='money.php?job=list';
$menudb['��������']['�����Ա�ȼ�']['link']='buygroup.php?job=list';
$ModuleDB['hy_'] && $menudb['��������']['��ҵ��Ϣ']['link']='company.php?job=edit';
$menudb['��������']['�����֤']['link']='yz.php?job=email';
$menudb['��������']['�������Ѽ�¼']['link']='moneylog.php?job=list';
$menudb['��������']['����ռ�']['link']='buyspace.php';

 



//��ȡ������ܵĲ˵�
$query = $db->query("SELECT * FROM {$pre}hack ORDER BY list DESC");
while($rs = $db->fetch_array($query)){
	if(is_file(ROOT_PATH."hack/$rs[keywords]/member_menu.php")){
		$array = include(ROOT_PATH."hack/$rs[keywords]/member_menu.php");
		$menudb['�������']["$array[name]"]['link']=$array['url'];
	}
}
?>