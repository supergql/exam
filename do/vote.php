<?php
$PHP_SELF_TEMP=$_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$_SERVER['QUERY_STRING'] && $PHP_SELF_TEMP .= "?".$_SERVER['QUERY_STRING'];
$PHP_SELF=$_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:$PHP_SELF_TEMP;
$HTTP_HOST=$_SERVER['HTTP_HOST']?$_SERVER['HTTP_HOST']:$HTTP_SERVER_VARS['HTTP_HOST'];
$WEBURL='http://'.$HTTP_HOST.$PHP_SELF;
header("location:../vote/vote.php".strstr($WEBURL,'?'));

?>