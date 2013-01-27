<?php
	require_once('judge_header.php');
	function get_contact_addr($jmid) {
		$query = "SELECT pass,addr FROM judge_machine WHERE id=$jmid";
		$result = mysql_query($query);
		$array = mysql_fetch_array($result);
		$array['pass']=base64_decode($array['pass']);
		return $array['addr']."?pass={$array['pass']}";
	}

	function get_idle_machine() {
		$query = "SELECT id FROM judge_machine_stat WHERE stat=1";
		$result = mysql_query($query);
		$array = Array();
		for($i=0;$row=mysql_fetch_array($result);$i++) $array[$i] = $row['id'];
		return $array[rand(0,count($array)-1)];
	}

	function checkstat() {
		/**
		  * 调用此函数会自动监测评测机器状态是否正常。
		*/
		$query = "SELECT id FROM judge_machine WHERE enable=1;";
		$result = mysql_query($query);
		$query = "SELECT id FROM judge_machine_stat";
		$result2 = mysql_query($query);
		if (mysql_num_rows($result) != mysql_num_rows($result2)) return false; else return true;
	}
	
	function refresh_machine_stat() {
		/**
		  * 此函数用于刷新评测机的状态。
		  * 评测机状态存放在数据库一个Memory引擎的表中。
		  * 所以，若遇到数据库当机，表内容丢失的时候，调用该函数可刷新状态。
		*/
		
		$query = "SELECT id,pass,addr FROM judge_machine WHERE enable=1;";
		$result = mysql_query($query);
		
		while($row = mysql_fetch_array($result)) {
			$row['pass'] = base64_decode($row['pass']);
			$ch = curl_init();
			$curl_url = $row['addr']."?pass={$row['pass']}&controller=stat";
			curl_setopt($ch, CURLOPT_URL, $curl_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$curl_result = curl_exec($ch);
			preg_match("/Status:(\d);/is",$curl_result,$match);
			mysql_query("INSERT INTO judge_machine_stat SET id={$row['id']}, stat={$match[1]} on duplicate key UPDATE stat={$match[1]}");
		}
	}

	function judge_ping($jid) {
		if (!checkstat()) refresh_machine_stat();

		$result = mysql_query("SELECT * FROM judge_stat WHERE jid=$jid");
		$array = mysql_fetch_array($result);
		$curl_url = get_contact_addr(get_idle_machine())."&controller=task&pid={$array['pid']}&langtype={$array['langtype']}&jid=$jid";
		$ch = curl_init();
		$postfield="code=".$array['user_code'];
		curl_setopt($ch, CURLOPT_URL, $curl_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
		$curl_result = curl_exec($ch);
		echo $curl_result;
		preg_match("/Status:(\d);Success/is",$curl_result,$match);
		if (count($match)>0) 
			return true;
		else
			return false;
	}
?>