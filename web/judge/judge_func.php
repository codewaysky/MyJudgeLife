<?php
	require_once('judge_header.php');
	function checkstat() {
		$query = "SELECT id FROM judge_machine WHERE enable=1;";
		$result = mysql_query($query);
		$query = "SELECT id FROM judge_machine_stat";
		$result2 = mysql_query($query);
		if (mysql_num_rows($result) != mysql_num_rows($result2)) return false; else return true;
	}
	function refresh_machine_stat() {
		/**
		  * �˺�������ˢ���������״̬��
		  * �����״̬��������ݿ�һ��Memory����ı��С�
		  * ���ԣ����������ݿ⵱���������ݶ�ʧ��ʱ�򣬵��øú�����ˢ��״̬��
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
?>