<!DOCTYPE HTML>
<html>
<head>
<title>MyJudgeLife Contactor</title>
<meta charset="utf-8">
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
		$jid = $_GET['jid'];
		$lang = $_GET['langtype'];
		$langarr = array("","c","cpp","pas");
		$codeinfo = fopen(JudgeAddr."codeinfo.xml","w");
		fputs($codeinfo,"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
		fputs($codeinfo,"<Code>\n");
		fputs($codeinfo,"<pid>$pid</pid>\n");
		fputs($codeinfo,"<jid>$jid</jid>\n");
		fputs($codeinfo,"<lang>$lang</lang>\n");
		fputs($codeinfo,"</Code>\n");
		fclose($codeinfo);
		$codefile = fopen(JudgeAddr."judge_code.".$langarr[$lang],"w");
		fputs($codefile,base64_decode($code));
		fclose($codefile);
		$cmd = "perl '".JudgeAddr."judge_run.pl' >/home/lin/error.txt 2>&1";
		system($cmd);
		echo ("Status:0;Successfully Started Judging!");
	} elseif ($controller="update") {
		$msgs=$_POST['msgs'];
		$stat=$_POST['stat'];
		$jid =$_POST['jid'];
		$ch = curl_init();
		$curl_url = APIAddr;
		$postfield = "controller=UPDATE&id=".ServerID."&name=".ServerName."&pass=".ServerPass."&msgs=$msgs&stat=$stat&jid=$jid";
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$curl_result = curl_exec($ch);
		echo("Status:0;Successfully Updated Status!");
	}
?>
</pre>
</body>
</html>