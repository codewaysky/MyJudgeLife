<?php
	/** MyJudgeLife
		配置文件
		
		ORZ WJMZBMR
		
		ORZ plantvsbird
		ORZ lin_toto
	*/
	//如果本引擎在MyOILife中运行，使用true。在其他站点运行，请设置为false。
	define("IN_MYOILIFE",true);
	
	if (IN_MYOILIFE) {
		//在MyOILife内，则直接引用函数及配置文件。
		require_once($_SERVER['DOCUMENT_ROOT']."/include/config.php");
	} else {
		//不在则需要再次定义。
		
		//数据库地址，一般为127.0.0.1或localhost。请注意在Windows环境下切勿使用localhost，否则效率会变得极其低下。
		define("db_host","127.0.0.1");
	
		//数据库名称。
		define("db_name","");
		
		//数据库用户名。
		define("db_user","");
		
		//数据库密码。
		define("db_pass","");
	}
?>