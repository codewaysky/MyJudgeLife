<?php
	/** MyJudgeLife
		�����ļ�
		
		ORZ WJMZBMR
		
		ORZ plantvsbird
		ORZ lin_toto
	*/
	//�����������MyOILife�����У�ʹ��true��������վ�����У�������Ϊfalse��
	define("IN_MYOILIFE",true);
	
	if (IN_MYOILIFE) {
		//��MyOILife�ڣ���ֱ�����ú����������ļ���
		require_once("/include/config.php");
	} else {
		//��������Ҫ�ٴζ��塣
		
		//���ݿ��ַ��һ��Ϊ127.0.0.1��localhost����ע����Windows����������ʹ��localhost������Ч�ʻ��ü�����¡�
		define("db_host","127.0.0.1");
	
		//���ݿ����ơ�
		define("db_name","myoilife_com_oidb");
		
		//���ݿ��û�����
		define("db_user","oiconnect");
		
		//���ݿ����롣
		define("db_pass","74A4311E11FA956203EBA4EE2B9DEF16");
		
		//������Щ�û���������ʲô�ĺ�MyOILife�Ķ���һ���ģ����Բ���̫����Ŷ~
	}
?>