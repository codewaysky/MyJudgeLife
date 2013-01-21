<!DOCTYPE HTML>
<html>
<head>
<title>MyJudgeLife Contactor</title>
</head>
<body>
<pre>
<?php
	require_once("judge_header.php");
	$pass = $_GET['pass'];
	$controller = $_GET['controller'];
	if ($pass != ServerPass) {
		die ("Access Deined\n");
	} else {
		echo ("Access Granted\n");
	}
	
	if ($controller=="stat") {
		if (file_exists(JudgeAddr."running")) {
			echo ("Status:0;BUSY");
		} else {
			echo ("Status:1;IDLE");
		}
	} elseif ($controller=="task") {
		if (file_exists(JudgeAddr."running")) {
			die ("Status:1;System Busy!");
		}
		$code = $_POST['code'];
		$pid = $_GET['pid'];
		$uid = $_GET['uid'];
		$jid = $_GET['jid'];
		$lang = $_GET['langtype'];
		$langarr = array("","c","cpp","pas");
		$codeinfo = fopen(JudgeAddr."codeinfo.xml","w");
		fputs($codeinfo,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>");
		fputs($codeinfo,"<Code>");
		fputs($codeinfo,"<pid>$pid</pid>");
		fputs($codeinfo,"<uid>$uid</uid>");
		fputs($codeinfo,"<jid>$jid</jid>");
		fputs($codeinfo,"<lang>$lang</lang>");
		fputs($codeinfo,"</Code>");
		fclose($codeinfo);
		$codefile = fopen(JudgeAddr."judge_code".$langarr[$lang],"w");
		fputs($codefile,base64_decode($code));
		fclose($codefile);
		$cmd = "perl '".JudgeAddr."judge_run.pl' >/dev/null &";
		exec($cmd);
		echo ("Status:0;Successfully Started Judging!");
	} elseif ($controller="update") {
		
	}
?>
</pre>
</body>
</html>