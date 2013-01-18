<!DOCTYPE HTML>
<html>
<head>
<title>MyJudgeLife Contactor</title>
</head>
<body>
<pre>
<?php
	/** MyJudgeLife
		操作文件
		
		ORZ WJMZBMR
		
		ORZ plantvsbird
		ORZ lin_toto		
	*/
	require_once("judge_header.php");
	if (!isset($_POST['id']))
		if (!is_numeric($_POST['id']))
			die ("MyJudgeLife Access Denied\nReturn Msg: Illigal Access\nStatus 403: Access Denied");
	$jmid = $_POST['id'];
	$jmname = base64_encode($_POST['name']);
	$controller = $_POST['controller'];
	@$jmpass = sha1(md5(sha1($_POST['pass'])));
	
	//因为都被加密过了，所以不用担心注入问题
	
	@$jid = $_POST['jid'];
	@$stat = $_POST['stat'];
	@$msgs = base64_encode($_POST['msgs']);
	
	//确认身份
	
	$query = "SELECT * FROM judge_machine WHERE enable=1 AND id=$jmid AND name='$jmname' AND pass='$jmpass'";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	if ($num<1) {
		die ("MyJudgeLife Access Denied\nReturn Msg: Illigal Access\nStatus 403: Access Denied");
	}

	//身份成功确认
	echo ("MyJudgeLife Access Granted\n");	
	if ($controller=="UPDATE") {
		$query = "UPDATE judge_stat SET jmid=$jmid, stat=$stat, msgs='$msgs' WHERE jid=$jid";
		mysql_query($query);
		echo ("Return Msg: Stat Contact Successful\n");
		echo ("Status 200: OK");
	} elseif ($controller=="QUERY") {
		$query = "SELECT jid,pid,user_code,langtype FROM judge_stat WHERE stat=5 ORDER BY jid LIMIT 1";
		$result=mysql_query($query);
		if (mysql_num_rows($result)==0) {
			echo "Return Msg: Query Successful, No New Jobs.\n";
			die ("Status 200: OK");
		} else {
			$arr = mysql_fetch_array($result);
			echo "Return Msg: Query Successful, There is a new job.\n";
			echo "Extra Material:[id]{$arr['pid']};[langtype]{$arr['langtype']};[code]{$arr['user_code']}\n";
			echo "Status 200: OK";
		}
	} else {
		die ("Unknown Controller\nStatus 500: Unknown Operation");
	}
?>
</pre>
</body>
</html>