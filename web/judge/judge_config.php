<?php
	/** MyJudgeLife
		�����ļ�
		
		ORZ WJMZBMR
		
		ORZ plantvsbird
		ORZ lin_toto
	*/
	//�����������MyOILife�����У�ʹ��true��������վ�����У�������Ϊfalse��һ�㶼��������
	define("IN_MYOILIFE",false);
	
	if (IN_MYOILIFE) {
		//��MyOILife�ڣ���ֱ�����ú����������ļ���
		require_once($_SERVER['DOCUMENT_ROOT']."/include/config.php");
	} else {
		//��������Ҫ�ٴζ��塣
		
		//���ݿ��ַ��һ��Ϊ127.0.0.1��localhost����ע����Windows����������ʹ��localhost������Ч�ʻ��ü�����¡�
		define("db_host","127.0.0.1");
	
		//���ݿ����ơ�
		define("db_name","judge");
		
		//���ݿ��û�����
		define("db_user","root");
		
		//���ݿ����롣
		define("db_pass","123");
	}
?>