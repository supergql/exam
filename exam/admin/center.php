<?php
function_exists('html') OR exit('ERR');

//$linkdb=array("核心设置"=>"center.php?job=config");

if($job)
{
	$query=$db->query(" select * from {$_pre}config ");
	while( $rs=$db->fetch_array($query) ){
		$webdb[$rs[c_key]]=$rs[c_value];
	}
}
if($job=="label" && ck_power('center_label')){
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$Murl/index.php?jobs=show'>";
	exit;
}
elseif($job=="config" && ck_power('center_config'))
{
	$module_close[intval($webdb[module_close])]=" checked ";
	$showNoPassComment[intval($webdb[showNoPassComment])]=' checked ';

	$webdb[Info_webOpen]?$Info_webOpen1='checked':$Info_webOpen0='checked';
	$Info_webOpen[intval($webdb[Info_webOpen])]=' checked ';

	$Info_delpaper[intval($webdb[Info_delpaper])]=' checked ';
	$totaltime[intval($webdb[totaltime])]=' checked ';
	
	get_admin_html('config');
}


elseif($action=="config" && ck_power('center_config'))
{
	if( isset($webdbs[Info_webadmin]) ){
		$webdbs[Info_webadmin]=filtrate($webdbs[Info_webadmin]);
		$db->query("UPDATE {$pre}module SET adminmember='$webdbs[Info_webadmin]' WHERE id='$webdb[module_id]'");
	}
	if( isset($webdbs[Info_weburl]) ){
		$webdbs[Info_weburl]=filtrate($webdbs[Info_weburl]);
		$db->query("UPDATE {$pre}module SET domain='$webdbs[Info_weburl]' WHERE id='$webdb[module_id]'");
	}

	module_write_config_cache($webdbs);
	refreshto($FROMURL,"修改成功");
}

?>