<?php
	/** MyJudgeLife
		操作文件
		
		ORZ WJMZBMR
		
		ORZ plantvsbird
		ORZ lin_toto		
	*/
	
	require_once("judge_header.php");
	if (!isset($_GET['name'])) {
		die ("MyJudgeLife Access Denied: Illigal Access");
	}
	$jmname = base64_encode($_GET['name']);
	$jmpass = sha1(md5(sha1($_GET['pass'])));
	//因为都被加密过了，所以不用担心注入问题
	
	$jid = $_GET['jid'];
	$stat = $_GET['stat'];
	
	//确认身份
	
	$query = mysql_query("SELECT * FROM judge_machines WHERE name=".$name." AND pass=".$pass);
	$num = mysql_num_rows($query);
	if ($num<1) {
		die ("MyJudgeLife Access Denied: Illigal Access");
	}
?>